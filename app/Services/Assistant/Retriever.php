<?php

namespace App\Services\Assistant;

use App\Services\Assistant\Data\RetrievedChunk;
use App\Services\Assistant\Support\TextNormalizer;
use App\Services\Assistant\Support\Vector;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/*
| Hybrid retrieval on a database with no vector support.
|
| MariaDB 10.4 cannot rank by vector distance, so the work is split:
|
|   FULLTEXT shortlists a few hundred plausible chunks  (indexed, fast, in SQL)
|   PHP unpacks just those and scores them by cosine    (accurate, small N)
|
| Neither half alone is good enough. FULLTEXT misses paraphrases and synonyms;
| a pure vector scan would mean unpacking every row in the table on every request.
| Together they cost a few milliseconds and behave like a real vector search.
*/
class Retriever
{
    public function __construct(
        private ProviderManager $providers,
        private KnowledgeBase $kb,
    ) {}

    /**
     * @param  int[]  $carryForwardIds  chunk ids the previous answer cited
     * @return RetrievedChunk[]
     */
    public function retrieve(string $question, string $lang, array $carryForwardIds = []): array
    {
        $normalized = TextNormalizer::normalize($question);

        if ($normalized === '') {
            return [];
        }

        $queryVector = $this->queryVector($normalized);
        $queryNorm   = Vector::norm($queryVector);

        $candidates = $this->candidates($normalized, $lang);

        // FULLTEXT found too little to rank - fall back to scanning every chunk in
        // this language. Affordable because a site knowledge base is small, and it
        // is the safety net for Arabic, where stemming is weakest.
        if (count($candidates) < (int) config('assistant.retrieval.top_k', 6) * 3) {
            $candidates = $this->allChunks($lang, $candidates);
        }

        /*
        | Passages the previous answer was built from, resolved into the current
        | turn's language. Scored on their merits like anything else, then
        | re-attached after the cut below even if they score badly, because a
        | follow-up's own words rarely match the thing the visitor means by
        | "those".
        |
        | The id list is kept separately from the rows. When FULLTEXT finds
        | little, allChunks() loads every chunk in the language, so a carried
        | chunk is usually already a candidate - and merging it again would be a
        | duplicate while dropping it would lose the referent entirely. Being a
        | candidate is not the same as surviving top_k.
        */
        $carriedRows = $this->carryForward($carryForwardIds, $lang);
        $carriedIds  = array_map(fn ($row) => (int) $row->id, $carriedRows);

        $known = array_flip(array_map(fn ($row) => (int) $row->id, $candidates));

        foreach ($carriedRows as $row) {
            if (!isset($known[(int) $row->id])) {
                $candidates[] = $row;
            }
        }

        if ($candidates === []) {
            return [];
        }

        $maxFulltext = max(array_map(fn ($row) => (float) ($row->ft ?? 0), $candidates)) ?: 1.0;
        $vectorWeight = (float) config('assistant.retrieval.vector_weight', 0.65);
        $weights      = (array) config('assistant.source_weights', []);

        $scored = [];

        foreach ($candidates as $row) {
            $cosine = 0.0;

            if ($queryNorm > 0 && $row->embedding) {
                $cosine = Vector::cosine(
                    $queryVector,
                    Vector::unpack($row->embedding),
                    $queryNorm,
                    (float) $row->norm
                );
            }

            $fulltext = ((float) ($row->ft ?? 0)) / $maxFulltext;

            // No vectors stored yet (embedding provider down during indexing):
            // fall back to keyword relevance alone rather than scoring everything 0.
            $score = $queryVector === []
                ? $fulltext
                : ($vectorWeight * $cosine) + ((1 - $vectorWeight) * $fulltext);

            $score *= (float) ($weights[$row->source_type] ?? 1.0);

            $scored[] = new RetrievedChunk(
                id:         (int) $row->id,
                content:    (string) $row->content,
                title:      (string) ($lang === 'ar' && $row->title_ar ? $row->title_ar : $row->title),
                url:        $row->url,
                routeName:  $row->route_name,
                sourceType: (string) $row->source_type,
                score:      $score,
                cosine:     $cosine,
                fulltext:   $fulltext,
            );
        }

        usort($scored, fn ($a, $b) => $b->score <=> $a->score);

        $minScore = (float) config('assistant.retrieval.min_score', 0.42);
        $topK     = (int) config('assistant.retrieval.top_k', 6);

        $primary = array_values(array_filter(
            array_slice($scored, 0, $topK),
            fn (RetrievedChunk $chunk) => $chunk->score >= $minScore
        ));

        if ($carriedIds === []) {
            return $primary;
        }

        return $this->appendCarried($primary, $scored, $carriedIds);
    }

    /**
     * Re-attach the previous answer's passages that this turn's own scoring
     * dropped.
     *
     * Appended after the fresh results rather than merged into the ranking, so a
     * follow-up that does introduce a new topic still leads with the new match.
     * Capped, because every one of these is paid for in tokens on every turn.
     *
     * @param  RetrievedChunk[]  $primary
     * @param  RetrievedChunk[]  $scored
     * @param  int[]             $carriedIds
     * @return RetrievedChunk[]
     */
    private function appendCarried(array $primary, array $scored, array $carriedIds): array
    {
        $already   = array_flip(array_map(fn (RetrievedChunk $chunk) => $chunk->id, $primary));
        $carriedId = array_flip($carriedIds);
        $limit     = (int) config('assistant.conversation.carry_forward', 3);

        foreach ($scored as $chunk) {
            if ($limit <= 0) {
                break;
            }

            if (isset($already[$chunk->id]) || !isset($carriedId[$chunk->id])) {
                continue;
            }

            $primary[] = $chunk;
            $limit--;
        }

        return $primary;
    }

    /**
     * The documents the previous answer cited, as chunks in the current
     * language.
     *
     * Resolved through the document rather than by chunk id, because a visitor
     * can switch language mid-thread: the referent of "those" is the same page,
     * but the passage to hand the model is the one written in the language this
     * turn will be answered in.
     *
     * @param  int[]  $ids
     * @return object[]
     */
    private function carryForward(array $ids, string $lang): array
    {
        $ids = array_values(array_unique(array_filter(array_map('intval', $ids))));

        if ($ids === []) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($ids), '?'));

        $rows = DB::select(
            'SELECT DISTINCT c.id, c.content, c.embedding, c.norm, d.title, d.title_ar, d.url,
                    d.route_name, d.source_type, 0 AS ft
             FROM assistant_chunks previous
             INNER JOIN assistant_chunks c
                     ON c.assistant_document_id = previous.assistant_document_id
                    AND c.lang = ?
             INNER JOIN assistant_documents d ON d.id = c.assistant_document_id
             WHERE previous.id IN (' . $placeholders . ')
             LIMIT 12',
            array_merge([$lang], $ids)
        );

        return $rows;
    }

    /**
     * The query vector, cached so a repeated near-miss question costs nothing.
     *
     * Returns [] when no embedding provider is reachable; the caller then ranks
     * on FULLTEXT alone instead of failing the request.
     */
    private function queryVector(string $normalized): array
    {
        $key = $this->kb->key('qvec.' . TextNormalizer::hash($normalized));

        return Cache::remember($key, now()->addDays((int) config('assistant.cache.embedding_days', 30)), function () use ($normalized) {
            try {
                return $this->providers->embed([$normalized], 'query')[0] ?? [];
            } catch (\Throwable $e) {
                return [];
            }
        });
    }

    /** @return object[] */
    private function candidates(string $normalized, string $lang): array
    {
        // Strip boolean-mode operators; this runs in natural language mode, but a
        // stray + or - from a visitor's question should never reach the parser.
        $terms = trim(preg_replace('/[+\-><()~*"@]+/u', ' ', $normalized));

        if ($terms === '') {
            return [];
        }

        return DB::select(
            'SELECT c.id, c.content, c.embedding, c.norm, d.title, d.title_ar, d.url,
                    d.route_name, d.source_type,
                    MATCH(c.content) AGAINST (? IN NATURAL LANGUAGE MODE) AS ft
             FROM assistant_chunks c
             INNER JOIN assistant_documents d ON d.id = c.assistant_document_id
             WHERE c.lang = ?
               AND MATCH(c.content) AGAINST (? IN NATURAL LANGUAGE MODE)
             ORDER BY ft DESC
             LIMIT ' . (int) config('assistant.retrieval.candidates', 250),
            [$terms, $lang, $terms]
        );
    }

    /**
     * Every chunk in a language, excluding ones the shortlist already returned.
     *
     * @param  object[]  $existing
     * @return object[]
     */
    private function allChunks(string $lang, array $existing): array
    {
        $rows = DB::select(
            'SELECT c.id, c.content, c.embedding, c.norm, d.title, d.title_ar, d.url,
                    d.route_name, d.source_type, 0 AS ft
             FROM assistant_chunks c
             INNER JOIN assistant_documents d ON d.id = c.assistant_document_id
             WHERE c.lang = ? AND c.embedding IS NOT NULL
             LIMIT 4000',
            [$lang]
        );

        $seen = array_flip(array_map(fn ($row) => (int) $row->id, $existing));

        foreach ($rows as $row) {
            if (!isset($seen[(int) $row->id])) {
                $existing[] = $row;
            }
        }

        return $existing;
    }
}

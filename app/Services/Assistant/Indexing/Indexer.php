<?php

namespace App\Services\Assistant\Indexing;

use App\Models\AssistantChunk;
use App\Models\AssistantDocument;
use App\Services\Assistant\Indexing\Sources\BlogSource;
use App\Services\Assistant\Indexing\Sources\FrontendSectionSource;
use App\Services\Assistant\Indexing\Sources\ServiceRouteSource;
use App\Services\Assistant\KnowledgeBase;
use App\Services\Assistant\ProviderManager;
use App\Services\Assistant\Support\LanguageGuard;
use App\Services\Assistant\Support\Vector;
use Illuminate\Support\Facades\DB;

/*
| Walks every knowledge source, chunks what changed, embeds it and stores it.
|
| Incremental by default: a document whose body hash is unchanged is skipped
| without an embedding call, so a scheduled run over untouched content costs
| nothing. Pass --fresh when the embedding model or the dimension count changes,
| since stored vectors are then no longer comparable.
*/
class Indexer
{
    /** Chunks accumulated before an embedding call is made. */
    private const EMBED_BATCH = 48;

    /** @var array<int, array{chunk: AssistantChunk, text: string}> */
    private array $pending = [];

    private array $stats = [
        'documents' => 0,
        'skipped'   => 0,
        'chunks'    => 0,
        'embedded'  => 0,
        'removed'   => 0,
        'errors'    => [],
        'gaps'      => [],
    ];

    private $progress = null;

    /** Document ids that have at least one chunk with no vector. */
    private array $missingEmbeddings = [];

    public function __construct(
        private ProviderManager $providers,
        private KnowledgeBase $kb,
    ) {}

    /** @return KnowledgeSource[] */
    public function sources(): array
    {
        return [
            new ServiceRouteSource,
            new FrontendSectionSource,
            new BlogSource,
        ];
    }

    public function onProgress(callable $callback): self
    {
        $this->progress = $callback;

        return $this;
    }

    public function run(bool $fresh = false): array
    {
        if ($fresh) {
            // Chunks cascade from documents.
            AssistantDocument::query()->delete();
        }

        /*
        | Documents whose text is unchanged but whose vectors never got written -
        | the embedding provider was down, or its key was added after the first
        | index. Collected in one query so the skip check below stays free, and so
        | that simply re-running the command heals them, as its own warning promises.
        */
        $this->missingEmbeddings = array_flip(
            AssistantChunk::whereNull('embedding')
                ->distinct()
                ->pluck('assistant_document_id')
                ->all()
        );

        $chunker = Chunker::fromConfig();
        $seen    = [];

        foreach ($this->sources() as $source) {
            $type = $source->type();

            foreach ($source->documents() as $payload) {
                $seen[$type][] = $payload['source_key'];

                try {
                    $this->indexDocument($source, $payload, $chunker);
                } catch (\Throwable $e) {
                    $this->stats['errors'][] = "{$type}/{$payload['source_key']}: {$e->getMessage()}";
                }
            }
        }

        $this->flush();
        $this->prune($seen);

        $this->kb->bump();

        return $this->stats;
    }

    private function indexDocument(KnowledgeSource $source, array $payload, Chunker $chunker): void
    {
        $bodies = array_filter(array_map('trim', $payload['bodies'] ?? []));

        if ($bodies === []) {
            return;
        }

        /*
        | File each body under the language it is actually written in, not the one
        | the source claimed. Amlaek's `_ar` twin columns are hand-filled and are
        | routinely wrong; indexing them verbatim is what put Arabic passages in
        | the English index and left English text answering Arabic questions.
        |
        | Done before hashing, so correcting the underlying CMS row changes the
        | hash and the document reindexes on the next run.
        */
        $reconciled = LanguageGuard::reconcile($bodies);
        $bodies     = $reconciled['bodies'];

        // Reported before the skip check below, so an unchanged document still
        // shows up in the gap report on every run rather than only the first.
        foreach ($reconciled['gaps'] as $gap) {
            $this->stats['gaps'][] = "{$source->type()}/{$payload['source_key']}: {$gap}";
        }

        if ($bodies === []) {
            return;
        }

        $hash = sha1(json_encode($bodies, JSON_UNESCAPED_UNICODE));

        $document = AssistantDocument::firstOrNew([
            'source_type' => $source->type(),
            'source_key'  => $payload['source_key'],
        ]);

        // Unchanged since the last run AND fully embedded - nothing to do.
        if ($document->exists
            && $document->body_hash === $hash
            && ! isset($this->missingEmbeddings[$document->id])) {
            $this->stats['skipped']++;

            return;
        }

        $document->fill([
            'route_name' => $payload['route_name'] ?? null,
            'url'        => $payload['url'] ?? null,
            'title'      => $payload['title'] ?? '',
            'title_ar'   => $payload['title_ar'] ?? null,
            'body_hash'  => $hash,
            'indexed_at' => now(),
        ])->save();

        $document->chunks()->delete();

        $count = 0;

        foreach ($bodies as $lang => $body) {
            foreach ($chunker->split($body) as $ordinal => $text) {
                $chunk = $document->chunks()->create([
                    'ordinal' => $ordinal,
                    'lang'    => $lang,
                    'content' => $text,
                    'dim'     => 0,
                    'norm'    => 0,
                ]);

                $this->queueForEmbedding($chunk, $text);
                $count++;
            }
        }

        $document->forceFill(['chunk_count' => $count])->save();

        $this->stats['documents']++;
        $this->stats['chunks'] += $count;

        $this->report("{$source->type()}/{$payload['source_key']} ({$count} chunks)");
    }

    private function queueForEmbedding(AssistantChunk $chunk, string $text): void
    {
        $this->pending[] = ['chunk' => $chunk, 'text' => $text];

        if (count($this->pending) >= self::EMBED_BATCH) {
            $this->flush();
        }
    }

    /**
     * Embed everything queued so far.
     *
     * A failure here is logged but not fatal: chunks stay searchable through the
     * FULLTEXT index, so the help centre degrades to keyword search rather than
     * going down. Re-running the command fills the missing vectors in.
     */
    private function flush(): void
    {
        if ($this->pending === []) {
            return;
        }

        $batch         = $this->pending;
        $this->pending = [];

        try {
            $vectors = $this->providers->embed(array_column($batch, 'text'), 'document');
        } catch (\Throwable $e) {
            $this->stats['errors'][] = 'Embedding batch failed: ' . $e->getMessage();

            return;
        }

        DB::transaction(function () use ($batch, $vectors) {
            foreach ($batch as $i => $item) {
                $values = $vectors[$i] ?? [];

                if ($values === []) {
                    continue;
                }

                $item['chunk']->forceFill([
                    'embedding' => Vector::pack($values),
                    'dim'       => count($values),
                    'norm'      => Vector::norm($values),
                ])->save();

                $this->stats['embedded']++;
            }
        });
    }

    /**
     * Drop documents whose source object no longer exists.
     *
     * @param  array<string, string[]>  $seen
     */
    private function prune(array $seen): void
    {
        foreach ($seen as $type => $keys) {
            $removed = AssistantDocument::where('source_type', $type)
                ->whereNotIn('source_key', $keys)
                ->get();

            foreach ($removed as $document) {
                $document->delete();
                $this->stats['removed']++;
            }
        }
    }

    private function report(string $line): void
    {
        if ($this->progress) {
            ($this->progress)($line);
        }
    }
}

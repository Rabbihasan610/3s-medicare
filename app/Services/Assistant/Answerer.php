<?php

namespace App\Services\Assistant;

use App\Models\AssistantConversation;
use App\Models\AssistantQuery;
use App\Services\Assistant\Contracts\ChatDriver;
use App\Services\Assistant\Data\AnswerResult;
use App\Services\Assistant\Data\RetrievedChunk;
use App\Services\Assistant\Support\LanguageGuard;
use App\Services\Assistant\Support\TextNormalizer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route as RouteFacade;

/*
| Orchestrates one visitor question end to end.
|
| Answer cache -> retrieval -> prompt -> provider -> log. Every exit path writes a
| row to assistant_queries, including the cached and refused ones: a help centre
| whose logs only contain successes tells you nothing about what it is failing at,
| and "what did people ask that we could not answer" is the single most valuable
| report this feature produces.
*/
class Answerer
{
    public function __construct(
        private Retriever $retriever,
        private PromptBuilder $prompts,
        private AnswerCache $cache,
        private ProviderManager $providers,
        private ConversationStore $conversations,
    ) {}

    public function ask(string $question, array $context = []): array
    {
        $started = microtime(true);

        /*
        | The language to answer in.
        |
        | The site toggle is a hint, not the verdict: a visitor who types Arabic
        | into the English site is asking in Arabic and must be answered in
        | Arabic. This matters more here than it looks, because the retriever
        | filters chunks by language - resolving this wrong hands the model
        | passages in a language the visitor cannot read, and the answer is then
        | written in that language too.
        |
        | Resolved once, here, so both surfaces (the /ask page and the widget)
        | and every downstream step - retrieval, prompt, cache key - agree.
        */
        $lang = LanguageGuard::resolve(
            $question,
            $context['lang'] ?? (session('lang') === 'ar' ? 'ar' : 'en')
        );

        $normalized = TextNormalizer::normalize($question);
        $hash       = TextNormalizer::hash($normalized . '|' . $lang);

        if ($normalized === '') {
            return $this->refusal($lang, null);
        }

        /*
        | The thread this question arrived on.
        |
        | History and carry-forward are both read BEFORE the current question is
        | recorded, or the message being answered would appear twice - once in
        | the replayed history and again as the question itself.
        |
        | Threading is best-effort throughout: ConversationStore returns null
        | rather than throwing, and everything below still answers the question
        | as a standalone one.
        */
        $conversation   = $this->conversations->resolve($context['conversation'] ?? null, $lang, $context);
        $history        = $this->conversations->history($conversation);
        $carryForward   = $this->conversations->carryForwardIds($conversation);
        $isFollowUp     = $history !== [];

        $this->conversations->recordQuestion($conversation, mb_substr($question, 0, 2000), $lang);

        /*
        | 1. Repeat question - never reaches retrieval or the model.
        |
        | Bypassed entirely for a follow-up. The cache is keyed on the question
        | text alone, but a follow-up's meaning comes from the turns before it -
        | "and how much does it cost?" is a different question in every thread it
        | appears in, and serving one thread's cached answer to another would be
        | wrong in a way the visitor cannot see.
        */
        if (!$isFollowUp && $cached = $this->cache->get($hash, $lang)) {
            $row = $this->log($question, $normalized, $hash, $lang, $context, [
                'answer'          => $cached->answer,
                'sources'         => $cached->sources,
                'suggested_route' => $cached->suggested_route,
                'confidence'      => $cached->confidence,
                'cache_layer'     => 'answer',
                'status'          => 'ok',
                'latency_ms'      => (int) ((microtime(true) - $started) * 1000),
            ]);

            $this->conversations->recordAnswer($conversation, $cached->answer, $cached->sources ?? [], $lang, 'ok', $row);

            return $this->present(
                $cached->answer, $cached->sources ?? [], $cached->suggested_route, $cached->confidence,
                $lang, $row, 'answer', $conversation, $cached->suggested_replies ?? []
            );
        }

        // 2. Retrieval, re-offering whatever the previous answer was built from.
        try {
            $chunks = $this->retriever->retrieve($question, $lang, $carryForward);
        } catch (\Throwable $e) {
            return $this->fail($question, $normalized, $hash, $lang, $context, $started, $e, $conversation);
        }

        if ($chunks === []) {
            $row = $this->log($question, $normalized, $hash, $lang, $context, [
                'status'     => 'no_answer',
                'latency_ms' => (int) ((microtime(true) - $started) * 1000),
            ]);

            return $this->refusal($lang, $row, $conversation);
        }

        // 3. Ask the model.
        try {
            /** @var AnswerResult $result */
            $result = $this->providers->run('chat',
                fn (ChatDriver $driver) => $driver->answer($this->prompts->build($question, $lang, $chunks, $history))
            );
        } catch (\Throwable $e) {
            Log::warning('AI Chat provider exception (using local chunk fallback): ' . $e->getMessage());

            if (!empty($chunks)) {
                $bestChunk = $chunks[0];
                $snippet = trim(preg_replace('/\s+/', ' ', strip_tags($bestChunk->content)));
                if (mb_strlen($snippet) > 300) {
                    $snippet = mb_substr($snippet, 0, 297) . '...';
                }

                $sources = array_map(fn($c) => $c->toSource('Relevant healthcare information'), array_slice($chunks, 0, 2));
                $suggestedRoute = $bestChunk->routeName ?? (RouteFacade::has('get.quote') ? 'get.quote' : null);

                $row = $this->log($question, $normalized, $hash, $lang, $context, [
                    'model'           => 'fallback-local',
                    'answer'          => $snippet,
                    'sources'         => $sources,
                    'suggested_route' => $suggestedRoute,
                    'confidence'      => 0.85,
                    'status'          => 'ok',
                    'latency_ms'      => (int) ((microtime(true) - $started) * 1000),
                ]);

                $this->conversations->recordAnswer($conversation, $snippet, $sources, $lang, 'ok', $row);

                return $this->present(
                    $snippet,
                    $sources,
                    $suggestedRoute,
                    0.85,
                    $lang,
                    $row,
                    'fallback',
                    $conversation,
                    ['How can I get a quote?', 'What services do you offer?']
                );
            }

            return $this->fail($question, $normalized, $hash, $lang, $context, $started, $e, $conversation);
        }

        $provider = $this->providers->lastUsed();
        $sources  = $this->sourcesFor($result, $chunks);
        $route    = $this->safeRoute($result->suggestedRoute, $chunks);
        $latency  = (int) ((microtime(true) - $started) * 1000);

        $cost = $result->cost(
            (float) ($provider?->param('price_in', 0) ?? 0),
            (float) ($provider?->param('price_out', 0) ?? 0),
            (float) ($provider?->param('price_cached', 0) ?? 0),
        );

        // The model saw the passages and still could not answer from them.
        if (! $result->answered || trim($result->answer) === '') {
            $row = $this->log($question, $normalized, $hash, $lang, $context, [
                'assistant_provider_id' => $provider?->id,
                'model'                 => $result->model,
                'status'                => 'no_answer',
                'confidence'            => $result->confidence,
                'sources'               => $sources,
                'tokens_in'             => $result->tokensIn,
                'tokens_out'            => $result->tokensOut,
                'tokens_cached'         => $result->tokensCached,
                'cost_usd'              => $cost,
                'latency_ms'            => $latency,
            ]);

            return $this->refusal($lang, $row, $conversation);
        }

        // A follow-up's answer is only correct inside its own thread, so it is
        // never written to a cache keyed on the question text alone.
        if (!$isFollowUp) {
            $this->cache->put(
                $hash, $lang, $result->answer, $sources, $route,
                $result->confidence, $result->suggestedReplies
            );
        }

        $row = $this->log($question, $normalized, $hash, $lang, $context, [
            'assistant_provider_id' => $provider?->id,
            'model'                 => $result->model,
            'answer'                => $result->answer,
            'sources'               => $sources,
            'suggested_route'       => $route,
            'confidence'            => $result->confidence,
            'status'                => 'ok',
            // Gemini reports its implicit prefix cache here; 0 means the frozen
            // prefix stopped matching and something volatile crept above the seam.
            'cache_layer'   => $result->tokensCached > 0 ? 'provider' : 'none',
            'tokens_in'     => $result->tokensIn,
            'tokens_out'    => $result->tokensOut,
            'tokens_cached' => $result->tokensCached,
            'cost_usd'      => $cost,
            'latency_ms'    => $latency,
        ]);

        $this->conversations->recordAnswer($conversation, $result->answer, $sources, $lang, 'ok', $row);

        return $this->present(
            $result->answer, $sources, $route, $result->confidence, $lang, $row,
            $result->tokensCached > 0 ? 'provider' : 'none', $conversation, $result->suggestedReplies
        );
    }

    /**
     * Sources the model cited, in the order it cited them.
     *
     * Falls back to the retrieved set when the model returns no ids, so the
     * visitor always gets something to click through to.
     *
     * @param  RetrievedChunk[]  $chunks
     */
    private function sourcesFor(AnswerResult $result, array $chunks): array
    {
        $byId = [];
        foreach ($chunks as $chunk) {
            $byId[$chunk->id] = $chunk;
        }

        /*
        | The grounding guard. Only ids the model was actually handed become
        | cards, and the model's own text contributes nothing but the `reason`
        | line - the title, URL and type are read back off the retrieved row.
        */
        $sources = [];
        foreach ($result->sourceIds as $id) {
            if (isset($byId[$id])) {
                $sources[] = $byId[$id]->toSource($result->reasons[$id] ?? null);
            }
        }

        if ($sources === []) {
            $sources = array_map(
                fn (RetrievedChunk $c) => $c->toSource($result->reasons[$c->id] ?? null),
                array_slice($chunks, 0, 3)
            );
        }

        // One link per destination - several chunks often come from one page.
        $seen = [];

        return array_values(array_filter($sources, function ($source) use (&$seen) {
            $key = $source['url'] ?? $source['title'];
            if (isset($seen[$key])) {
                return false;
            }
            $seen[$key] = true;

            return true;
        }));
    }

    /**
     * Never trust a model-supplied route name.
     *
     * It must be a real named route AND have been present in the passages we
     * actually retrieved, otherwise the CTA could point anywhere on the site.
     *
     * @param  RetrievedChunk[]  $chunks
     */
    private function safeRoute(?string $route, array $chunks): ?string
    {
        if (blank($route) || ! RouteFacade::has($route)) {
            return null;
        }

        foreach ($chunks as $chunk) {
            if ($chunk->routeName === $route) {
                return $route;
            }
        }

        return null;
    }

    private function present(
        string $answer,
        array $sources,
        ?string $route,
        float $confidence,
        string $lang,
        ?AssistantQuery $row,
        string $cacheLayer,
        ?AssistantConversation $conversation = null,
        array $suggestedReplies = []
    ): array {
        return [
            // Follow-up chips. Model output, so rendered as text nodes only.
            'suggested_replies' => $suggestedReplies,
            // The handle the widget stores so the next message continues this
            // thread. Null when threading was unavailable - the widget then
            // simply asks its next question standalone.
            'conversation' => $conversation?->uuid,
            'status'      => 'ok',
            'answer'      => $answer,
            'sources'     => $sources,
            'route'       => $route,
            'route_url'   => $route && RouteFacade::has($route) ? route($route) : null,
            'confidence'  => $confidence,
            'lang'        => $lang,
            'query_id'    => $row?->id,
            'cache_layer' => $cacheLayer,
        ];
    }

    private function refusal(string $lang, ?AssistantQuery $row, ?AssistantConversation $conversation = null): array
    {
        // Recorded like any other turn: a thread that silently skips its
        // refusals reads as though the visitor was never answered at all, and
        // the next follow-up would be replayed against a misleading history.
        $this->conversations->recordAnswer($conversation, '', [], $lang, 'no_answer', $row);

        return [
            'conversation'      => $conversation?->uuid,
            'suggested_replies' => [],
            'status'      => 'no_answer',
            'answer'      => '',
            'sources'     => [],
            'route'       => 'contact',
            'route_url'   => RouteFacade::has('contact') ? route('contact') : null,
            'confidence'  => 0.0,
            'lang'        => $lang,
            'query_id'    => $row?->id,
            'cache_layer' => 'none',
        ];
    }

    private function fail(
        string $question,
        string $normalized,
        string $hash,
        string $lang,
        array $context,
        float $started,
        \Throwable $e,
        ?AssistantConversation $conversation = null
    ): array {
        Log::error('Assistant answer failed', ['error' => $e->getMessage()]);

        $row = $this->log($question, $normalized, $hash, $lang, $context, [
            'status'     => 'error',
            'error'      => $e->getMessage(),
            'latency_ms' => (int) ((microtime(true) - $started) * 1000),
        ]);

        return ['status' => 'error'] + $this->refusal($lang, $row, $conversation);
    }

    private function log(string $question, string $normalized, string $hash, string $lang, array $context, array $attributes): ?AssistantQuery
    {
        try {
            return AssistantQuery::create(array_merge([
                'query'       => mb_substr($question, 0, 2000),
                'query_norm'  => $normalized,
                'query_hash'  => $hash,
                'lang'        => $lang,
                'session_uid' => $context['session_uid'] ?? null,
                'user_id'     => $context['user_id'] ?? null,
                'ip'          => $context['ip'] ?? null,
                'user_agent'  => mb_substr((string) ($context['user_agent'] ?? ''), 0, 255) ?: null,
                'page_url'    => mb_substr((string) ($context['page_url'] ?? ''), 0, 255) ?: null,
            ], $attributes));
        } catch (\Throwable $e) {
            // Logging must never take the answer down with it.
            Log::error('Assistant query log failed', ['error' => $e->getMessage()]);

            return null;
        }
    }
}

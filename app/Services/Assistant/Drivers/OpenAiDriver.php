<?php

namespace App\Services\Assistant\Drivers;

use App\Models\AssistantProvider;
use App\Services\Assistant\Contracts\ChatDriver;
use App\Services\Assistant\Contracts\EmbeddingDriver;
use App\Services\Assistant\Data\AnswerResult;
use App\Services\Assistant\Data\PromptBundle;
use App\Services\Assistant\Support\AnswerShape;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/*
| OpenAI - both roles, like Gemini.
|
| Two shape differences from older OpenAI integrations that are worth knowing,
| because both fail as a 400 rather than as a degraded answer:
|
|   The GPT-5 family takes `max_completion_tokens`; sending `max_tokens` errors.
|
|   It also rejects `temperature` / `top_p` / penalties, so
|   config('assistant.answer.temperature') is not sent here - `reasoning_effort`
|   is the equivalent lever, mirroring Anthropic's `effort`.
|
| Unlike Anthropic there is no explicit cache breakpoint: OpenAI caches long
| prompt prefixes automatically and reports the hit under
| usage.prompt_tokens_details.cached_tokens. Keeping PromptBundle's stable half
| first is still what earns it.
*/
class OpenAiDriver implements ChatDriver, EmbeddingDriver
{
    private const DEFAULT_BASE = 'https://api.openai.com/v1';

    private const DEFAULT_EMBED = 'text-embedding-3-small';

    /** The embeddings endpoint accepts many inputs per call; this caps one batch. */
    private const BATCH_SIZE = 64;

    public function __construct(private AssistantProvider $provider) {}

    // ------------------------------------------------------------------ chat

    public function answer(PromptBundle $prompt): AnswerResult
    {
        $body = $this->post('/chat/completions', [
            'model'    => $this->model(),
            'messages' => [
                ['role' => 'system', 'content' => $prompt->prefix()],
                ['role' => 'user', 'content' => $prompt->suffix()],
            ],
            'max_completion_tokens' => (int) config('assistant.answer.max_output_tokens', 1500),
            'reasoning_effort'      => (string) $this->provider->param('effort', 'low'),
            'response_format'       => [
                'type'        => 'json_schema',
                'json_schema' => [
                    'name'   => 'assistant_answer',
                    'strict' => true,
                    'schema' => $this->responseSchema(),
                ],
            ],
        ]);

        $json  = $this->decodeChoice($body);
        $usage = (array) ($body['usage'] ?? []);

        return new AnswerResult(
            answer:           trim((string) ($json['answer'] ?? '')),
            sourceIds:        array_map('intval', array_filter((array) ($json['source_ids'] ?? []), 'is_numeric')),
            reasons:          AnswerShape::reasons($json),
            suggestedReplies: AnswerShape::suggestedReplies($json),
            suggestedRoute:   $json['suggested_route'] ?? null ?: null,
            confidence:       (float) ($json['confidence'] ?? 0),
            // prompt_tokens already includes the cached portion here, unlike
            // Anthropic - so it is passed through untouched.
            tokensIn:         (int) ($usage['prompt_tokens'] ?? 0),
            tokensOut:        (int) ($usage['completion_tokens'] ?? 0),
            tokensCached:     (int) data_get($usage, 'prompt_tokens_details.cached_tokens', 0),
            model:            (string) ($body['model'] ?? $this->model()),
            answered:         (bool) ($json['answered'] ?? true),
        );
    }

    /*
    | Structured output. `strict: true` requires additionalProperties: false and
    | every property listed in `required` - a partial required list is rejected
    | outright rather than merely allowing the field to be omitted.
    */
    private function responseSchema(): array
    {
        return [
            'type'       => 'object',
            'properties' => [
                'answered'   => ['type' => 'boolean'],
                'answer'     => ['type' => 'string'],
                'source_ids' => ['type' => 'array', 'items' => ['type' => 'integer']],
                // One short line per cited passage explaining why it is worth
                // opening. Ids are re-validated against what was retrieved.
                'source_reasons' => [
                    'type'  => 'array',
                    'items' => [
                        'type'       => 'object',
                        'properties' => [
                            'id'     => ['type' => 'integer'],
                            'reason' => ['type' => 'string'],
                        ],
                        'required'             => ['id', 'reason'],
                        'additionalProperties' => false,
                    ],
                ],
                'suggested_replies' => ['type' => 'array', 'items' => ['type' => 'string']],
                'suggested_route'   => ['type' => 'string'],
                'confidence'        => ['type' => 'number'],
            ],
            'required' => [
                'answered', 'answer', 'source_ids', 'source_reasons',
                'suggested_replies', 'suggested_route', 'confidence',
            ],
            'additionalProperties' => false,
        ];
    }

    private function decodeChoice(array $body): array
    {
        $choice = $body['choices'][0] ?? [];

        if (($choice['finish_reason'] ?? null) === 'length') {
            throw new RuntimeException('OpenAI hit max_completion_tokens; the JSON answer was truncated');
        }

        if (filled($refusal = data_get($choice, 'message.refusal'))) {
            throw new RuntimeException('OpenAI declined the request: ' . mb_substr((string) $refusal, 0, 200));
        }

        $content = data_get($choice, 'message.content');

        if (blank($content)) {
            throw new RuntimeException(
                'OpenAI returned no content (finish_reason: ' . ($choice['finish_reason'] ?? 'unknown') . ')'
            );
        }

        $json = json_decode(trim((string) $content), true);

        if (!is_array($json)) {
            throw new RuntimeException('OpenAI returned malformed JSON: ' . mb_substr((string) $content, 0, 200));
        }

        return $json;
    }

    // ------------------------------------------------------------- embeddings

    public function embed(array $texts, string $type = 'document'): array
    {
        $texts = array_values($texts);

        if ($texts === []) {
            return [];
        }

        $out = [];

        foreach (array_chunk($texts, self::BATCH_SIZE) as $batch) {
            $body = $this->post('/embeddings', [
                'model'      => $this->embeddingModel(),
                'input'      => array_map(fn ($text) => mb_substr($text, 0, 8000), $batch),
                'dimensions' => $this->dimensions(),
            ]);

            $rows = (array) ($body['data'] ?? []);

            /*
            | The response is documented as ordered, but each row carries its own
            | `index` and the vectors must line up with the chunks they were
            | built from. Sorting on it costs nothing and removes the chance of
            | silently attaching every vector to the wrong chunk.
            */
            usort($rows, fn ($a, $b) => ($a['index'] ?? 0) <=> ($b['index'] ?? 0));

            foreach ($rows as $row) {
                $out[] = array_map('floatval', $row['embedding'] ?? []);
            }
        }

        if (count($out) !== count($texts)) {
            throw new RuntimeException(
                'OpenAI returned ' . count($out) . ' embeddings for ' . count($texts) . ' inputs'
            );
        }

        return $out;
    }

    public function dimensions(): int
    {
        return (int) $this->provider->param('dimensions', config('assistant.dimensions', 256));
    }

    // ----------------------------------------------------------------- shared

    public function ping(): bool
    {
        if ($this->provider->purpose === AssistantProvider::PURPOSE_EMBEDDING) {
            $vectors = $this->embed(['connection test'], 'query');

            return count($vectors[0] ?? []) > 0;
        }

        $body = $this->post('/chat/completions', [
            'model'                 => $this->model(),
            'messages'              => [['role' => 'user', 'content' => 'Reply with the single word: ok']],
            'max_completion_tokens' => 512,
        ]);

        if (blank(data_get($body, 'choices.0.message.content'))) {
            $finish = data_get($body, 'choices.0.finish_reason', 'unknown');

            throw new RuntimeException("Reached the API but got no content back (finish_reason: {$finish})");
        }

        return true;
    }

    private function model(): string
    {
        return $this->provider->model;
    }

    private function embeddingModel(): string
    {
        return $this->provider->purpose === AssistantProvider::PURPOSE_EMBEDDING
            ? $this->provider->model
            : (string) $this->provider->param('embedding_model', self::DEFAULT_EMBED);
    }

    private function baseUrl(): string
    {
        return rtrim($this->provider->base_url ?: self::DEFAULT_BASE, '/');
    }

    private function client(): PendingRequest
    {
        $key = $this->provider->api_key;

        if (blank($key)) {
            throw new RuntimeException('No API key stored for provider "' . $this->provider->name . '"');
        }

        return Http::withToken($key)
            ->timeout((int) $this->provider->param('timeout', 45))
            ->connectTimeout(10)
            ->retry(2, 400, throw: false)
            ->acceptJson();
    }

    private function post(string $path, array $payload): array
    {
        $response = $this->client()->post($this->baseUrl() . $path, $payload);

        if ($response->failed()) {
            // OpenAI puts the useful part in error.message; the raw body is huge.
            $message = data_get($response->json(), 'error.message')
                ?: mb_substr((string) $response->body(), 0, 300);

            throw new RuntimeException("OpenAI HTTP {$response->status()}: {$message}");
        }

        return (array) $response->json();
    }
}

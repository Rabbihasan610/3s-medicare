<?php

namespace App\Services\Assistant\Drivers;

use App\Models\AssistantProvider;
use App\Services\Assistant\Contracts\ChatDriver;
use App\Services\Assistant\Data\AnswerResult;
use App\Services\Assistant\Data\PromptBundle;
use App\Services\Assistant\Support\AnswerShape;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/*
| Anthropic (Claude) - answers only.
|
| Anthropic publishes no embeddings endpoint, so this implements ChatDriver
| alone. A provider row created with purpose "embedding" against this driver is
| rejected up front rather than failing later in the middle of a reindex.
|
| Three things here differ from the Gemini driver in ways that are easy to get
| wrong:
|
|   Sampling is gone. `temperature` (and top_p/top_k) are rejected with a 400 on
|   Claude Opus 5 and Sonnet 5, so config('assistant.answer.temperature') is
|   deliberately NOT sent. Determinism comes from the low effort setting and the
|   JSON schema instead.
|
|   Thinking is on by default on Opus 5 and is drawn from the same max_tokens
|   budget as the answer - the identical trap the Gemini driver documents for
|   its own thinkingConfig. The budget below is the configured answer length
|   plus headroom, or the turn ends with stop_reason "max_tokens" and no
|   parseable JSON.
|
|   Cached input tokens are reported separately from `input_tokens` rather than
|   included in it, which the token accounting below has to add back.
*/
class AnthropicDriver implements ChatDriver
{
    private const DEFAULT_BASE = 'https://api.anthropic.com/v1';

    private const API_VERSION = '2023-06-01';

    /*
    | Room for the model's own reasoning on top of the answer budget. Thinking
    | cannot be switched off on Opus 5 above effort "high", and the answer is the
    | last thing generated - too tight a ceiling truncates the JSON.
    */
    private const THINKING_HEADROOM = 3000;

    public function __construct(private AssistantProvider $provider) {}

    public function answer(PromptBundle $prompt): AnswerResult
    {
        /*
        | The stable prefix goes in `system` carrying the cache breakpoint, and
        | the volatile half in `messages`. Anthropic caching is a prefix match,
        | so anything volatile above that breakpoint costs the discount that
        | comes back as cache_read_input_tokens.
        */
        $payload = [
            'model'      => $this->model(),
            'max_tokens' => $this->maxTokens(),
            'system'     => [[
                'type'          => 'text',
                'text'          => $prompt->prefix(),
                'cache_control' => ['type' => 'ephemeral'],
            ]],
            'messages' => [[
                'role'    => 'user',
                'content' => $prompt->suffix(),
            ]],
            'output_config' => array_filter([
                'effort' => $this->effort(),
                'format' => [
                    'type'   => 'json_schema',
                    'schema' => $this->responseSchema(),
                ],
            ], fn ($value) => $value !== null),
        ];

        $body = $this->post('/messages', $payload);
        $json = $this->decodeContent($body);

        $cacheRead  = (int) data_get($body, 'usage.cache_read_input_tokens', 0);
        $cacheWrite = (int) data_get($body, 'usage.cache_creation_input_tokens', 0);

        return new AnswerResult(
            answer:           trim((string) ($json['answer'] ?? '')),
            sourceIds:        array_map('intval', array_filter((array) ($json['source_ids'] ?? []), 'is_numeric')),
            reasons:          AnswerShape::reasons($json),
            suggestedReplies: AnswerShape::suggestedReplies($json),
            suggestedRoute:   $json['suggested_route'] ?? null ?: null,
            confidence:       (float) ($json['confidence'] ?? 0),
            /*
            | Anthropic reports uncached, cache-read and cache-write tokens as
            | three separate figures. AnswerResult::cost() expects tokensIn to be
            | the total and subtracts tokensCached from it, so the total is
            | reassembled here. Cache writes bill slightly above the base input
            | rate, which this does not model - the cost column is indicative.
            */
            tokensIn:         (int) data_get($body, 'usage.input_tokens', 0) + $cacheRead + $cacheWrite,
            tokensOut:        (int) data_get($body, 'usage.output_tokens', 0),
            tokensCached:     $cacheRead,
            model:            (string) ($body['model'] ?? $this->model()),
            answered:         (bool) ($json['answered'] ?? true),
        );
    }

    public function ping(): bool
    {
        $this->guardPurpose();

        /*
        | The budget has to clear the model's own thinking, or a healthy provider
        | comes back empty with stop_reason "max_tokens" and looks broken - the
        | same failure the Gemini driver's ping guards against.
        */
        $payload = [
            'model'      => $this->model(),
            'max_tokens' => 2048,
            'messages'   => [['role' => 'user', 'content' => 'Reply with the single word: ok']],
        ];

        if (($effort = $this->effort()) !== null) {
            $payload['output_config'] = ['effort' => $effort];
        }

        $body = $this->post('/messages', $payload);

        if (($body['stop_reason'] ?? null) === 'refusal') {
            throw new RuntimeException('Reached the API but a safety classifier declined the request');
        }

        return isset($body['id']);
    }

    /*
    | Structured output. `additionalProperties: false` is required on every
    | object, and every property is listed in `required` so a field is never
    | silently absent - the model writes an empty string or an empty array when
    | it has nothing, which the Answerer already handles.
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

    private function decodeContent(array $body): array
    {
        $stop = $body['stop_reason'] ?? null;

        // A safety decline is a provider-level failure, so ProviderManager can
        // fall through to the next configured vendor rather than showing nothing.
        if ($stop === 'refusal') {
            $category = data_get($body, 'stop_details.category') ?: 'unspecified';

            throw new RuntimeException("Claude declined the request (category: {$category})");
        }

        if ($stop === 'max_tokens') {
            throw new RuntimeException('Claude hit max_tokens before finishing; the JSON answer was truncated');
        }

        /*
        | Text blocks only. A response may also carry thinking blocks, and those
        | come first - concatenating everything would put a reasoning summary in
        | front of the JSON and break the decode.
        */
        $text = '';

        foreach ((array) ($body['content'] ?? []) as $block) {
            if (($block['type'] ?? null) === 'text') {
                $text .= $block['text'] ?? '';
            }
        }

        if (trim($text) === '') {
            throw new RuntimeException('Claude returned no text content (stop_reason: ' . ($stop ?? 'unknown') . ')');
        }

        $json = json_decode($text, true);

        if (!is_array($json)) {
            throw new RuntimeException('Claude returned malformed JSON: ' . mb_substr($text, 0, 200));
        }

        return $json;
    }

    /**
     * How hard the model should think, or null when the model has no such control.
     *
     * Haiku predates the effort parameter and rejects it outright, so the field
     * is omitted there rather than sent and 400'd. "default" omits it too, for an
     * operator who wants the model's own behaviour.
     */
    private function effort(): ?string
    {
        if (str_starts_with($this->model(), 'claude-haiku')) {
            return null;
        }

        $effort = (string) $this->provider->param('effort', 'low');

        return $effort === 'default' ? null : $effort;
    }

    private function maxTokens(): int
    {
        $answer = (int) config('assistant.answer.max_output_tokens', 1500);

        return (int) $this->provider->param('max_tokens', $answer + self::THINKING_HEADROOM);
    }

    private function model(): string
    {
        return $this->provider->model;
    }

    private function baseUrl(): string
    {
        return rtrim($this->provider->base_url ?: self::DEFAULT_BASE, '/');
    }

    private function guardPurpose(): void
    {
        if ($this->provider->purpose === AssistantProvider::PURPOSE_EMBEDDING) {
            throw new RuntimeException(
                'Anthropic has no embeddings endpoint. Use Gemini or OpenAI as the embedding provider.'
            );
        }
    }

    private function client(): PendingRequest
    {
        $this->guardPurpose();

        $key = $this->provider->api_key;

        if (blank($key)) {
            throw new RuntimeException('No API key stored for provider "' . $this->provider->name . '"');
        }

        return Http::withHeaders([
            'x-api-key'         => $key,
            'anthropic-version' => self::API_VERSION,
        ])
            ->timeout((int) $this->provider->param('timeout', 45))
            ->connectTimeout(10)
            ->retry(2, 400, throw: false)
            ->acceptJson();
    }

    private function post(string $path, array $payload): array
    {
        $response = $this->client()->post($this->baseUrl() . $path, $payload);

        if ($response->failed()) {
            // Anthropic puts the useful part in error.message; the body is huge.
            $message = data_get($response->json(), 'error.message')
                ?: mb_substr((string) $response->body(), 0, 300);

            throw new RuntimeException("Anthropic HTTP {$response->status()}: {$message}");
        }

        return (array) $response->json();
    }
}

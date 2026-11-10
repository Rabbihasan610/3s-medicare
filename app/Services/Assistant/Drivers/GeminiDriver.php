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
| Google Gemini - both roles.
|
| One vendor covers chat and embeddings here, so a single API key serves the
| whole feature. The registry still keeps them as separate provider rows: the
| chat model and the embedding model version independently, and swapping one
| must not force a reindex of the other.
|
| No SDK. These are two JSON endpoints and Guzzle is already a dependency;
| pulling in a vendor SDK for that would be all cost and no benefit.
*/
class GeminiDriver implements ChatDriver, EmbeddingDriver
{
    private const DEFAULT_BASE  = 'https://generativelanguage.googleapis.com/v1beta';
    private const DEFAULT_EMBED = 'gemini-embedding-001';
    private const BATCH_SIZE    = 64;

    public function __construct(private AssistantProvider $provider) {}

    // ------------------------------------------------------------------ chat

    public function answer(PromptBundle $prompt): AnswerResult
    {
        /*
        | The stable prefix goes in system_instruction and the volatile half in
        | contents. Gemini's implicit caching keys on the leading bytes of the
        | request, so keeping the seam clean is what earns the discount reported
        | back as cachedContentTokenCount.
        */
        $payload = [
            'system_instruction' => [
                'parts' => [['text' => $prompt->prefix()]],
            ],
            'contents' => [[
                'role'  => 'user',
                'parts' => [['text' => $prompt->suffix()]],
            ]],
            'generationConfig' => array_filter([
                'temperature'      => (float) config('assistant.answer.temperature'),
                'maxOutputTokens'  => (int) config('assistant.answer.max_output_tokens'),
                'responseMimeType' => 'application/json',
                'responseSchema'   => $this->responseSchema(),
                'thinkingConfig'   => $this->thinkingConfig(),
            ], fn ($value) => $value !== null),
        ];

        $body = $this->post($this->model() . ':generateContent', $payload);

        if (($reason = data_get($body, 'promptFeedback.blockReason')) !== null) {
            throw new RuntimeException("Gemini blocked the prompt ({$reason})");
        }

        $json = $this->decodeCandidate($body);

        return new AnswerResult(
            answer:           trim((string) ($json['answer'] ?? '')),
            sourceIds:        array_map('intval', array_filter((array) ($json['source_ids'] ?? []), 'is_numeric')),
            reasons:          AnswerShape::reasons($json),
            suggestedReplies: AnswerShape::suggestedReplies($json),
            suggestedRoute:   $json['suggested_route'] ?? null ?: null,
            confidence:       (float) ($json['confidence'] ?? 0),
            tokensIn:         (int) data_get($body, 'usageMetadata.promptTokenCount', 0),
            tokensOut:        (int) data_get($body, 'usageMetadata.candidatesTokenCount', 0),
            tokensCached:     (int) data_get($body, 'usageMetadata.cachedContentTokenCount', 0),
            model:            $this->model(),
            answered:         (bool) ($json['answered'] ?? true),
        );
    }

    /*
    | Gemini 3 models always think, and thinking tokens come out of the same
    | maxOutputTokens budget as the answer - set the budget too low and the turn
    | ends with finishReason MAX_TOKENS and no content at all.
    |
    | "low" roughly halves the reasoning spend (measured: 102 -> 52 thinking
    | tokens on a trivial prompt), which is the right trade for a short answer
    | grounded in passages we already retrieved. Thinking cannot be switched off
    | on this model - thinkingBudget: 0 is rejected with a 400 - so the provider
    | row can raise the level but not remove it. Set thinking_level to "default"
    | to send nothing and let the model decide.
    */
    private function thinkingConfig(): ?array
    {
        $level = (string) $this->provider->param('thinking_level', 'low');

        return $level === 'default' ? null : ['thinkingLevel' => $level];
    }

    /*
    | Structured output. Without it the model wraps prose around the JSON often
    | enough that parsing becomes the flakiest part of the pipeline.
    */
    private function responseSchema(): array
    {
        return [
            'type'       => 'OBJECT',
            'properties' => [
                'answered'   => ['type' => 'BOOLEAN'],
                'answer'     => ['type' => 'STRING'],
                'source_ids' => ['type' => 'ARRAY', 'items' => ['type' => 'INTEGER']],
                // One short line per cited passage explaining why it is worth
                // opening. Ids are re-validated against what was retrieved.
                'source_reasons' => [
                    'type'  => 'ARRAY',
                    'items' => [
                        'type'       => 'OBJECT',
                        'properties' => [
                            'id'     => ['type' => 'INTEGER'],
                            'reason' => ['type' => 'STRING'],
                        ],
                        'required' => ['id', 'reason'],
                    ],
                ],
                'suggested_replies' => ['type' => 'ARRAY', 'items' => ['type' => 'STRING']],
                'suggested_route'   => ['type' => 'STRING'],
                'confidence'        => ['type' => 'NUMBER'],
            ],
            'required' => ['answered', 'answer', 'confidence'],
        ];
    }

    private function decodeCandidate(array $body): array
    {
        $parts = data_get($body, 'candidates.0.content.parts', []);
        $text  = '';
        foreach ($parts as $part) {
            $text .= $part['text'] ?? '';
        }

        if (trim($text) === '') {
            $finish = data_get($body, 'candidates.0.finishReason', 'unknown');
            throw new RuntimeException("Gemini returned no content (finishReason: {$finish})");
        }

        $json = json_decode($text, true);
        if (!is_array($json)) {
            throw new RuntimeException('Gemini returned malformed JSON: ' . mb_substr($text, 0, 200));
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

        $model = 'models/' . $this->embeddingModel();
        $task  = $type === 'query' ? 'RETRIEVAL_QUERY' : 'RETRIEVAL_DOCUMENT';
        $out   = [];

        // The batch endpoint caps how many inputs it accepts per call.
        foreach (array_chunk($texts, self::BATCH_SIZE) as $batch) {
            $requests = array_map(fn ($text) => [
                'model'                => $model,
                'content'              => ['parts' => [['text' => mb_substr($text, 0, 8000)]]],
                'taskType'             => $task,
                'outputDimensionality' => $this->dimensions(),
            ], $batch);

            $body = $this->post($this->embeddingModel() . ':batchEmbedContents', ['requests' => $requests]);

            foreach (data_get($body, 'embeddings', []) as $embedding) {
                $out[] = array_map('floatval', $embedding['values'] ?? []);
            }
        }

        if (count($out) !== count($texts)) {
            throw new RuntimeException(
                'Gemini returned ' . count($out) . ' embeddings for ' . count($texts) . ' inputs'
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

        // Budget has to clear the model's own thinking, or the reply comes back
        // empty with finishReason MAX_TOKENS and a healthy provider looks broken.
        $body = $this->post($this->model() . ':generateContent', array_filter([
            'contents'         => [['role' => 'user', 'parts' => [['text' => 'Reply with the single word: ok']]]],
            'generationConfig' => array_filter([
                'maxOutputTokens' => 512,
                'temperature'     => 0,
                'thinkingConfig'  => $this->thinkingConfig(),
            ], fn ($value) => $value !== null),
        ]));

        if (data_get($body, 'candidates.0.content.parts') === null) {
            $finish = data_get($body, 'candidates.0.finishReason', 'unknown');

            throw new RuntimeException("Reached the API but got no content back (finishReason: {$finish})");
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

        return Http::withHeaders(['x-goog-api-key' => $key])
            ->timeout((int) $this->provider->param('timeout', 45))
            ->connectTimeout(10)
            ->retry(2, 400, throw: false)
            ->acceptJson();
    }

    private function post(string $path, array $payload): array
    {
        $response = $this->client()->post($this->baseUrl() . '/models/' . $path, $payload);

        if ($response->failed()) {
            // Google puts the useful part in error.message; the raw body is huge.
            $message = data_get($response->json(), 'error.message')
                ?: mb_substr((string) $response->body(), 0, 300);

            throw new RuntimeException("Gemini HTTP {$response->status()}: {$message}");
        }

        return (array) $response->json();
    }
}

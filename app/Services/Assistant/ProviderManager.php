<?php

namespace App\Services\Assistant;

use App\Models\AssistantProvider;
use App\Services\Assistant\Contracts\ChatDriver;
use App\Services\Assistant\Contracts\EmbeddingDriver;
use App\Services\Assistant\Drivers\AnthropicDriver;
use App\Services\Assistant\Drivers\GeminiDriver;
use App\Services\Assistant\Drivers\OpenAiDriver;
use Illuminate\Support\Facades\Log;
use RuntimeException;

/*
| Resolves a registered provider row into a working driver, and walks the list by
| priority so one vendor being down does not take the help centre down with it.
|
| Adding a vendor is a class plus one line in $drivers - the admin panel, the
| retrieval pipeline and the logging all keep working untouched.
*/
class ProviderManager
{
    /*
    | Order is the order the admin panel offers them in. Gemini and OpenAI cover
    | both roles; Anthropic answers only - it publishes no embeddings endpoint,
    | and its driver rejects an embedding-purpose row rather than failing later
    | inside a reindex.
    */
    private const DRIVERS = [
        'gemini'    => GeminiDriver::class,
        'anthropic' => AnthropicDriver::class,
        'openai'    => OpenAiDriver::class,
    ];

    /** Which provider actually served the last successful call. */
    private ?AssistantProvider $lastUsed = null;

    public function lastUsed(): ?AssistantProvider
    {
        return $this->lastUsed;
    }

    public static function availableDrivers(): array
    {
        return array_keys(self::DRIVERS);
    }

    public function make(AssistantProvider $provider): ChatDriver|EmbeddingDriver
    {
        $class = self::DRIVERS[$provider->driver] ?? null;

        if (!$class) {
            throw new RuntimeException("No driver registered for \"{$provider->driver}\"");
        }

        return new $class($provider);
    }

    /**
     * Run $callback against each enabled provider for a purpose until one succeeds.
     *
     * Failures are recorded on the row itself so the admin panel can show which
     * provider is unhealthy without anyone reading the log files.
     *
     * @param  callable(ChatDriver|EmbeddingDriver, AssistantProvider): mixed  $callback
     */
    public function run(string $purpose, callable $callback): mixed
    {
        $providers = AssistantProvider::usable($purpose)->get();

        if ($providers->isEmpty()) {
            throw new RuntimeException("No enabled \"{$purpose}\" provider is configured");
        }

        $errors = [];

        foreach ($providers as $provider) {
            try {
                $result = $callback($this->make($provider), $provider);

                $this->lastUsed = $provider;

                if ($provider->last_error) {
                    $provider->forceFill(['last_error' => null, 'last_check_at' => now()])->save();
                }

                return $result;
            } catch (\Throwable $e) {
                $errors[] = "{$provider->name}: {$e->getMessage()}";

                $provider->forceFill([
                    'last_error'    => $e->getMessage(),
                    'last_check_at' => now(),
                ])->save();

                Log::warning('Assistant provider failed', [
                    'provider' => $provider->name,
                    'purpose'  => $purpose,
                    'error'    => $e->getMessage(),
                ]);
            }
        }

        throw new RuntimeException("All {$purpose} providers failed. " . implode(' | ', $errors));
    }

    /** @param string[] $texts */
    public function embed(array $texts, string $type = 'document'): array
    {
        return $this->run(AssistantProvider::PURPOSE_EMBEDDING,
            fn (EmbeddingDriver $driver) => $driver->embed($texts, $type)
        );
    }

    public function embeddingDimensions(): int
    {
        $provider = AssistantProvider::usable(AssistantProvider::PURPOSE_EMBEDDING)->first();

        return (int) ($provider?->param('dimensions') ?? config('assistant.dimensions', 256));
    }
}

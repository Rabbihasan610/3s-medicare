<?php

namespace App\Services\Assistant;

/*
| What each vendor calls its models, roughly what they cost, and where an
| operator goes to get a key.
|
| Offered as suggestions, never as a locked list: the model field stays free
| text so staff can move to a model the vendor released this morning without
| waiting on a deploy. Vendors rename and retire model ids frequently, which is
| exactly why nothing here is enforced.
|
| Prices are USD per million tokens and are indicative only - they seed the
| provider row's price fields, which is what the cost column actually uses. A
| vendor whose prices are not listed here links to its own pricing page instead
| of showing a guessed number that would be read as real.
*/
class ProviderCatalog
{
    /**
     * Suggested model ids per driver and role, best default first.
     *
     * @return array<int, string>
     */
    public static function models(string $driver, string $purpose = 'chat'): array
    {
        $catalog = [
            'gemini' => [
                'chat'      => ['gemini-3.6-flash', 'gemini-flash-latest', 'gemini-flash-lite-latest'],
                'embedding' => ['gemini-embedding-001'],
            ],
            'anthropic' => [
                // Anthropic publishes no embeddings endpoint - the driver
                // rejects an embedding row rather than pretending otherwise.
                'chat'      => ['claude-opus-5', 'claude-sonnet-5', 'claude-haiku-4-5'],
                'embedding' => [],
            ],
            'openai' => [
                'chat'      => ['gpt-5.4-mini', 'gpt-5.4-nano', 'gpt-5.6-luna'],
                'embedding' => ['text-embedding-3-small', 'text-embedding-3-large'],
            ],
        ];

        return $catalog[$driver][$purpose] ?? [];
    }

    /**
     * Indicative list pricing, USD per million tokens.
     *
     * Anthropic's figures are current for the models above. Google's and
     * OpenAI's are deliberately absent rather than guessed - a wrong number here
     * would be entered into the price fields and reported as a real cost.
     *
     * @return array<string, array{input: float, output: float}>
     */
    public static function pricing(string $driver): array
    {
        return match ($driver) {
            'anthropic' => [
                'claude-opus-5'    => ['input' => 5.00, 'output' => 25.00],
                'claude-sonnet-5'  => ['input' => 2.00, 'output' => 10.00],
                'claude-haiku-4-5' => ['input' => 1.00, 'output' => 5.00],
            ],
            default => [],
        };
    }

    /** Where an operator can check current prices and model ids themselves. */
    public static function pricingUrl(string $driver): string
    {
        return match ($driver) {
            'anthropic' => 'https://www.anthropic.com/pricing',
            'openai'    => 'https://openai.com/api/pricing/',
            default     => 'https://ai.google.dev/gemini-api/docs/pricing',
        };
    }

    /** Where an operator creates the API key. */
    public static function keyUrl(string $driver): string
    {
        return match ($driver) {
            'anthropic' => 'https://console.anthropic.com/settings/keys',
            'openai'    => 'https://platform.openai.com/api-keys',
            default     => 'https://aistudio.google.com/apikey',
        };
    }

    /** Display name for the driver select. */
    public static function label(string $driver): string
    {
        return match ($driver) {
            'anthropic' => 'Anthropic (Claude)',
            'openai'    => 'OpenAI (ChatGPT)',
            'gemini'    => 'Google (Gemini)',
            default     => ucfirst($driver),
        };
    }

    /**
     * Whether the driver understands the `effort` parameter at all.
     *
     * Anthropic maps it to output_config.effort and OpenAI to reasoning_effort.
     * Gemini has no equivalent - its driver uses thinking_level instead - so the
     * field is hidden there rather than left looking as though it does something.
     */
    public static function usesEffort(string $driver): bool
    {
        return in_array($driver, ['anthropic', 'openai'], true);
    }
}

<?php

namespace App\Services\Assistant\Data;

/*
| A prompt split along its caching seam.
|
| `system` and `primer` are byte-identical on every request, so providers that
| cache by prefix (Gemini's implicit caching, Anthropic's cache_control) can
| reuse them. Everything that changes per visitor - the retrieved chunks and the
| question itself - lives in `context` and `question`, after that seam.
|
| Reordering these, or letting a timestamp into `primer`, silently destroys the
| cache hit rate. The Insights screen surfaces that as tokens_cached falling to 0.
*/
class PromptBundle
{
    public function __construct(
        public readonly string $system,
        public readonly string $primer,
        public readonly string $context,
        public readonly string $question,
        public readonly string $lang,
        /** @var array<int, array{route:string,label:string}> */
        public readonly array $routes = [],
        /*
        | The conversation so far, already rendered. Empty on a first question.
        |
        | Below the cache seam by necessity: it changes on every turn, and one
        | volatile byte above the seam would cost the prefix discount on the
        | whole system prompt and primer.
        */
        public readonly string $history = '',
    ) {}

    /** The stable half, in the exact order the provider must receive it. */
    public function prefix(): string
    {
        return $this->system . "\n\n" . $this->primer;
    }

    /**
     * The volatile half.
     *
     * Sources first, then the thread, then the question - so the most recent
     * thing the model reads is what it has been asked to answer.
     */
    public function suffix(): string
    {
        $parts = array_filter([$this->context, $this->history, $this->question]);

        return implode("\n\n", $parts);
    }
}

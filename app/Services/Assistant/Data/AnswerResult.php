<?php

namespace App\Services\Assistant\Data;

class AnswerResult
{
    public function __construct(
        public string $answer = '',
        /** @var int[] chunk ids the model says it used */
        public array $sourceIds = [],
        /**
         * Why each cited chunk was cited, keyed by chunk id.
         *
         * The model's own one-line justification, shown on the source card so a
         * visitor can tell which link is worth opening. Text only - the id is
         * validated against what we actually retrieved before anything is
         * rendered, and the title and URL always come from the database row.
         *
         * @var array<int, string>
         */
        public array $reasons = [],
        /**
         * Follow-up questions the model suggests, in the answer's language.
         *
         * Treated as hostile input like any other model output: clipped, capped,
         * and rendered as text nodes rather than markup.
         *
         * @var string[]
         */
        public array $suggestedReplies = [],
        public ?string $suggestedRoute = null,
        public float $confidence = 0.0,
        public int $tokensIn = 0,
        public int $tokensOut = 0,
        public int $tokensCached = 0,
        public string $model = '',
        public bool $answered = true,
    ) {}

    /**
     * Cost in USD from the per-million-token prices on the provider row.
     *
     * Prices are configuration, not hardcoded: vendors change them, and this
     * codebase should not have to be redeployed when they do. Left at 0 the
     * feature still works, the cost column just stays empty.
     */
    public function cost(float $pricePerMillionIn, float $pricePerMillionOut, float $pricePerMillionCached = 0.0): float
    {
        $billableIn = max(0, $this->tokensIn - $this->tokensCached);

        return round(
            ($billableIn / 1_000_000) * $pricePerMillionIn
            + ($this->tokensCached / 1_000_000) * $pricePerMillionCached
            + ($this->tokensOut / 1_000_000) * $pricePerMillionOut,
            6
        );
    }
}

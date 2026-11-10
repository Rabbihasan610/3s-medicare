<?php

namespace App\Services\Assistant\Indexing;

/*
| Splits a document into retrievable pieces.
|
| Boundaries are respected in descending order - paragraph, then sentence, then
| a hard cut - because a chunk that ends mid-sentence embeds badly and reads
| badly when it is quoted back as a source.
|
| Consecutive chunks overlap so an answer that straddles a boundary is still
| fully present in at least one of them.
*/
class Chunker
{
    public function __construct(
        private int $maxChars = 2400,
        private int $overlap = 400,
        private int $minChars = 120,
    ) {}

    public static function fromConfig(): self
    {
        return new self(
            (int) config('assistant.chunk.max_chars', 2400),
            (int) config('assistant.chunk.overlap', 400),
            (int) config('assistant.chunk.min_chars', 120),
        );
    }

    /** @return string[] */
    public function split(string $text): array
    {
        $text = trim(preg_replace('/\n{3,}/u', "\n\n", $text));

        if ($text === '') {
            return [];
        }

        if (mb_strlen($text) <= $this->maxChars) {
            return [$text];
        }

        $chunks = [];
        $buffer = '';

        foreach (preg_split('/\n\s*\n/u', $text) as $paragraph) {
            $paragraph = trim($paragraph);
            if ($paragraph === '') {
                continue;
            }

            // A single paragraph longer than the budget is broken on sentences.
            if (mb_strlen($paragraph) > $this->maxChars) {
                if ($buffer !== '') {
                    $chunks[] = $buffer;
                    $buffer = '';
                }
                foreach ($this->splitSentences($paragraph) as $piece) {
                    $chunks[] = $piece;
                }
                continue;
            }

            $candidate = $buffer === '' ? $paragraph : $buffer . "\n\n" . $paragraph;

            if (mb_strlen($candidate) > $this->maxChars) {
                $chunks[] = $buffer;
                $buffer = $this->tail($buffer) . $paragraph;
            } else {
                $buffer = $candidate;
            }
        }

        if (trim($buffer) !== '') {
            $chunks[] = $buffer;
        }

        // Fold away fragments too short to carry meaning on their own.
        $kept = [];
        foreach ($chunks as $chunk) {
            $chunk = trim($chunk);
            if ($chunk === '') {
                continue;
            }
            if (mb_strlen($chunk) < $this->minChars && $kept !== []) {
                $kept[count($kept) - 1] .= "\n\n" . $chunk;
                continue;
            }
            $kept[] = $chunk;
        }

        return $kept;
    }

    /** @return string[] */
    private function splitSentences(string $paragraph): array
    {
        // Latin full stops plus the Arabic question mark and full stop.
        $sentences = preg_split('/(?<=[.!?؟۔])\s+/u', $paragraph) ?: [$paragraph];

        $out    = [];
        $buffer = '';

        foreach ($sentences as $sentence) {
            $candidate = $buffer === '' ? $sentence : $buffer . ' ' . $sentence;

            if (mb_strlen($candidate) > $this->maxChars && $buffer !== '') {
                $out[]  = trim($buffer);
                $buffer = $this->tail($buffer) . $sentence;
            } else {
                $buffer = $candidate;
            }
        }

        if (trim($buffer) !== '') {
            $out[] = trim($buffer);
        }

        return $out;
    }

    /** Trailing slice of the previous chunk, carried into the next one. */
    private function tail(string $chunk): string
    {
        if ($this->overlap <= 0 || $chunk === '') {
            return '';
        }

        $tail = mb_substr($chunk, -$this->overlap);

        // Start the overlap at a word boundary so it does not open mid-word.
        if (($space = mb_strpos($tail, ' ')) !== false) {
            $tail = mb_substr($tail, $space + 1);
        }

        return trim($tail) . "\n\n";
    }
}

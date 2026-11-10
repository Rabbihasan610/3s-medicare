<?php

namespace App\Services\Assistant\Data;

class RetrievedChunk
{
    public function __construct(
        public int $id,
        public string $content,
        public string $title,
        public ?string $url,
        public ?string $routeName,
        public string $sourceType,
        public float $score,
        public float $cosine = 0.0,
        public float $fulltext = 0.0,
    ) {}

    /**
     * The card the visitor sees for this passage.
     *
     * Title, URL and type come from the database row and never from the model.
     * `$reason` is the one line of model output allowed through, and only after
     * the caller has confirmed the model cited an id it was actually given.
     */
    public function toSource(?string $reason = null): array
    {
        return [
            'id'     => $this->id,
            'title'  => $this->title,
            'url'    => $this->absoluteUrl(),
            'route'  => $this->routeName,
            'type'   => $this->sourceType,
            'reason' => $reason,
            'score'  => round($this->score, 4),
        ];
    }

    /**
     * The stored URL, resolved against the host actually serving the request.
     *
     * Sources store paths so that an index built on one host stays correct on
     * another. Rows written before that change hold a full URL, so anything
     * already absolute is passed through untouched rather than double-prefixed.
     */
    private function absoluteUrl(): ?string
    {
        if (blank($this->url)) {
            return null;
        }

        if (preg_match('#^https?://#i', $this->url)) {
            return $this->url;
        }

        return url($this->url);
    }
}

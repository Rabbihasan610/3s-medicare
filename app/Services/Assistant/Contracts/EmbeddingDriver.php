<?php

namespace App\Services\Assistant\Contracts;

use App\Models\AssistantProvider;

interface EmbeddingDriver
{
    public function __construct(AssistantProvider $provider);

    /**
     * Vectorise a batch of strings.
     *
     * $type is 'document' when indexing and 'query' when answering - several
     * vendors embed the two asymmetrically and retrieval quality suffers if the
     * distinction is dropped.
     *
     * @param  string[]  $texts
     * @return array<int, float[]> one vector per input, same order
     */
    public function embed(array $texts, string $type = 'document'): array;

    public function dimensions(): int;

    public function ping(): bool;
}

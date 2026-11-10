<?php

namespace App\Services\Assistant\Indexing;

/*
| One adapter per content system.
|
| Amlaek keeps content in three unrelated places - the Frontend key/JSON section
| store, the relational BusinessSector tables, and the page builder - plus the
| service routes themselves. Rather than teach the indexer about all of them, each
| gets an adapter that yields the same document shape.
*/
interface KnowledgeSource
{
    /** Stable identifier, also the `source_type` written on every document. */
    public function type(): string;

    /**
     * @return iterable<array{
     *     source_key: string,
     *     route_name: ?string,
     *     url: ?string,
     *     title: string,
     *     title_ar: ?string,
     *     bodies: array<string, string>   language code => plain text
     * }>
     */
    public function documents(): iterable;
}

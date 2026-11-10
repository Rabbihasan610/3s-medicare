<?php

namespace App\Services\Assistant;

use App\Models\AssistantChunk;
use App\Models\AssistantDocument;
use Illuminate\Support\Facades\Cache;

/*
| The knowledge base version.
|
| Every cached answer, every cached query vector and the cached site primer are
| keyed by this integer. Reindexing bumps it, which expires all of them at once
| without a manual flush - and, just as importantly, means `optimize:clear` or
| the in-app /clear route can never leave a stale answer serving.
*/
class KnowledgeBase
{
    private const VERSION_KEY = 'assistant.kb_version';

    /*
    | The SHAPE of a cached answer, bumped in code - not by reindexing.
    |
    | Content changes are handled by the counter below, which a reindex bumps.
    | But a release can also change what a cached row *contains* rather than what
    | it says: shape 2 added the per-source "why this link" line and the
    | follow-up chips. Rows written under an older shape are not wrong, they are
    | incomplete, and serving them would show a visitor cards and chips on a
    | fresh answer but neither on a repeat of the same question.
    |
    | Folding it into the version means a deploy invalidates them on its own. The
    | alternative - remembering to run a command on every environment after every
    | such release - is the kind of step that gets skipped exactly once.
    */
    private const PAYLOAD_SHAPE = 2;

    /** Multiplier that keeps the two revision counters from colliding. */
    private const SHAPE_STRIDE = 1000000;

    public function version(): int
    {
        return self::PAYLOAD_SHAPE * self::SHAPE_STRIDE + $this->contentVersion();
    }

    /** Bumped by a reindex; the half of the version that tracks the content itself. */
    public function contentVersion(): int
    {
        return (int) Cache::rememberForever(self::VERSION_KEY, fn () => 1);
    }

    /**
     * Advance the content revision, expiring every cached answer and vector.
     *
     * Increments contentVersion(), NOT version() - version() already has the
     * payload-shape offset folded in, so incrementing it would fold that offset
     * into the stored counter again on every single reindex.
     */
    public function bump(): int
    {
        Cache::forever(self::VERSION_KEY, $this->contentVersion() + 1);

        return $this->version();
    }

    public function key(string $suffix): string
    {
        return 'assistant.v' . $this->version() . '.' . $suffix;
    }

    public function stats(): array
    {
        return [
            'documents' => AssistantDocument::count(),
            'chunks'    => AssistantChunk::count(),
            'embedded'  => AssistantChunk::whereNotNull('embedding')->count(),
            'ar_chunks' => AssistantChunk::where('lang', 'ar')->count(),
            'en_chunks' => AssistantChunk::where('lang', 'en')->count(),
            'indexed_at' => AssistantDocument::max('indexed_at'),
            // The content revision is the one that means anything to a person;
            // the composite is what keys the caches.
            'version'   => $this->contentVersion(),
        ];
    }
}

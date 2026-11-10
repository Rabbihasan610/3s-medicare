<?php

namespace App\Services\Assistant;

use App\Models\AssistantAnswerCache;

/*
| The cache that actually pays for this feature.
|
| A public services site gets the same few dozen questions over and over. Serving
| those from here means no embedding call, no retrieval, no model call - zero cost
| and single-digit milliseconds.
|
| Entries are keyed by knowledge-base version, so editing content in the admin
| panel expires every stored answer at the next reindex. Nothing has to be
| flushed by hand, and no stale answer can outlive the content it came from.
*/
class AnswerCache
{
    public function __construct(private KnowledgeBase $kb) {}

    public function get(string $hash, string $lang): ?AssistantAnswerCache
    {
        $row = AssistantAnswerCache::where('query_hash', $hash)
            ->where('lang', $lang)
            ->where('kb_version', $this->kb->version())
            ->where('expires_at', '>', now())
            ->first();

        if ($row) {
            // Hit counts drive the "top questions" list on the Insights screen.
            $row->increment('hits');
        }

        return $row;
    }

    /** @param string[] $suggestedReplies */
    public function put(string $hash, string $lang, string $answer, array $sources, ?string $route, float $confidence, array $suggestedReplies = []): void
    {
        AssistantAnswerCache::updateOrCreate(
            [
                'query_hash' => $hash,
                'lang'       => $lang,
                'kb_version' => $this->kb->version(),
            ],
            [
                'answer'            => $answer,
                'sources'           => $sources,
                'suggested_replies' => $suggestedReplies,
                'suggested_route'   => $route,
                'confidence'        => $confidence,
                'expires_at'        => now()->addDays((int) config('assistant.cache.answer_days', 7)),
            ]
        );
    }

    /** Removes expired rows and everything from superseded knowledge-base versions. */
    public function sweep(): int
    {
        return AssistantAnswerCache::where('expires_at', '<', now())
            ->orWhere('kb_version', '<', $this->kb->version())
            ->delete();
    }
}

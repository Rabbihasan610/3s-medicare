<?php

namespace App\Services\Assistant\Support;

/*
| Normalises the two free-form fields a model returns alongside its answer.
|
| Shared by all three drivers so a vendor cannot change what reaches the widget
| just by shaping its JSON differently, and so the clipping and capping rules
| live in one place rather than being re-implemented per driver.
|
| Everything here treats model output as hostile: the caller still validates
| every id against the passages actually retrieved, and the widget renders these
| strings as text nodes. What this class guarantees is only that the types and
| the sizes are what the rest of the pipeline expects.
*/
class AnswerShape
{
    /** One line per source card - long enough to be useful, short enough to read. */
    private const REASON_CHARS = 160;

    /** A suggested reply has to fit on a chip. */
    private const REPLY_CHARS = 80;

    /** More than this and the chips stop being a shortcut and become a menu. */
    private const MAX_REPLIES = 3;

    /**
     * Why each cited passage was cited, keyed by chunk id.
     *
     * @return array<int, string>
     */
    public static function reasons(array $json): array
    {
        $reasons = [];

        foreach ((array) ($json['source_reasons'] ?? []) as $entry) {
            if (!is_array($entry) || !isset($entry['id']) || !is_numeric($entry['id'])) {
                continue;
            }

            $reason = trim((string) ($entry['reason'] ?? ''));

            if ($reason === '') {
                continue;
            }

            $reasons[(int) $entry['id']] = mb_substr($reason, 0, self::REASON_CHARS);
        }

        return $reasons;
    }

    /**
     * Follow-up questions offered as chips.
     *
     * @return string[]
     */
    public static function suggestedReplies(array $json): array
    {
        $replies = [];

        foreach ((array) ($json['suggested_replies'] ?? []) as $reply) {
            if (!is_string($reply)) {
                continue;
            }

            $reply = trim($reply);

            if ($reply === '' || in_array($reply, $replies, true)) {
                continue;
            }

            $replies[] = mb_substr($reply, 0, self::REPLY_CHARS);

            if (count($replies) >= self::MAX_REPLIES) {
                break;
            }
        }

        return $replies;
    }
}

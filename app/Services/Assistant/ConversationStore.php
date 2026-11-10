<?php

namespace App\Services\Assistant;

use App\Models\AssistantConversation;
use App\Models\AssistantMessage;
use App\Models\AssistantQuery;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/*
| Everything the Answerer needs to know about the thread a question arrived on.
|
| Split out rather than inlined because the Answerer's job is already the
| retrieve -> ask -> validate -> log pipeline, and because every method here has
| to fail soft: a conversation that cannot be read or written must degrade to a
| single-turn answer, never to no answer at all. The visitor asked a question -
| losing the thread is a worse outcome than losing the memory of it.
*/
class ConversationStore
{
    /**
     * Resolve the thread this question belongs to, or start one.
     *
     * Returns null when threading is unavailable for any reason, which the
     * Answerer treats as "answer this as a standalone question".
     */
    public function resolve(?string $uuid, string $lang, array $context): ?AssistantConversation
    {
        /*
        | Only threaded surfaces get a thread.
        |
        | The floating widget is a conversation and opts in. The hero ask bar and
        | the /ask page are deliberately not: they are one-shot, shareable
        | answers, and threading them would both bypass the answer cache and make
        | an unrelated search read as a follow-up to whatever the visitor last
        | asked the widget.
        */
        if (blank($uuid) && !($context['thread'] ?? false)) {
            return null;
        }

        try {
            if ($uuid && Str::isUuid($uuid)) {
                $existing = AssistantConversation::where('uuid', $uuid)->first();

                /*
                | A thread is retired once it gets long rather than replayed
                | forever. The visitor is handed a fresh uuid and simply carries
                | on; only the memory of the older turns is dropped.
                */
                if ($existing && $existing->message_count < (int) config('assistant.conversation.max_messages', 40)) {
                    return $existing;
                }
            }

            return AssistantConversation::create([
                'uuid'        => Str::uuid()->toString(),
                'user_id'     => $context['user_id'] ?? null,
                'session_uid' => $context['session_uid'] ?? null,
                'locale'      => $lang,
                'ip'          => $context['ip'] ?? null,
                'user_agent'  => mb_substr((string) ($context['user_agent'] ?? ''), 0, 500) ?: null,
            ]);
        } catch (\Throwable $e) {
            Log::warning('Assistant conversation resolve failed', ['error' => $e->getMessage()]);

            return null;
        }
    }

    /**
     * The last few turns, oldest first, ready for the prompt.
     *
     * Read before the current question is recorded, so the message being
     * answered never appears in both the history block and the question block.
     *
     * @return array<int, array{role: string, content: string}>
     */
    public function history(?AssistantConversation $conversation): array
    {
        if (!$conversation || !$conversation->exists) {
            return [];
        }

        try {
            return $conversation->messages()
                ->orderByDesc('id')
                ->limit((int) config('assistant.conversation.history_turns', 6))
                ->get(['role', 'content'])
                ->reverse()
                ->map(fn (AssistantMessage $message) => [
                    'role'    => $message->role,
                    'content' => $message->content,
                ])
                ->values()
                ->all();
        } catch (\Throwable $e) {
            Log::warning('Assistant history read failed', ['error' => $e->getMessage()]);

            return [];
        }
    }

    /**
     * Chunk ids the most recent answer was grounded on.
     *
     * This is what makes "tell me more about the second one" answerable: those
     * words retrieve nothing on their own, so the passages the visitor is
     * actually referring to are re-offered to the retriever.
     *
     * @return int[]
     */
    public function carryForwardIds(?AssistantConversation $conversation): array
    {
        if (!$conversation || !$conversation->exists) {
            return [];
        }

        try {
            $last = $conversation->messages()
                ->where('role', 'assistant')
                ->whereNotNull('source_ids')
                ->orderByDesc('id')
                ->first(['source_ids']);

            return array_values(array_filter(array_map('intval', (array) ($last->source_ids ?? []))));
        } catch (\Throwable $e) {
            Log::warning('Assistant carry-forward read failed', ['error' => $e->getMessage()]);

            return [];
        }
    }

    /** Record the visitor's own message. */
    public function recordQuestion(?AssistantConversation $conversation, string $question, string $lang): void
    {
        $this->write($conversation, [
            'role'    => 'user',
            'lang'    => $lang,
            'content' => $question,
        ]);
    }

    /**
     * Record the reply, linked to the query row that holds what it cost.
     *
     * @param  array<int, array{id?: int}>  $sources
     */
    public function recordAnswer(
        ?AssistantConversation $conversation,
        string $answer,
        array $sources,
        string $lang,
        string $status,
        ?AssistantQuery $query
    ): void {
        $this->write($conversation, [
            'role'               => 'assistant',
            'lang'               => $lang,
            'content'            => $answer,
            'source_ids'         => array_values(array_filter(array_map(
                fn ($source) => isset($source['id']) ? (int) $source['id'] : null,
                $sources
            ))),
            'status'             => $status,
            'assistant_query_id' => $query?->id,
        ]);
    }

    /**
     * Persistence must never break a reply the visitor has already been given,
     * so every failure here is logged and swallowed.
     */
    private function write(?AssistantConversation $conversation, array $attributes): void
    {
        if (!$conversation || !$conversation->exists) {
            return;
        }

        try {
            $conversation->messages()->create($attributes);

            $conversation->forceFill([
                'message_count'   => $conversation->messages()->count(),
                'last_message_at' => now(),
            ])->save();
        } catch (\Throwable $e) {
            Log::warning('Assistant message write failed', ['error' => $e->getMessage()]);
        }
    }
}

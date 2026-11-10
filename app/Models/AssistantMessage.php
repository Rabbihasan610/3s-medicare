<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
| One turn in a conversation - the visitor's message, or the assistant's reply.
|
| `lang` is stored per message, not per conversation, because the Answerer
| resolves the answer language from the question's own script: a visitor can ask
| in English and follow up in Arabic, and each reply follows its own question.
|
| `source_ids` is populated on assistant rows only. It is what makes a follow-up
| answerable - "tell me more about the second one" retrieves nothing useful on
| its own words, so the previous turn's passages are re-offered to the model.
*/
class AssistantMessage extends Model
{
    protected $guarded = [];

    protected $casts = [
        'source_ids' => 'array',
    ];

    public function conversation()
    {
        return $this->belongsTo(AssistantConversation::class, 'assistant_conversation_id');
    }

    /**
     * The assistant_queries row holding what this turn cost.
     *
     * Named queryLog() rather than query(): Eloquent already has a static
     * Model::query(), and redeclaring it as an instance method is a fatal error.
     */
    public function queryLog()
    {
        return $this->belongsTo(AssistantQuery::class, 'assistant_query_id');
    }
}

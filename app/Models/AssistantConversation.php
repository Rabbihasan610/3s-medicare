<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

/*
| One thread of questions and answers from a single visitor.
|
| The row carries almost no meaning of its own - it exists so that turns can be
| linked, and so the admin panel can show a conversation rather than a pile of
| unrelated questions. What each turn cost stays on assistant_queries.
*/
class AssistantConversation extends Model
{
    use Searchable;

    protected $guarded = [];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    public static $searchable = ['uuid', 'session_uid'];

    public function messages()
    {
        return $this->hasMany(AssistantMessage::class);
    }

    /** Oldest first - the order a transcript reads in. */
    public function transcript()
    {
        return $this->messages()->orderBy('id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

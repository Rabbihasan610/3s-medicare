<?php

namespace App\Models;

use App\Traits\LangDb;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class AssistantDocument extends Model
{
    use LangDb, Searchable;

    protected $guarded = [];

    protected $casts = [
        'indexed_at' => 'datetime',
    ];

    public function chunks()
    {
        return $this->hasMany(AssistantChunk::class);
    }

    /*
    | Ranking nudge from config('assistant.source_weights'). Official service and
    | sector content outranks blog posts, which are often dated or promotional.
    */
    public function weight(): float
    {
        return (float) (config('assistant.source_weights.' . $this->source_type) ?? 1.0);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssistantAnswerCache extends Model
{

    protected $guarded = [];
    protected $casts = [
        'sources'           => 'array',
        'suggested_replies' => 'array',
        'expires_at'        => 'datetime',
    ];

    public function scopeFresh($query)
    {
        return $query->where('expires_at', '>', now());
    }
}

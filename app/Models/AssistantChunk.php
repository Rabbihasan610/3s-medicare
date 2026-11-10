<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssistantChunk extends Model
{

    protected $guarded = [];
    protected $hidden = ['embedding'];

    public function document()
    {
        return $this->belongsTo(AssistantDocument::class, 'assistant_document_id');
    }
}

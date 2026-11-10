<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class AssistantQuery extends Model
{
    use Searchable;

    protected $guarded = [];

    protected $casts = [
        'sources' => 'array',
    ];

    public function provider()
    {
        return $this->belongsTo(AssistantProvider::class, 'assistant_provider_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUnanswered($query)
    {
        return $query->where('status', 'no_answer');
    }

    public function scopeNegative($query)
    {
        return $query->where('feedback', 0);
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(get: function () {
            return match ($this->status) {
                'ok'        => '<span class="badge bg-success">' . trans('Answered') . '</span>',
                'no_answer' => '<span class="badge bg-warning">' . trans('No answer') . '</span>',
                'blocked'   => '<span class="badge bg-dark">' . trans('Blocked') . '</span>',
                default     => '<span class="badge bg-danger">' . trans('Error') . '</span>',
            };
        });
    }

    public function cacheBadge(): Attribute
    {
        return new Attribute(get: function () {
            return match ($this->cache_layer) {
                'answer'   => '<span class="badge bg-primary">' . trans('Answer cache') . '</span>',
                'provider' => '<span class="badge bg-info">' . trans('Provider cache') . '</span>',
                default    => '<span class="badge bg-secondary">' . trans('Live') . '</span>',
            };
        });
    }
}

<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class AssistantProvider extends Model
{
    use GlobalStatus, Searchable;

    protected $guarded = [];

    const PURPOSE_CHAT      = 'chat';
    const PURPOSE_EMBEDDING = 'embedding';

    protected $casts = [
        'params'        => 'array',
        'api_key'       => 'encrypted',
        'last_check_at' => 'datetime',
    ];

    // Keeps the credential out of anything that serialises a model.
    protected $hidden = ['api_key'];

    /*
    | Enabled providers for one role, best first. The caller walks this list and
    | stops at the first one that answers, recording which did on the query row.
    */
    public function scopeUsable($query, string $purpose)
    {
        return $query->where('purpose', $purpose)
            ->where('status', Status::ENABLE)
            ->orderBy('priority')
            ->orderBy('id');
    }

    public function param(string $key, $default = null)
    {
        return $this->params[$key] ?? $default;
    }

    public function hasKey(): bool
    {
        try {
            return filled($this->api_key);
        } catch (\Throwable $e) {
            // Ciphertext encrypted under a different APP_KEY - surfaced by Test connection.
            return false;
        }
    }
}

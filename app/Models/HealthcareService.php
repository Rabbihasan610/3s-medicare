<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthcareService extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_key',
        'group_name',
        'title',
        'slug',
        'icon',
        'short_description',
        'description',
        'image',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function scopeByGroup($query, $groupKey)
    {
        return $query->where('group_key', $groupKey)->where('is_active', true)->orderBy('sort_order');
    }
}


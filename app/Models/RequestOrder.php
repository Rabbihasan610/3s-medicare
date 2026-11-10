<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "service_id",
        "type",
        "form_data",
        "form_checkbox",
        "form_radio",
        "form_file",
        "status",
        "is_seen"
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeSeen($query)
    {
        return $query->where('is_seen', 1);
    }

    public function scopeUnseen($query)
    {
        return $query->where('is_seen', 0);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function service($type, $id)
    {
        if (!$type) {
            return null;
        }

        $file = app_path("Models/{$type}.php");
        if (!file_exists($file)) {
            return null;
        }

        $modelClass = "App\\Models\\" . $type;

        if (class_exists($modelClass)) {
            return $modelClass::find($id);
        }

        return null;
    }
}

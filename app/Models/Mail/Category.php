<?php

namespace App\Models\Mail;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Mail\ContactPerson;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function contacts()
    {
        return $this->hasMany(ContactPerson::class, 'category_id', 'id');
    }

    public function scopeType($query, $type)
    {
        $query->where('type', $type);
    }
}

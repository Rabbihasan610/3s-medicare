<?php

namespace App\Models\Mail;

use App\Models\Mail\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactPerson extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected function scopeType($query, $type)
    {
        return $query->where('type',$type);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        "title",
        "title_ar",
        "image",
        "status"
    ];
}

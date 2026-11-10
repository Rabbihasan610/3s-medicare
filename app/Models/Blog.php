<?php

namespace App\Models;

use App\Traits\LangDb;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory, Searchable, LangDb;

    protected $fillable = [
        "title",
        "title_ar",
        "blog_category_id",
        "slug",
        "description",
        "description_ar",
        "view",
        "image",
        "status"
    ];


    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return asset(getFilePath('blog') . '/');
    }



    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function blog_category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id', 'id');
    }

}

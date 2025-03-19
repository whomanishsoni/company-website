<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'slug',
    ];

    // Many-to-Many relationship with Category
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'blog_category');
    }

    // Many-to-Many relationship with Tag
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'blog_tag');
    }
}

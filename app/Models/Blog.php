<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    // Fields that can be mass-assigned
    protected $fillable = [
        'title',
        'content',
        'slug',
        'image', // Add image field
        'is_featured', // Add is_featured field
        'status', // Add status field
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

    // Automatically format the slug before saving
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = strtolower(str_replace(' ', '-', $value));
    }

    // Accessor for image URL
    public function getImageUrlAttribute()
    {
        // If the image path is stored, return the full URL
        return $this->image ? asset($this->image) : null;
    }
}

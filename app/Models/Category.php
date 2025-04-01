<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            // Generate slug only if it's not provided
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);

                // Check for existing slugs and append number if needed
                $count = Category::where('slug', 'like', "{$category->slug}%")->count();
                if ($count) {
                    $category->slug .= '-' . ($count + 1);
                }
            }
        });

        static::updating(function ($category) {
            // Regenerate slug if name changed and slug wasn't manually set
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);

                // Check for existing slugs (excluding current category)
                $count = Category::where('slug', 'like', "{$category->slug}%")
                    ->where('id', '!=', $category->id)
                    ->count();
                if ($count) {
                    $category->slug .= '-' . ($count + 1);
                }
            }
        });
    }

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_category');
    }
}

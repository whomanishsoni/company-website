<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    // Many-to-Many relationship with Blog
    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_tag');
    }
}
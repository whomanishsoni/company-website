<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $blogs = Blog::with(['categories', 'tags'])
            ->where('status', 'published')
            ->latest()
            ->paginate(6);

        $categories = Category::withCount('blogs')->get();

        return view('frontend.news', compact('blogs', 'categories'));
    }

    public function show($id)
    {
        $blog = Blog::with(['categories', 'tags'])->findOrFail($id);

        $categories = Category::withCount('blogs')->get();

        $relatedPosts = Blog::whereHas('categories', function ($query) use ($blog) {
            $query->whereIn('categories.id', $blog->categories->pluck('id'));
        })
            ->where('id', '!=', $blog->id)
            ->limit(4)
            ->get();

        return view('frontend.single-news', compact('blog', 'categories', 'relatedPosts'));
    }
}
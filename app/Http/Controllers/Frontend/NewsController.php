<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::with(['categories', 'tags'])
            ->where('status', 'published');

        $currentCategory = null;
        $categorySlug = $request->category;

        // Filter by category if provided (using slug)
        if ($categorySlug) {
            $currentCategory = Category::where('slug', $categorySlug)->first();

            if ($currentCategory) {
                $query->whereHas('categories', function ($q) use ($categorySlug) {
                    $q->where('slug', $categorySlug);
                });
            }
        }

        $blogs = $query->latest()->paginate(6);

        $categories = Category::withCount('blogs')->get();

        $popularPosts = $this->getPopularPosts(5);

        $latestNews = Blog::where('status', 'published')
            ->whereNotIn('id', $blogs->pluck('id'))
            ->latest()
            ->limit(4)
            ->get();

        // Check if we have a category filter but no results
        $isEmptyCategory = $categorySlug && $blogs->isEmpty();

        if ($request->ajax()) {
            $renderedCards = $this->renderBlogCards($blogs);
            return response()->json([
                'html' => $renderedCards,
                'next_page_url' => $blogs->nextPageUrl(),
                'isEmptyCategory' => $isEmptyCategory
            ]);
        }

        return view('frontend.news', compact(
            'blogs',
            'categories',
            'popularPosts',
            'latestNews',
            'currentCategory',
            'isEmptyCategory'
        ));
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment views
        $blog->increment('views');

        $categories = Category::withCount('blogs')->get();

        $relatedPosts = Blog::whereHas('categories', function ($query) use ($blog) {
            $query->whereIn('categories.id', $blog->categories->pluck('id'));
        })
            ->where('id', '!=', $blog->id)
            ->where('status', 'published')
            ->limit(4)
            ->get();

        $popularPosts = $this->getPopularPosts(5);

        $latestNews = Blog::where('status', 'published')
            ->where('id', '!=', $blog->id)
            ->latest()
            ->limit(4)
            ->get();

        return view('frontend.single-news', compact(
            'blog',
            'categories',
            'relatedPosts',
            'popularPosts',
            'latestNews'
        ));
    }

    private function getPopularPosts($limit = 5)
    {
        return Blog::where('status', 'published')
            ->orderBy('views', 'desc')
            ->limit($limit)
            ->get(['id', 'title', 'image', 'created_at', 'views', 'slug']);
    }

    private function renderBlogCards($blogs)
    {
        $html = '';

        foreach ($blogs as $blog) {
            $html .= '<div class="bg-white rounded-lg shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl">';
            $html .= '<a href="' . route('news.show', $blog->slug) . '" class="block overflow-hidden group">';
            $html .= '<img src="' . asset($blog->image) . '" alt="' . e($blog->title) . '" class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-105">';
            $html .= '</a>';

            $html .= '<div class="p-6">';
            $html .= '<h2 class="text-xl font-semibold mb-2 group">';
            $html .= '<a href="' . route('news.show', $blog->slug) . '" class="text-gray-800 hover:text-blue-600 transition-colors duration-300">';
            $html .= e($blog->title);
            $html .= '</a></h2>';

            $html .= '<div class="text-sm text-gray-600 mb-4">';
            $html .= '<span class="mr-2"><i class="fas fa-calendar-alt"></i> ' . $blog->created_at->format('M d, Y') . '</span>';

            if ($blog->relationLoaded('categories') && $blog->categories->isNotEmpty()) {
                $html .= '<span><i class="fas fa-folder"></i> ';
                foreach ($blog->categories as $index => $category) {
                    $html .= '<a href="' . route('news.index', ['category' => $category->id]) . '" class="hover:text-blue-600 transition-colors duration-300">' . e($category->name) . '</a>';
                    if ($index < count($blog->categories) - 1) {
                        $html .= ', ';
                    }
                }
                $html .= '</span>';
            }

            $html .= '</div>';

            $decodedContent = html_entity_decode($blog->content);
            $plainContent = strip_tags($decodedContent);
            $excerpt = Str::limit($plainContent, 150);

            $html .= '<div class="text-gray-700 mb-4 line-clamp-3">' . e($excerpt) . '</div>';

            $html .= '<a href="' . route('news.show', $blog->slug) . '" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors duration-300">';
            $html .= 'Read More <span class="ml-1 transition-transform duration-300 group-hover:translate-x-1">→</span>';
            $html .= '</a>';

            $html .= '</div></div>';
        }

        return $html;
    }
}

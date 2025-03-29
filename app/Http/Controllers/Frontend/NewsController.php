<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $blogs = Blog::with(['categories', 'tags'])
            ->where('status', 'published')
            ->latest()
            ->paginate(6);

        $categories = Category::withCount('blogs')->get();

        // Get popular posts (most viewed)
        $popularPosts = $this->getPopularPosts(5);

        // Get latest news (excluding current paginated items)
        $latestNews = Blog::where('status', 'published')
            ->whereNotIn('id', $blogs->pluck('id'))
            ->latest()
            ->limit(4)
            ->get();

        // If it's an AJAX request (infinite scroll), return JSON with rendered cards
        if ($request->ajax()) {
            $renderedCards = $this->renderBlogCards($blogs);
            return response()->json([
                'html' => $renderedCards,
                'next_page_url' => $blogs->nextPageUrl()
            ]);
        }

        return view('frontend.news', compact(
            'blogs',
            'categories',
            'popularPosts',
            'latestNews'
        ));
    }

    public function show($id)
    {
        // Increment views count
        Blog::where('id', $id)->increment('views');

        $blog = Blog::with(['categories', 'tags'])->findOrFail($id);

        $categories = Category::withCount('blogs')->get();

        $relatedPosts = Blog::whereHas('categories', function ($query) use ($blog) {
            $query->whereIn('categories.id', $blog->categories->pluck('id'));
        })
            ->where('id', '!=', $blog->id)
            ->where('status', 'published')
            ->limit(4)
            ->get();

        // Get popular posts (most viewed)
        $popularPosts = $this->getPopularPosts(5);

        // Get latest news (excluding current post)
        $latestNews = Blog::where('status', 'published')
            ->where('id', '!=', $blog->id)
            ->latest()
            ->limit(4)
            ->get();

        // If it's an AJAX request for related posts, return JSON with rendered cards
        if (request()->ajax()) {
            $renderedRelatedCards = $this->renderBlogCards($relatedPosts);
            $renderedLatestNews = $this->renderBlogCards($latestNews);
            return response()->json([
                'related_html' => $renderedRelatedCards,
                'latest_html' => $renderedLatestNews
            ]);
        }

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

            // Blog Image
            $html .= '<a href="' . route('news.show', $blog->slug ?? $blog->id) . '" class="block overflow-hidden group">';
            $html .= '<img src="' . ($blog->image ? Storage::url('blog/' . $blog->image) : asset('images/default-blog-image.jpg')) . '" alt="' . e($blog->title) . '" class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-105">';
            $html .= '</a>';

            // Blog Content
            $html .= '<div class="p-6">';

            // Title
            $html .= '<h2 class="text-xl font-semibold mb-2 group">';
            $html .= '<a href="' . route('news.show', $blog->slug ?? $blog->id) . '" class="text-gray-800 hover:text-blue-600 transition-colors duration-300">';
            $html .= e($blog->title);
            $html .= '</a></h2>';

            // Metadata
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

            // Excerpt
            $decodedContent = html_entity_decode($blog->content);
            $plainContent = strip_tags($decodedContent);
            $excerpt = Str::limit($plainContent, 150);

            $html .= '<div class="text-gray-700 mb-4 line-clamp-3">' . e($excerpt) . '</div>';

            // Read More
            $html .= '<a href="' . route('news.show', $blog->slug ?? $blog->id) . '" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors duration-300">';
            $html .= 'Read More <span class="ml-1 transition-transform duration-300 group-hover:translate-x-1">→</span>';
            $html .= '</a>';

            $html .= '</div></div>';
        }

        return $html;
    }

    private function renderPopularPosts($posts)
    {
        $html = '<div class="bg-white p-6 rounded-lg shadow-lg mb-6">';
        $html .= '<h3 class="text-xl font-semibold mb-4 border-b pb-2">Popular Posts</h3>';
        $html .= '<ul class="space-y-4">';

        foreach ($posts as $post) {
            $html .= '<li class="flex items-start gap-3">';
            $html .= '<a href="' . route('news.show', $post->slug ?? $post->id) . '" class="flex-shrink-0">';
            $html .= '<img src="' . ($post->image ? Storage::url('blog/' . $post->image) : asset('images/default-blog-image.jpg')) . '" alt="' . e($post->title) . '" class="w-16 h-16 object-cover rounded">';
            $html .= '</a>';
            $html .= '<div>';
            $html .= '<a href="' . route('news.show', $post->slug ?? $post->id) . '" class="text-sm font-medium text-gray-800 hover:text-blue-600 transition-colors duration-300 line-clamp-2">';
            $html .= e($post->title);
            $html .= '</a>';
            $html .= '<div class="text-xs text-gray-500 mt-1">' . $post->created_at->format('M d, Y') . '</div>';
            $html .= '</div>';
            $html .= '</li>';
        }

        $html .= '</ul></div>';

        return $html;
    }
}
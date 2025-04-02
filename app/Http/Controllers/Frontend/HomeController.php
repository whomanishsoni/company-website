<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $featuredNews = Blog::with(['categories', 'tags'])
            ->where('status', 'published')
            ->where('is_featured', 1) // Get only featured news (where featured = 1)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('frontend.home', compact('featuredNews'));
    }

    /**
     * Show the services page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function services()
    {
        return view('frontend.services'); // Frontend services page
    }

    /**
     * Show the about page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function about()
    {
        return view('frontend.about'); // Frontend about page
    }

    /**
     * Show the contact page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function contact()
    {
        return view('frontend.contact'); // Frontend contact page
    }
}

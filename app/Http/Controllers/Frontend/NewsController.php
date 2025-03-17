<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Show the news page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('frontend.news'); // Frontend news page
    }

    /**
     * Show a single news article.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id)
    {
        // Fetch the news article from the database based on $id
        // For now, we'll use a placeholder
        return view('frontend.single-news', ['id' => $id]);
    }
}
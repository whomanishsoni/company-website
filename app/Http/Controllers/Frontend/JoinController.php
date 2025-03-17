<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JoinController extends Controller
{
    /**
     * Show the join page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('frontend.join'); // Frontend join page
    }

    /**
     * Handle the join form submission.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);

        // Save the data to the database or send an email
        // For now, we'll just redirect back with a success message
        return redirect()->back()->with('success', 'Thank you for joining us! We will contact you soon.');
    }
}

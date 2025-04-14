<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\MailInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        MailInquiry::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'is_read' => false
        ]);

        Mail::send('emails.contact-form', [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'messageText' => $request->message,
        ], function ($message) use ($request) {
            $message->to(env('MAIL_FROM_ADDRESS'))
                ->subject('New Contact Inquiry: ' . $request->subject)
                ->from($request->email, $request->name); // optional
        });

        return redirect()->back()->with('success', 'Thank you for your message. We will get back to you soon!');
    }
}

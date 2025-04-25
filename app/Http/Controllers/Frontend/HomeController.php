<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\MailInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
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

    public function services()
    {
        return view('frontend.services'); // Frontend services page
    }

    public function about()
    {
        return view('frontend.about'); // Frontend about page
    }

    public function contact()
    {
        return view('frontend.contact'); // Frontend contact page
    }

    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'mobile' => 'nullable|string|max:20',
        ]);

        try {
            // Create mail inquiry record
            $inquiry = MailInquiry::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'mobile' => $validated['mobile'],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'is_read' => false
            ]);

            // Log mail configuration
            Log::info('Attempting to send contact form email', [
                'to' => config('mail.from.address'),
                'mailer' => config('mail.mailer'),
                'host' => config('mail.mailers.smtp.host'),
                'port' => config('mail.mailers.smtp.port'),
                'username' => config('mail.mailers.smtp.username'),
                'encryption' => config('mail.mailers.smtp.encryption'),
                'from_address' => $validated['email'],
                'from_name' => $validated['name'],
            ]);

            // Send email
            Mail::send('emails.contact-form', [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'subject' => $validated['subject'],
                'messageText' => $validated['message'],
                'mobile' => $validated['mobile'],
            ], function ($message) use ($validated) {
                $message->to(config('mail.from.address'))
                    ->subject('New Contact Inquiry: ' . $validated['subject'])
                    ->from($validated['email'], $validated['name']);
            });

            Log::info('Contact form email sent successfully');

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thank you for your message. We will get back to you soon!'
                ]);
            }

            return redirect()->back()->with([
                'status' => 'success',
                'message' => 'Thank you for your message. We will get back to you soon!'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send contact form email', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send message. Please try again.'
                ], 500);
            }

            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Failed to send message: ' . $e->getMessage()
            ]);
        }
    }
}

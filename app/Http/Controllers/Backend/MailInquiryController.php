<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MailInquiry;
use App\Mail\InquiryReplyMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class MailInquiryController extends Controller
{
    public function index(Request $request)
    {
        Log::info('Accessing mail inquiries index', ['user_id' => auth()->id()]);

        if ($request->ajax()) {
            Log::debug('Processing mail inquiries AJAX request');

            try {
                $query = MailInquiry::where('is_trashed', false)
                    ->whereNull('parent_id')
                    ->latest();

                return DataTables::eloquent($query)
                    ->addIndexColumn()
                    ->addColumn('checkbox', function ($inquiry) {
                        return '<input type="checkbox" class="select-checkbox" name="ids[]" value="' . $inquiry->id . '">';
                    })
                    ->addColumn('short_subject', function (MailInquiry $inquiry) {
                        return Str::limit($inquiry->subject, 30);
                    })
                    ->addColumn('status_badge', function (MailInquiry $inquiry) {
                        return $inquiry->is_read
                            ? '<span class="badge bg-primary text-white">Read</span>'
                            : '<span class="badge bg-danger text-white">Unread</span>';
                    })
                    ->addColumn('formatted_date', function (MailInquiry $inquiry) {
                        return $inquiry->created_at->format('d M, Y h:i A');
                    })
                    ->addColumn('actions', function (MailInquiry $inquiry) {
                        return view('backend.mail-inquiries.actions', compact('inquiry'))->render();
                    })
                    ->rawColumns(['checkbox', 'status_badge', 'actions'])
                    ->toJson();
            } catch (\Exception $e) {
                Log::error('Error processing mail inquiries AJAX request', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return response()->json(['error' => 'An error occurred'], 500);
            }
        }

        return view('backend.mail-inquiries.index');
    }


    public function trash(Request $request)
    {
        if ($request->ajax()) {
            $query = MailInquiry::where('is_trashed', true)
                ->latest();

            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($inquiry) {
                    return '<input type="checkbox" class="select-checkbox" name="ids[]" value="' . $inquiry->id . '">';
                })
                ->addColumn('short_subject', function (MailInquiry $inquiry) {
                    return Str::limit($inquiry->subject, 30);
                })
                ->addColumn('status_badge', function (MailInquiry $inquiry) {
                    return $inquiry->is_read
                        ? '<span class="badge bg-primary text-white">Read</span>'
                        : '<span class="badge bg-danger text-white">Unread</span>';
                })
                ->addColumn('formatted_date', function (MailInquiry $inquiry) {
                    return $inquiry->created_at->format('d M, Y h:i A');
                })
                ->addColumn('actions', function (MailInquiry $inquiry) {
                    return view('backend.mail-inquiries.trash-actions', compact('inquiry'))->render();
                })
                ->rawColumns(['checkbox', 'status_badge', 'actions'])
                ->toJson();
        }

        return view('backend.mail-inquiries.trash');
    }


    public function show(MailInquiry $mailInquiry): View
    {
        $mailInquiry->markAsRead();
        return view('backend.mail-inquiries.show', compact('mailInquiry'));
    }

    public function reply(Request $request, MailInquiry $mailInquiry): RedirectResponse
    {
        $validated = $request->validate([
            'reply_content' => 'required|string|min:10|max:5000'
        ]);

        try {
            // Create reply record
            $reply = MailInquiry::create([
                'parent_id' => $mailInquiry->id,
                'email' => $mailInquiry->email,
                'name' => auth()->user()->name,
                'subject' => 'Re: ' . $mailInquiry->subject,
                'message' => $validated['reply_content'],
                'is_read' => true,
                'admin_reply' => true,
                'replied_at' => now()
            ]);

            // Update original inquiry
            $mailInquiry->update([
                'replied_at' => now(),
                'is_read' => true
            ]);

            // Send email
            Mail::to($mailInquiry->email)
                ->send(new InquiryReplyMail($reply));

            return redirect()
                ->route('mail-inquiries.show', $mailInquiry)
                ->with('success', 'Reply sent successfully.');
        } catch (\Exception $e) {
            Log::error("Reply failed for inquiry {$mailInquiry->id}: " . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Failed to send reply. Please try again.');
        }
    }

    public function markAsRead(MailInquiry $mailInquiry): RedirectResponse
    {
        if ($mailInquiry->markAsRead()) {
            return back()->with('success', 'Inquiry marked as read.');
        }
        return back()->with('info', 'Inquiry was already marked as read.');
    }

    public function markAsUnread(MailInquiry $mailInquiry): RedirectResponse
    {
        if ($mailInquiry->markAsUnread()) {
            return back()->with('success', 'Inquiry marked as unread.');
        }
        return back()->with('info', 'Inquiry was already marked as unread.');
    }

    public function moveToTrash(MailInquiry $mailInquiry): RedirectResponse
    {
        $mailInquiry->moveToTrash();
        return redirect()->route('mail-inquiries.index')
            ->with('success', 'Inquiry moved to trash.');
    }

    public function restore(MailInquiry $mailInquiry): RedirectResponse
    {
        $mailInquiry->restoreFromTrash();
        return redirect()->route('mail-inquiries.trash')
            ->with('success', 'Inquiry restored successfully.');
    }

    public function destroy(MailInquiry $mailInquiry): RedirectResponse
    {
        $mailInquiry->delete();
        return redirect()->route('mail-inquiries.trash')
            ->with('success', 'Inquiry permanently deleted.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:mail_inquiries,id',
        ]);

        $count = MailInquiry::whereIn('id', $request->ids)->delete();

        return back()->with('success', "Successfully deleted $count inquiries.");
    }

    public function bulkMoveToTrash(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:mail_inquiries,id',
        ]);

        $count = MailInquiry::whereIn('id', $request->ids)
            ->update(['is_trashed' => true]);

        return back()->with('success', "Successfully moved $count inquiries to trash.");
    }

    public function bulkRestore(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:mail_inquiries,id',
        ]);

        $count = MailInquiry::whereIn('id', $request->ids)
            ->update(['is_trashed' => false]);

        return back()->with('success', "Successfully restored $count inquiries.");
    }
}

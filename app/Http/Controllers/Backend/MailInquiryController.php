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

    public function reply(Request $request, MailInquiry $mailInquiry)
    {
        $validated = $request->validate([
            'reply_content' => 'required|string|min:10|max:5000'
        ]);

        try {
            // Update original inquiry with reply content
            $mailInquiry->update([
                'admin_reply' => $validated['reply_content'],
                'replied_at' => now(),
                'is_read' => true
            ]);

            // Optionally, still create a reply record for tracking
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

            // Send email
            Mail::to($mailInquiry->email)
                ->send(new InquiryReplyMail($reply));

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Reply sent successfully.'
                ]);
            }

            return redirect()
                ->route('mail-inquiries.show', $mailInquiry)
                ->with('success', 'Reply sent successfully.');
        } catch (\Exception $e) {
            Log::error("Reply failed for inquiry {$mailInquiry->id}: " . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send reply. Please try again.'
                ], 500);
            }

            return back()
                ->withInput()
                ->with('error', 'Failed to send reply. Please try again.');
        }
    }

    // public function markAsRead(MailInquiry $mailInquiry): RedirectResponse
    // {
    //     if ($mailInquiry->markAsRead()) {
    //         return back()->with('success', 'Inquiry marked as read.');
    //     }
    //     return back()->with('info', 'Inquiry was already marked as read.');
    // }

    // public function markAsUnread(MailInquiry $mailInquiry): RedirectResponse
    // {
    //     if ($mailInquiry->markAsUnread()) {
    //         return back()->with('success', 'Inquiry marked as unread.');
    //     }
    //     return back()->with('info', 'Inquiry was already marked as unread.');
    // }

    // public function moveToTrash(MailInquiry $mailInquiry): RedirectResponse
    // {
    //     $mailInquiry->moveToTrash();
    //     return redirect()->route('mail-inquiries.index')
    //         ->with('success', 'Inquiry moved to trash.');
    // }

    // public function restore(MailInquiry $mailInquiry): RedirectResponse
    // {
    //     $mailInquiry->restoreFromTrash();
    //     return redirect()->route('mail-inquiries.trash')
    //         ->with('success', 'Inquiry restored successfully.');
    // }

    // public function destroy(MailInquiry $mailInquiry): RedirectResponse
    // {
    //     $mailInquiry->delete();
    //     return redirect()->route('mail-inquiries.trash')
    //         ->with('success', 'Inquiry permanently deleted.');
    // }

    // public function bulkDestroy(Request $request): RedirectResponse
    // {
    //     $request->validate([
    //         'ids' => 'required|array',
    //         'ids.*' => 'exists:mail_inquiries,id',
    //     ]);

    //     $count = MailInquiry::whereIn('id', $request->ids)->delete();

    //     return back()->with('success', "Successfully deleted $count inquiries.");
    // // }
    // public function bulkMoveToTrash(Request $request): RedirectResponse
    // {
    //     $request->validate([
    //         'ids' => 'required|array',
    //         'ids.*' => 'exists:mail_inquiries,id',
    //     ]);

    //     $count = MailInquiry::whereIn('id', $request->ids)
    //         ->update(['is_trashed' => true]);

    //     return back()->with('success', "Successfully moved $count inquiries to trash.");
    // }

    // public function bulkMarkAsRead(Request $request): RedirectResponse
    // {
    //     $request->validate([
    //         'ids' => 'required|string',
    //     ]);

    //     $ids = explode(',', $request->ids);

    //     try {
    //         $count = MailInquiry::whereIn('id', $ids)
    //             ->where('is_read', false)
    //             ->update(['is_read' => true]);

    //         return back()->with('success', "Marked $count email(s) as read.");
    //     } catch (\Exception $e) {
    //         Log::error("Failed to bulk mark as read: " . $e->getMessage());
    //         return back()->with('error', 'Failed to mark emails as read. Please try again.');
    //     }
    // }

    // public function bulkMarkAsUnread(Request $request): RedirectResponse
    // {
    //     $request->validate([
    //         'ids' => 'required|string',
    //     ]);

    //     $ids = explode(',', $request->ids);

    //     try {
    //         $count = MailInquiry::whereIn('id', $ids)
    //             ->where('is_read', true)
    //             ->update(['is_read' => false]);

    //         return back()->with('success', "Marked $count email(s) as unread.");
    //     } catch (\Exception $e) {
    //         Log::error("Failed to bulk mark as unread: " . $e->getMessage());
    //         return back()->with('error', 'Failed to mark emails as unread. Please try again.');
    //     }
    // }
    // public function bulkRestore(Request $request): RedirectResponse
    // {
    //     $request->validate([
    //         'ids' => 'required|array',
    //         'ids.*' => 'exists:mail_inquiries,id',
    //     ]);

    //     $count = MailInquiry::whereIn('id', $request->ids)
    //         ->update(['is_trashed' => false]);

    //     return back()->with('success', "Successfully restored $count inquiries.");
    // }





    // In your MailInquiryController.php

    public function markAsRead(MailInquiry $mailInquiry)
    {
        try {
            $mailInquiry->markAsRead();
            return response()->json([
                'success' => true,
                'message' => 'Inquiry marked as read.'
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to mark inquiry as read: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark as read.'
            ], 500);
        }
    }

    public function markAsUnread(MailInquiry $mailInquiry)
    {
        try {
            $mailInquiry->markAsUnread();
            return response()->json([
                'success' => true,
                'message' => 'Inquiry marked as unread.'
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to mark inquiry as unread: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark as unread.'
            ], 500);
        }
    }

    public function moveToTrash(MailInquiry $mailInquiry)
    {
        try {
            $mailInquiry->moveToTrash();
            return response()->json([
                'success' => true,
                'message' => 'Inquiry moved to trash.'
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to move inquiry to trash: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to move to trash.'
            ], 500);
        }
    }

    public function restore(MailInquiry $mailInquiry)
    {
        try {
            $mailInquiry->restoreFromTrash();
            return response()->json([
                'success' => true,
                'message' => 'Inquiry restored successfully.'
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to restore inquiry: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to restore inquiry.'
            ], 500);
        }
    }

    public function destroy(MailInquiry $mailInquiry)
    {
        try {
            $mailInquiry->delete();
            return response()->json([
                'success' => true,
                'message' => 'Inquiry permanently deleted.'
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to delete inquiry: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete inquiry.'
            ], 500);
        }
    }

    public function bulkMarkAsRead(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:mail_inquiries,id',
        ]);

        try {
            $count = MailInquiry::whereIn('id', $request->ids)
                ->where('is_read', false)
                ->update(['is_read' => true]);

            return response()->json([
                'success' => true,
                'message' => "Marked $count email(s) as read."
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to bulk mark as read: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark emails as read.'
            ], 500);
        }
    }

    public function bulkMarkAsUnread(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:mail_inquiries,id',
        ]);

        try {
            $count = MailInquiry::whereIn('id', $request->ids)
                ->where('is_read', true)
                ->update(['is_read' => false]);

            return response()->json([
                'success' => true,
                'message' => "Marked $count email(s) as unread."
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to bulk mark as unread: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark emails as unread.'
            ], 500);
        }
    }

    public function bulkMoveToTrash(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:mail_inquiries,id',
        ]);

        try {
            $count = MailInquiry::whereIn('id', $request->ids)
                ->update(['is_trashed' => true]);

            return response()->json([
                'success' => true,
                'message' => "Moved $count inquiry(s) to trash."
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to bulk move to trash: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to move inquiries to trash.'
            ], 500);
        }
    }

    public function bulkRestore(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:mail_inquiries,id',
        ]);

        try {
            $count = MailInquiry::whereIn('id', $request->ids)
                ->update(['is_trashed' => false]);

            return response()->json([
                'success' => true,
                'message' => "Restored $count inquiry(s)."
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to bulk restore: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to restore inquiries.'
            ], 500);
        }
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:mail_inquiries,id',
        ]);

        try {
            $count = MailInquiry::whereIn('id', $request->ids)->delete();
            return response()->json([
                'success' => true,
                'message' => "Permanently deleted $count inquiry(s)."
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to bulk delete: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete inquiries.'
            ], 500);
        }
    }
}

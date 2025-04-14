@extends('layouts.backend')

@section('content')
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('mail-inquiries.index') }}">Mail Inquiries</a></li>
                <li class="breadcrumb-item active" aria-current="page">View Inquiry</li>
            </ol>
        </nav>

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Mail Inquiry Details</h1>
            <div>
                @if ($mailInquiry->is_trashed)
                    <form action="{{ route('mail-inquiries.restore', $mailInquiry) }}" method="POST" class="d-inline mr-2">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success">Restore</button>
                    </form>
                @else
                    @if ($mailInquiry->is_read)
                        <form action="{{ route('mail-inquiries.mark-unread', $mailInquiry) }}" method="POST"
                            class="d-inline mr-2">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-warning">Mark as Unread</button>
                        </form>
                    @else
                        <form action="{{ route('mail-inquiries.mark-read', $mailInquiry) }}" method="POST"
                            class="d-inline mr-2">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success">Mark as Read</button>
                        </form>
                    @endif

                    <form action="{{ route('mail-inquiries.move-to-trash', $mailInquiry) }}" method="POST"
                        class="d-inline mr-2">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-secondary">Move to Trash</button>
                    </form>
                @endif

                <form action="{{ route('mail-inquiries.destroy', $mailInquiry) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Are you sure you want to permanently delete this inquiry?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Permanently Delete</button>
                </form>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Inquiry from {{ $mailInquiry->name ?? 'Anonymous' }}
                    <span class="float-right">
                        {!! $mailInquiry->status_badge !!}
                    </span>
                </h6>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Sender Information</h5>
                        <p>
                            <strong>Name:</strong> {{ $mailInquiry->name ?? 'Not provided' }}<br>
                            <strong>Email:</strong>
                            @if ($mailInquiry->email)
                                <a href="mailto:{{ $mailInquiry->email }}">{{ $mailInquiry->email }}</a>
                            @else
                                Not provided
                            @endif
                            <br>
                            <strong>Date:</strong> {{ $mailInquiry->formatted_date }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h5>Technical Information</h5>
                        <p>
                            <strong>IP Address:</strong> {{ $mailInquiry->ip_address ?? 'N/A' }}<br>
                            <strong>User Agent:</strong> {{ Str::limit($mailInquiry->user_agent ?? 'N/A', 50) }}
                        </p>
                    </div>
                </div>

                <div class="mb-4">
                    <h5>Subject</h5>
                    <p>{{ $mailInquiry->subject ?? 'No subject' }}</p>
                </div>

                <div class="mb-4">
                    <h5>Message</h5>
                    <div class="border p-3 bg-light rounded">
                        {!! nl2br(e($mailInquiry->message)) !!}
                    </div>
                </div>

                @if ($mailInquiry->admin_reply)
                    <div class="mb-4">
                        <h5>Your Reply</h5>
                        <div class="border p-3 bg-white rounded">
                            <div class="d-flex justify-content-between mb-2">
                                <small class="text-muted">
                                    Replied on: {{ $mailInquiry->replied_at->format('M d, Y h:i A') }}
                                </small>
                            </div>
                            {!! nl2br(e($mailInquiry->admin_reply)) !!}
                        </div>
                    </div>
                @endif

                @unless ($mailInquiry->is_replied)
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5>Reply to Inquiry</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('mail-inquiries.reply', $mailInquiry) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="reply_content">Your Response</label>
                                    <textarea name="reply_content" id="reply_content" rows="5"
                                        class="form-control @error('reply_content') is-invalid @enderror" required>{{ old('reply_content') }}</textarea>
                                    @error('reply_content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane mr-2"></i> Send Reply
                                </button>
                            </form>
                        </div>
                    </div>
                @endunless
            </div>
        </div>
    </div>
@endsection

{{-- 7P4PbJ9gJqkii8vQr1j57MmT31ZWsQMzi4NAtQMDBSHi --}}

@extends('layouts.backend')

@section('content')
    <div class="container-fluid">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('mail-inquiries.index') }}">Mail Inquiries</a></li>
                <li class="breadcrumb-item active" aria-current="page">View Inquiry</li>
            </ol>
        </nav>

        <!-- Header with actions -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Mail Inquiry Details</h1>
            <div class="btn-group">
                @if ($mailInquiry->is_trashed)
                    <form action="{{ route('mail-inquiries.restore', $mailInquiry) }}" method="POST" class="mr-2">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success">
                            Restore
                        </button>
                    </form>
                @else
                    <form action="{{ route('mail-inquiries.move-to-trash', $mailInquiry) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-danger">
                            Move to Trash
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Main card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    Inquiry from {{ $mailInquiry->name ?? 'Anonymous' }}
                </h6>
            </div>

            <div class="card-body">
                <!-- Sender info -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 class="mb-3 text-primary">Sender Information</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><strong>Name:</strong> {{ $mailInquiry->name ?? 'Not provided' }}</li>
                            <li class="mb-2">
                                <strong>Email:</strong>
                                @if ($mailInquiry->email)
                                    <a href="mailto:{{ $mailInquiry->email }}">{{ $mailInquiry->email }}</a>
                                @else
                                    Not provided
                                @endif
                            </li>
                            <li><strong>Date:</strong> {{ $mailInquiry->formatted_date }}</li>
                        </ul>
                    </div>
                </div>

                <!-- Subject -->
                <div class="mb-4">
                    <h5 class="mb-2 text-primary">Subject</h5>
                    <p class="font-weight-bold">{{ $mailInquiry->subject ?? 'No subject' }}</p>
                </div>

                <!-- Message -->
                <div class="mb-4">
                    <h5 class="mb-2 text-primary">Message</h5>
                    <div class="border p-3 bg-light rounded">
                        {!! nl2br(e($mailInquiry->message)) !!}
                    </div>
                </div>

                <!-- Admin reply if exists -->
                @if ($mailInquiry->replied_at)
                    <div class="mb-4">
                        <h5 class="mb-2 text-primary">Reply</h5>
                        <div class="border p-3 bg-white rounded">
                            <div class="text-muted small mb-2">
                                Replied on: {{ $mailInquiry->replied_at->format('M d, Y h:i A') }}
                            </div>
                            {!! nl2br(e($mailInquiry->admin_reply)) !!}
                        </div>
                    </div>
                @endif

                <!-- Reply form if not replied -->
                @unless ($mailInquiry->is_replied)
                    <div class="card mt-4 border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Reply to Inquiry</h5>
                        </div>
                        <div class="card-body">
                            <form id="replyForm" action="{{ route('mail-inquiries.reply', $mailInquiry) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="reply_content">Response</label>
                                    <textarea name="reply_content" id="reply_content" rows="5"
                                        class="form-control @error('reply_content') is-invalid @enderror" required placeholder="Type your response here...">{{ old('reply_content') }}</textarea>
                                    @error('reply_content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-start">
                                    <a href="{{ route('mail-inquiries.show', $mailInquiry) }}" class="btn btn-secondary mr-2">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <span id="submitText">Reply</span>
                                        <span id="spinner" class="spinner-border spinner-border-sm d-none" role="status"
                                            aria-hidden="true"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    @push('scripts')
                        <script>
                            document.getElementById('replyForm').addEventListener('submit', function(e) {
                                e.preventDefault();

                                // Show processing state
                                const submitBtn = document.getElementById('submitBtn');
                                const submitText = document.getElementById('submitText');
                                const spinner = document.getElementById('spinner');

                                submitBtn.disabled = true;
                                submitText.textContent = 'Sending...';
                                spinner.classList.remove('d-none');

                                // Submit form via AJAX
                                fetch(this.action, {
                                        method: 'POST',
                                        body: new FormData(this),
                                        headers: {
                                            'X-Requested-With': 'XMLHttpRequest',
                                            'Accept': 'application/json'
                                        }
                                    })
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error('Network response was not ok');
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        if (data.success) {
                                            // Reload the page to show the reply
                                            window.location.reload();
                                        } else {
                                            showError(data.message || 'An error occurred');
                                        }
                                    })
                                    .catch(error => {
                                        showError(error.message || 'Failed to send reply');
                                    })
                                    .finally(() => {
                                        submitBtn.disabled = false;
                                        submitText.textContent = 'Reply';
                                        spinner.classList.add('d-none');
                                    });

                                function showError(message) {
                                    // You can implement a better error display mechanism here
                                    alert(message);
                                }
                            });
                        </script>
                    @endpush
                @endunless
            </div>
        </div>
    </div>
@endsection

{{-- 7P4PbJ9gJqkii8vQr1j57MmT31ZWsQMzi4NAtQMDBSHi --}}

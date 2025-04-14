<div class="btn-group" role="group">
    <a href="{{ route('mail-inquiries.show', $inquiry) }}" class="btn btn-primary" title="View Details">
        <i class="fas fa-eye"></i>
    </a>

    @if ($inquiry->is_read)
        <form action="{{ route('mail-inquiries.mark-unread', $inquiry) }}" method="POST" class="d-inline">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-warning" title="Mark as Unread">
                <i class="fas fa-envelope"></i>
            </button>
        </form>
    @else
        <form action="{{ route('mail-inquiries.mark-read', $inquiry) }}" method="POST" class="d-inline">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-success" title="Mark as Read">
                <i class="fas fa-envelope-open"></i>
            </button>
        </form>
    @endif

    <form action="{{ route('mail-inquiries.move-to-trash', $inquiry) }}" method="POST" class="d-inline">
        @csrf
        @method('PUT')
        <button type="submit" class="btn btn-danger" title="Move to Trash">
            <i class="fas fa-trash-alt"></i>
        </button>
    </form>
</div>

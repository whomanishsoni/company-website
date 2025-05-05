<div class="btn-group" role="group">
    <a href="{{ route('mail-inquiries.show', $inquiry) }}" class="btn btn-primary" title="View Details">
        <i class="fas fa-eye"></i>
    </a>

    <form action="{{ route('mail-inquiries.restore', $inquiry) }}" method="POST" class="d-inline">
        @csrf
        @method('PUT')
        <button type="submit" class="btn btn-success restore-btn" title="Restore">
            <i class="fas fa-trash-restore"></i>
        </button>
    </form>

    <form action="{{ route('mail-inquiries.destroy', $inquiry) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger delete-permanently-btn" title="Permanently Delete">
            <i class="fas fa-trash-alt"></i>
        </button>
    </form>
</div>

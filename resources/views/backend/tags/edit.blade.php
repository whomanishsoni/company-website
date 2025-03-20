@extends('layouts.backend')

@section('content')
    <div class="container-fluid">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('tags.index') }}">Tags</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Tag</li>
            </ol>
        </nav>

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Tag</h1>
        </div>

        <form action="{{ route('tags.update', $tag->id) }}" method="POST" id="edit-tag-form">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name', $tag->name) }}" required>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="slug">Slug <span class="text-danger">*</span></label>
                <input type="text" name="slug" id="slug" class="form-control"
                    value="{{ old('slug', $tag->slug) }}" required>
                @error('slug')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('tags.index') }}" class="btn btn-secondary">Cancel</a>
        </form>

    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Automatically generate slug from name
            $('#name').on('input', function() {
                const name = $(this).val();
                const slug = name.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
                $('#slug').val(slug);
            });

            // Form submission validation
            $('#edit-tag-form').on('submit', function(e) {
                // Add any custom validation here if needed
            });
        });
    </script>
@endpush

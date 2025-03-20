@extends('layouts.backend')

@section('content')
    <div class="container-fluid">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blogs.index') }}">Blogs</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Blog</li>
            </ol>
        </nav>

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Blog</h1>
        </div>

        <form action="{{ route('blogs.update', $blog->id) }}" method="POST" id="edit-blog-form">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" id="title" class="form-control"
                    value="{{ old('title', $blog->title) }}" required>
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="content">Content <span class="text-danger">*</span></label>
                <textarea name="content" id="content" class="form-control" rows="5" required>{{ old('content', $blog->content) }}</textarea>
                @error('content')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="slug">Slug <span class="text-danger">*</span></label>
                <input type="text" name="slug" id="slug" class="form-control"
                    value="{{ old('slug', $blog->slug) }}" required>
                @error('slug')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="categories">Categories</label>
                <select name="categories[]" id="categories" class="form-control" multiple>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ in_array($category->id, $blog->categories->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
                @error('categories')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="tags">Tags</label>
                <select name="tags[]" id="tags" class="form-control" multiple>
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}"
                            {{ in_array($tag->id, $blog->tags->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $tag->name }}</option>
                    @endforeach
                </select>
                @error('tags')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" class="form-control-file">
                @if ($blog->image)
                    <img src="{{ $blog->image_url }}" alt="Blog Image" class="img-thumbnail mt-2" width="100">
                @endif
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="is_featured">Featured Post</label>
                <select name="is_featured" id="is_featured" class="form-control">
                    <option value="0" {{ $blog->is_featured ? '' : 'selected' }}>No</option>
                    <option value="1" {{ $blog->is_featured ? 'selected' : '' }}>Yes</option>
                </select>
                @error('is_featured')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="status">Status <span class="text-danger">*</span></label>
                <select name="status" id="status" class="form-control" required>
                    <option value="draft" {{ $blog->status === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ $blog->status === 'published' ? 'selected' : '' }}>Published</option>
                </select>
                @error('status')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('blogs.index') }}" class="btn btn-secondary">Cancel</a>
        </form>

    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Automatically generate slug from title
            $('#title').on('input', function() {
                const title = $(this).val();
                const slug = title.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
                $('#slug').val(slug);
            });

            // Form submission validation
            $('#edit-blog-form').on('submit', function(e) {
                // Add any custom validation here if needed
            });
        });
    </script>
@endpush

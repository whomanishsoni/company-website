@extends('layouts.backend')

@section('content')
    <div class="container-fluid">

        <!-- Error Message -->
        @if ($errors->any())
            <div class="alert alert-danger border-left-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blogs.index') }}">Blogs</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Blog</li>
            </ol>
        </nav>

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Create Blog</h1>
        </div>

        <form action="{{ route('blogs.store') }}" method="POST" id="create-blog-form" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Left side (Title, Slug, Content) -->
                <div class="col-md-8">

                    <div class="form-group">
                        <label for="title">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control" required>
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="slug">Slug <span class="text-danger">*</span></label>
                        <input type="text" name="slug" id="slug" class="form-control" required>
                        @error('slug')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="content">Content <span class="text-danger">*</span></label>
                        <textarea name="content" id="blog-content" class="form-control" rows="5" required></textarea>
                        @error('content')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <!-- Right side (Other Options) -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select name="category" id="category" class="form-control">
                            <option value="">Select a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tags">Tags</label>
                        <select name="tags" id="tags" class="form-control">
                            <option value="">Select a tag</option>
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                        @error('tags')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="is_featured">Featured Post</label>
                        <select name="is_featured" id="is_featured" class="form-control">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                        @error('is_featured')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="image">Featured Image</label>
                        <input type="file" name="image" id="image" class="form-control-file" accept="image/*">
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        {{-- Preview container --}}
                        <div id="image-preview" style="margin-top: 10px;">
                            <img id="preview" src="#" alt="Image Preview"
                                style="display: none; width: 200px; height: 200px; object-fit: cover; border: 1px solid #ccc;" />
                        </div>
                    </div>


                </div>
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{ route('blogs.index') }}" class="btn btn-secondary">Cancel</a>
        </form>

    </div>
@endsection
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#category').select2({
                placeholder: "Select a category",
                allowClear: true,
                width: '100%' // Ensures it matches Bootstrap form-control width
            });
        });
    </script>
@endpush
@push('scripts')
    <script>
        document.getElementById('image').addEventListener('change', function (event) {
            const [file] = this.files;
            if (file) {
                const preview = document.getElementById('preview');
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            }
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#tags').select2({
                placeholder: "Select a tag",
                allowClear: true,
                width: '100%'
            });

            $('#categories').select2({
                placeholder: "Select a category",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endpush


@push('scripts')
    <!-- Include CKEditor from local files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slugify/1.6.5/slugify.min.js"></script>

    <script>
        $(document).ready(function () {
            // Automatically generate slug from title
            // $('#title').on('input', function() {
            //     const title = $(this).val();
            //     // Convert title to slug using slugify
            //     const slug = slugify(title, {
            //         replacement: '-',      // Replace spaces with -
            //         remove: /[*+~.()'"!:@]/g, // Remove special characters
            //         lower: true,          // Convert to lowercase
            //         locale: 'en',         // Use English locale
            //         trim: true            // Trim leading/trailing spaces
            //     });
            //     $('#slug').val(slug);
            // });

            function transliterateToSlug(text) {
                // Map for Hindi to English transliteration
                const hindiToEnglishMap = {
                    'अ': 'a', 'आ': 'aa', 'इ': 'i', 'ई': 'ee', 'उ': 'u', 'ऊ': 'oo', 'ऋ': 'ri', 'ए': 'e', 'ऐ': 'ai',
                    'ओ': 'o', 'औ': 'au', 'क': 'k', 'ख': 'kh', 'ग': 'g', 'घ': 'gh', 'ङ': 'ng', 'च': 'ch', 'छ': 'chh',
                    'ज': 'j', 'झ': 'jh', 'ञ': 'yn', 'ट': 't', 'ठ': 'th', 'ड': 'd', 'ढ': 'dh', 'ण': 'n', 'त': 't',
                    'थ': 'th', 'द': 'd', 'ध': 'dh', 'न': 'n', 'प': 'p', 'फ': 'ph', 'ब': 'b', 'भ': 'bh', 'म': 'm',
                    'य': 'y', 'र': 'r', 'ल': 'l', 'व': 'v', 'श': 'sh', 'ष': 'sh', 'स': 's', 'ह': 'h', '्': '',
                    'ा': 'a', 'ि': 'i', 'ी': 'ee', 'ु': 'u', 'ू': 'oo', 'ृ': 'ri', 'े': 'e', 'ै': 'ai', 'ो': 'o',
                    'ौ': 'au', 'ं': 'n', 'ः': 'h', '़': '', 'ऽ': '', '।': '', '॥': '', ' ': '-'
                };

                // Convert Hindi characters to English
                let slug = text.split('').map(char => hindiToEnglishMap[char] || char).join('');

                // Handle Hinglish (English script for Hindi words)
                const hinglishToEnglishMap = {
                    'aa': 'a', 'ee': 'i', 'oo': 'u', 'ri': 'ri', 'ai': 'ai', 'au': 'au',
                    'kh': 'kh', 'gh': 'gh', 'chh': 'chh', 'jh': 'jh', 'th': 'th', 'dh': 'dh',
                    'sh': 'sh', 'ph': 'ph', 'bh': 'bh', 'yn': 'yn', 'ng': 'ng'
                };

                // Replace Hinglish patterns
                Object.keys(hinglishToEnglishMap).forEach(pattern => {
                    slug = slug.replace(new RegExp(pattern, 'gi'), hinglishToEnglishMap[pattern]);
                });

                // Remove special characters and convert to lowercase
                slug = slug
                    .toLowerCase() // Convert to lowercase
                    .replace(/[^\w\s-]/g, '') // Remove special characters except spaces and hyphens
                    .replace(/[\s-]+/g, '-') // Replace spaces and multiple hyphens with a single hyphen
                    .replace(/^-+|-+$/g, ''); // Trim leading and trailing hyphens

                return slug;
            }

            // Example usage
            $('#title').on('input', function () {
                const title = $(this).val();
                const slug = transliterateToSlug(title);
                $('#slug').val(slug);
            });

            // Initialize CKEditor on the textarea with id 'content'
            CKEDITOR.replace('blog-content', {
                // You can add custom configurations here if needed
                toolbar: [
                    { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'] },
                    { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl'] },
                    { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
                    { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe'] },
                    '/',
                    { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
                    { name: 'colors', items: ['TextColor', 'BGColor'] },
                    { name: 'tools', items: ['Maximize', 'ShowBlocks'] },
                    { name: 'document', items: ['Source'] }
                ],
                height: 300
            });

            // Form submission validation
            $('#create-blog-form').on('submit', function (e) {
                // Update the textarea with the content from CKEditor
                for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
                // Add any custom validation here if needed
            });
        });
    </script>
@endpush
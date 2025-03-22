@extends('layouts.frontend')

@section('title', 'News')

@section('content')
    <!-- Breadcrumb Menu with Background Image -->
    <nav class="relative flex items-center justify-center py-20 bg-cover bg-center" style="background-image: url('{{ asset('images/news-banner.jpg') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="container mx-auto px-4 relative z-10 text-center">
            <ol class="flex space-x-2 text-white justify-center">
                <li><a href="{{ route('home') }}" class="text-blue-400 hover:text-blue-600">Home</a></li>
                <li class="text-gray-300">/</li>
                <li class="text-gray-300">News</li>
            </ol>
            <h1 class="text-4xl font-bold text-white mt-4">Latest News</h1>
            <p class="text-lg text-gray-200 mt-2">Stay updated with the latest news and updates from Sahakar Bharati Rajasthan.</p>
        </div>
    </nav>

    <!-- News Section -->
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Blog Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($blogs as $blog)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <!-- Blog Image -->
                        <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="w-full h-48 object-cover">

                        <!-- Blog Content -->
                        <div class="p-6">
                            <!-- Blog Title -->
                            <h2 class="text-xl font-semibold mb-2">{{ $blog->title }}</h2>

                            <!-- Blog Metadata -->
                            <div class="text-sm text-gray-600 mb-4">
                                <span class="mr-2">
                                    <i class="fas fa-calendar-alt"></i> {{ $blog->created_at->format('M d, Y') }}
                                </span>
                                <span>
                                    <i class="fas fa-folder"></i>
                                    @foreach($blog->categories as $category)
                                        <a href="#" class="hover:text-blue-600">{{ $category->name }}</a>
                                        @if(!$loop->last), @endif
                                    @endforeach
                                </span>
                            </div>

                            <!-- Blog Excerpt -->
                            <p class="text-gray-700 mb-4">{{ Str::limit($blog->content, 150) }}</p>

                            <!-- Read More Link -->
                            <a href="{{ route('news.show', ['id' => $blog->id]) }}" class="text-blue-600 hover:underline">Read More →</a>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $blogs->links() }}
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold mb-4">Categories</h3>
                    <ul>
                        @foreach($categories as $category)
                        <li class="mb-2">
                            <a href="#" class="text-gray-700 hover:text-blue-600">
                                {{ $category->name }} ({{ $category->blogs_count }})
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
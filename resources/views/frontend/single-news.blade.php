@extends('layouts.frontend')

@section('title', $blog->title)

@section('content')
    <!-- Breadcrumb Menu with Background Image -->
    <nav class="relative flex items-center justify-center py-16 bg-cover bg-center" style="background-image: url('{{ asset('images/news-banner.jpg') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="container mx-auto px-4 relative z-10 text-center">
            <!-- Breadcrumb -->
            <ol class="flex space-x-2 text-white justify-center">
                <li><a href="{{ route('home') }}" class="text-blue-400 hover:text-blue-600">Home</a></li>
                <li class="text-gray-300">/</li>
                <li><a href="{{ route('news.index') }}" class="text-blue-400 hover:text-blue-600">News</a></li>
                <li class="text-gray-300">/</li>
                <li class="text-gray-300">{{ Str::limit($blog->title, 50) }}</li> <!-- Limit title length -->
            </ol>
    
            <!-- Title -->
            <h1 class="text-2xl md:text-3xl font-bold text-white mt-4">
                {{ Str::limit($blog->title, 70) }} <!-- Adjust limit as needed -->
            </h1>
    
            <!-- Subtitle -->
            <p class="text-sm md:text-base text-gray-200 mt-2">Read the full story and stay informed.</p>
        </div>
    </nav>

    <!-- Single News Section -->
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Blog Image -->
                <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="w-full h-96 object-cover rounded-lg">

                <!-- Blog Title -->
                <h1 class="text-4xl font-bold mt-8 mb-4">{{ $blog->title }}</h1>

                <!-- Blog Metadata -->
                <div class="text-sm text-gray-600 mb-8">
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

                <!-- Blog Content -->
                <div class="prose max-w-none mb-8">
                    {!! $blog->content !!}
                </div>

                <!-- Tags -->
                <div class="mt-8 border-t pt-6">
                    <h3 class="text-lg font-semibold mb-4">Tags:</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($blog->tags as $tag)
                            <a href="#" class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm hover:bg-gray-300 hover:text-gray-800">
                                {{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Related Posts -->
                <div class="mt-12">
                    <h3 class="text-2xl font-bold mb-6">Related Posts</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($relatedPosts as $post)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                            <!-- Related Post Image -->
                            <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">

                            <!-- Related Post Content -->
                            <div class="p-6">
                                <h4 class="text-xl font-semibold mb-2">{{ $post->title }}</h4>
                                <p class="text-gray-700 mb-4">{{ Str::limit($post->content, 100) }}</p>
                                <a href="{{ route('news.show', ['id' => $post->id]) }}" class="text-blue-600 hover:underline">Read More →</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
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
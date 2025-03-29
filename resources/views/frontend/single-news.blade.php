<!-- single-news.blade.php -->
@extends('layouts.frontend')

@section('title', $blog->title)

@php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
@endphp

@section('content')
    <!-- Banner Section -->
    <nav class="relative flex items-center justify-center py-16 bg-cover bg-center"
        style="background-image: url('{{ asset('images/news-banner.jpg') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="container mx-auto px-4 relative z-10 text-center">
            <ol class="flex space-x-2 text-white justify-center">
                <li><a href="{{ route('home') }}"
                        class="text-blue-400 hover:text-blue-600 transition-colors duration-300">Home</a></li>
                <li class="text-gray-300">/</li>
                <li><a href="{{ route('news.index') }}"
                        class="text-blue-400 hover:text-blue-600 transition-colors duration-300">News</a></li>
                <li class="text-gray-300">/</li>
                <li class="text-gray-300">{{ Str::limit($blog->title, 50) }}</li>
            </ol>
            <h1 class="text-2xl md:text-3xl font-bold text-white mt-4">
                {{ Str::limit($blog->title, 70) }}
            </h1>
            <p class="text-sm md:text-base text-gray-200 mt-2">Read the full story and stay informed.</p>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Article Content -->
            <div class="lg:col-span-3">
                <!-- Featured Image -->
                <div class="relative overflow-hidden rounded-xl shadow-lg">
                    <img src="{{ $blog->image ? Storage::url('blog/' . $blog->image) : asset('images/default-blog-image.jpg') }}" 
                    alt="{{ $blog->title }}" 
                    class="w-full h-96 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                </div>

                <!-- Article Header -->
                <h1 class="text-4xl font-bold mt-8 mb-4">{{ $blog->title }}</h1>

                <!-- Meta Information -->
                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-8">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $blog->created_at->format('M d, Y') }}
                    </span>

                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        {{ $blog->views }} views
                    </span>

                    @if ($blog->reading_time)
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $blog->reading_time }} min read
                        </span>
                    @endif

                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                        @foreach ($blog->categories as $category)
                            <a href="{{ route('news.index', ['category' => $category->id]) }}"
                                class="hover:text-blue-600 transition-colors duration-300">
                                {{ $category->name }}
                            </a>
                            @if (!$loop->last)
                                <span class="mx-1">,</span>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Article Content -->
                <div class="prose max-w-none mb-8">
                    {!! $blog->content !!}
                </div>

                <!-- Tags -->
                <!-- Tags -->
                @if ($blog->tags->count() > 0)
                    <div class="mt-8 border-t pt-6">
                        <h3 class="text-lg font-semibold mb-4">Tags:</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($blog->tags as $tag)
                                <a href="{{ route('news.index', ['tag' => $tag->id]) }}"
                                    class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm hover:bg-gray-300 hover:text-gray-800 transition-colors duration-300">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Related Posts -->
                @if ($relatedPosts->count() > 0)
                    <div class="mt-12">
                        <h3 class="text-2xl font-bold mb-6 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                            </svg>
                            Related Posts
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @include('partials.related-posts-cards', ['posts' => $relatedPosts])
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            @include('partials.sidebar', [
                'categories' => $categories,
                'popularPosts' => $popularPosts,
                'latestNews' => $latestNews,
            ])
        </div>
    </div>
@endsection

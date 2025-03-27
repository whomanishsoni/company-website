@extends('layouts.frontend')

@section('title', 'News')

@section('content')
    <!-- Breadcrumb Menu with Background Image -->
    <nav class="relative flex items-center justify-center py-20 bg-cover bg-center"
        style="background-image: url('{{ asset('images/news-banner.jpg') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="container mx-auto px-4 relative z-10 text-center">
            <ol class="flex space-x-2 text-white justify-center">
                <li><a href="{{ route('home') }}"
                        class="text-blue-400 hover:text-blue-600 transition-colors duration-300">Home</a></li>
                <li class="text-gray-300">/</li>
                <li class="text-gray-300">News</li>
            </ol>
            <h1 class="text-4xl font-bold text-white mt-4">Latest News</h1>
            <p class="text-lg text-gray-200 mt-2">Stay updated with the latest news and updates from Sahakar Bharati
                Rajasthan.</p>
        </div>
    </nav>

    <!-- News Section -->
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Blog Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @include('partials.blog-cards', ['blogs' => $blogs])
                </div>

                <!-- Pagination Links -->
                <div class="mt-8">
                    {{ $blogs->links('pagination::tailwind') }}
                </div>
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

<!-- resources/views/frontend/partials/sidebar.blade.php -->
@props([
    'categories' => [],
    'popularPosts' => [],
    'latestNews' => [],
])

@php
use Illuminate\Support\Facades\Storage;
@endphp

<div class="lg:col-span-1">
    <div class="sticky top-6 space-y-6">
        <!-- Categories Widget -->
        <div
            class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 transition-shadow duration-300 hover:shadow-xl">
            <h3 class="text-xl font-semibold mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z"
                        clip-rule="evenodd" />
                </svg>
                Categories
                <span class="ml-auto bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full">
                    {{ count($categories) }}
                </span>
            </h3>
            <ul class="space-y-2">
                @foreach ($categories as $category)
                    <li>
                        <a href="{{ route('news.index', ['category' => $category->id]) }}"
                            class="flex justify-between items-center p-2 rounded-lg hover:bg-blue-50 transition-colors duration-200 group">
                            <span class="text-gray-700 group-hover:text-blue-600">
                                {{ $category->name }}
                            </span>
                            <span
                                class="bg-gray-100 text-gray-800 text-xs font-semibold px-2 py-1 rounded-full group-hover:bg-blue-200 group-hover:text-blue-800 transition-colors duration-200">
                                {{ $category->blogs_count }}
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Popular Posts Widget -->
        @if (count($popularPosts) > 0)
            <div
                class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 transition-shadow duration-300 hover:shadow-xl">
                <h3 class="text-xl font-semibold mb-4 flex items-center border-b pb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"
                            clip-rule="evenodd" />
                    </svg>
                    Popular Posts
                    <span class="ml-auto bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded-full">
                        {{ count($popularPosts) }}
                    </span>
                </h3>
                <ul class="space-y-4">
                    @foreach ($popularPosts as $post)
                        <li class="group">
                            <a href="{{ route('news.show', $post->id ?? $post->slug) }}"
                                class="flex items-start gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                <div class="relative flex-shrink-0 w-16 h-16 overflow-hidden rounded-lg">
                                    <img src="{{ $post->image ? Storage::url('blog/' . $post->image) : asset('images/default-blog-image.jpg') }}" 
                                         alt="{{ $post->title }}"
                                         class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                    <div
                                        class="absolute inset-0 bg-black bg-opacity-10 group-hover:bg-opacity-20 transition-colors duration-200">
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4
                                        class="text-sm font-medium text-gray-800 group-hover:text-blue-600 transition-colors duration-200 line-clamp-2">
                                        {{ $post->title }}
                                    </h4>
                                    <div class="flex items-center mt-1 text-xs text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $post->created_at->format('M d, Y') }}
                                        <span class="mx-2 text-gray-300">•</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        {{ $post->views }} views
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Latest News Widget -->
        @if (count($latestNews) > 0)
            <div
                class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 transition-shadow duration-300 hover:shadow-xl">
                <h3 class="text-xl font-semibold mb-4 flex items-center border-b pb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                    Latest News
                    <span class="ml-auto bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full">
                        {{ count($latestNews) }}
                    </span>
                </h3>
                <ul class="space-y-4">
                    @foreach ($latestNews as $news)
                        <li class="group">
                            <a href="{{ route('news.show', $news->id ?? $news->slug) }}"
                                class="flex items-start gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                <div class="relative flex-shrink-0 w-16 h-16 overflow-hidden rounded-lg">
                                    <img src="{{ $news->image ? Storage::url('blog/' . $news->image) : asset('images/default-blog-image.jpg') }}" 
                                         alt="{{ $news->title }}"
                                         class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                    <div
                                        class="absolute inset-0 bg-black bg-opacity-10 group-hover:bg-opacity-20 transition-colors duration-200">
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4
                                        class="text-sm font-medium text-gray-800 group-hover:text-blue-600 transition-colors duration-200 line-clamp-2">
                                        {{ $news->title }}
                                    </h4>
                                    <div class="flex items-center mt-1 text-xs text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $news->created_at->format('M d, Y') }}
                                        @if (isset($news->comments_count))
                                            <span class="mx-2 text-gray-300">•</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                            </svg>
                                            {{ $news->comments_count }} comments
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>

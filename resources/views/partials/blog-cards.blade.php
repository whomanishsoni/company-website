@php
    use Illuminate\Support\Facades\Storage;
@endphp

@if ($blogs->count() > 0)
    @foreach ($blogs as $blog)
        <div
            class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl border border-gray-100 group">
            <!-- Blog Image with Hover Effect -->
            <a href="{{ route('news.show', $blog->slug) }}" class="block overflow-hidden relative">
                <img src="{{ $blog->image ? Storage::url('blog/' . $blog->image) : asset('images/default-blog-image.jpg') }}"
                    alt="{{ $blog->title }}"
                    class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-105">
                <div
                    class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300">
                </div>
            </a>

            <!-- Blog Content -->
            <div class="p-6">
                <!-- Blog Title with Link -->
                <h2 class="text-xl font-bold mb-3">
                    <a href="{{ route('news.show', $blog->slug) }}"
                        class="text-gray-800 hover:text-blue-600 transition-colors duration-300">
                        {{ $blog->title }}
                    </a>
                </h2>

                <!-- Blog Metadata -->
                <div class="flex flex-wrap items-center text-sm text-gray-600 mb-4 gap-2">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $blog->created_at->format('M d, Y') }}
                    </span>

                    <span class="text-gray-300">•</span>

                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        {{ $blog->views }} views
                    </span>

                    @if ($blog->comments_count > 0)
                        <span class="text-gray-300">•</span>

                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            {{ $blog->comments_count }} comments
                        </span>
                    @endif

                    <span class="text-gray-300">•</span>

                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                        @foreach ($blog->categories as $category)
                            <a href="{{ route('news.index', ['category' => $category->id]) }}"
                                class="text-sm hover:text-blue-600 transition-colors duration-300">
                                {{ $category->name }}
                            </a>
                            @if (!$loop->last)
                                <span class="mx-1">,</span>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Blog Excerpt -->
                <div class="text-gray-700 mb-5 line-clamp-3">
                    {{ Str::cleanExcerpt($blog->content, 150) }}
                </div>

                <!-- Read More Link -->
                <div class="flex justify-between items-center">
                    <a href="{{ route('news.show', $blog->slug) }}"
                        class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors duration-300 font-medium">
                        Read More
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 ml-1 transition-transform duration-300 group-hover:translate-x-1"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>

                    @if ($blog->reading_time)
                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">
                            {{ $blog->reading_time }} min read
                        </span>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="col-span-full">
        <div class="bg-white rounded-xl shadow-lg p-10 text-center mb-8 border border-gray-100">
            <div class="text-blue-500 text-6xl mb-6">
                <i class="far fa-newspaper"></i>
            </div>

            <h3 class="text-2xl font-semibold text-gray-800 mb-3">
                @if ($currentCategory)
                    No Articles Found in <span class="text-blue-600">"{{ $currentCategory->name }}"</span>
                @else
                    No Articles Available
                @endif
            </h3>

            <p class="text-gray-500 max-w-2xl mx-auto mb-8">
                @if ($currentCategory)
                    This category doesn't contain any articles yet. Check back soon or browse other content.
                @else
                    Our knowledge base is currently being updated with new articles.
                @endif
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-3 max-w-md mx-auto">
                <a href="{{ route('news.index') }}"
                    class="py-2 px-4 bg-blue-600 text-white rounded-full hover:bg-blue-700 w-full text-center">
                    <i class="fas fa-arrow-left mr-2"></i> Back to All Articles
                </a>

                @if ($currentCategory)
                    <a href="{{ route('contact') }}?subject=Content+Suggestion:+{{ urlencode($currentCategory->name) }}"
                        class="py-2 px-4 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 w-full text-center">
                        <i class="fas fa-pen mr-2"></i> Suggest Content
                    </a>
                @endif
            </div>
        </div>
    </div>
@endif

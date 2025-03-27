<!-- related-posts-cards.blade.php -->
@foreach ($posts as $post)
    <div
        class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl border border-gray-100 group">
        <!-- Related Post Image with Hover Effect -->
        <a href="{{ route('news.show', $post->id) }}" class="block overflow-hidden relative">
            <img src="{{ asset($post->image) }}" alt="{{ $post->title }}"
                class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-105">
            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300">
            </div>
        </a>

        <!-- Related Post Content -->
        <div class="p-6">
            <h4 class="text-xl font-bold mb-3">
                <a href="{{ route('news.show', $post->id) }}"
                    class="text-gray-800 hover:text-blue-600 transition-colors duration-300">
                    {{ $post->title }}
                </a>
            </h4>

            <!-- Post Metadata -->
            <div class="flex flex-wrap items-center text-sm text-gray-600 mb-4 gap-2">
                <span class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    {{ $post->created_at->format('M d, Y') }}
                </span>

                <span class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    {{ $post->views }} views
                </span>

                @if ($post->reading_time)
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $post->reading_time }} min read
                    </span>
                @endif
            </div>

            <div class="text-gray-700 mb-5 line-clamp-3">
                @php
                    $decodedContent = html_entity_decode($post->content);
                    $plainContent = strip_tags($decodedContent);
                    $excerpt = Str::limit($plainContent, 100);
                @endphp
                {{ $excerpt }}
            </div>

            <a href="{{ route('news.show', $post->id) }}"
                class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors duration-300 font-medium">
                Read More
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 ml-1 transition-transform duration-300 group-hover:translate-x-1" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>
    </div>
@endforeach

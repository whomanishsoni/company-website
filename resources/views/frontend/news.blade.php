@extends('layouts.frontend')

@section('title', 'News')

@section('content')
    <!-- News Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Latest News</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- News Article 1 -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="News 1" class="rounded-lg mb-4">
                    <h3 class="text-xl font-semibold mb-2">Top Web Development Trends in 2023</h3>
                    <p class="text-gray-600 mb-4">Discover the latest trends in web development and how they can benefit your business.</p>
                    <a href="{{ route('news.show', ['id' => 1]) }}" class="text-blue-600 hover:underline">Read More →</a>
                </div>

                <!-- News Article 2 -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <img src="https://images.unsplash.com/photo-1496171367470-9ed9a91ea931?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="News 2" class="rounded-lg mb-4">
                    <h3 class="text-xl font-semibold mb-2">Why SEO is Crucial for Your Business</h3>
                    <p class="text-gray-600 mb-4">Learn why SEO is essential for improving your online presence and driving traffic.</p>
                    <a href="{{ route('news.show', ['id' => 2]) }}" class="text-blue-600 hover:underline">Read More →</a>
                </div>

                <!-- News Article 3 -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="News 3" class="rounded-lg mb-4">
                    <h3 class="text-xl font-semibold mb-2">Digital Marketing Strategies for 2023</h3>
                    <p class="text-gray-600 mb-4">Explore the best digital marketing strategies to grow your business this year.</p>
                    <a href="{{ route('news.show', ['id' => 3]) }}" class="text-blue-600 hover:underline">Read More →</a>
                </div>
            </div>
        </div>
    </section>
@endsection
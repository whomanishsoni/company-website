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
                    <h3 class="text-xl font-semibold mb-2">Empowering Farmers Through Cooperatives</h3>
                    <p class="text-gray-600 mb-4">Discover how Sahakar Bharati Rajasthan is empowering small farmers through cooperative initiatives, providing them with resources and market access.</p>
                    <a href="{{ route('news.show', ['id' => 1]) }}" class="text-blue-600 hover:underline">Read More →</a>
                </div>

                <!-- News Article 2 -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <img src="https://images.unsplash.com/photo-1496171367470-9ed9a91ea931?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="News 2" class="rounded-lg mb-4">
                    <h3 class="text-xl font-semibold mb-2">Women Empowerment Through SHGs</h3>
                    <p class="text-gray-600 mb-4">Learn how Sahakar Bharati Rajasthan is supporting women through self-help groups (SHGs), enabling them to achieve financial independence.</p>
                    <a href="{{ route('news.show', ['id' => 2]) }}" class="text-blue-600 hover:underline">Read More →</a>
                </div>

                <!-- News Article 3 -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="News 3" class="rounded-lg mb-4">
                    <h3 class="text-xl font-semibold mb-2">Promoting Sustainable Agriculture</h3>
                    <p class="text-gray-600 mb-4">Explore how Sahakar Bharati Rajasthan is promoting sustainable agricultural practices through cooperatives, ensuring long-term benefits for farmers and the environment.</p>
                    <a href="{{ route('news.show', ['id' => 3]) }}" class="text-blue-600 hover:underline">Read More →</a>
                </div>

                <!-- News Article 4 -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="News 4" class="rounded-lg mb-4">
                    <h3 class="text-xl font-semibold mb-2">Skill Development for Rural Youth</h3>
                    <p class="text-gray-600 mb-4">Read about Sahakar Bharati Rajasthan's initiatives to provide skill development programs for rural youth, helping them secure better livelihood opportunities.</p>
                    <a href="{{ route('news.show', ['id' => 4]) }}" class="text-blue-600 hover:underline">Read More →</a>
                </div>

                <!-- News Article 5 -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <img src="https://images.unsplash.com/photo-1527689368864-3a821dbccc34?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="News 5" class="rounded-lg mb-4">
                    <h3 class="text-xl font-semibold mb-2">Policy Advocacy for Cooperatives</h3>
                    <p class="text-gray-600 mb-4">Learn how Sahakar Bharati Rajasthan is advocating for policy changes to strengthen the cooperative movement and protect its autonomy.</p>
                    <a href="{{ route('news.show', ['id' => 5]) }}" class="text-blue-600 hover:underline">Read More →</a>
                </div>

                <!-- News Article 6 -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="News 6" class="rounded-lg mb-4">
                    <h3 class="text-xl font-semibold mb-2">Financial Inclusion Initiatives</h3>
                    <p class="text-gray-600 mb-4">Discover how Sahakar Bharati Rajasthan is promoting financial inclusion by providing access to credit and savings for marginalized communities.</p>
                    <a href="{{ route('news.show', ['id' => 6]) }}" class="text-blue-600 hover:underline">Read More →</a>
                </div>
            </div>
        </div>
    </section>
@endsection
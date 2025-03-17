@extends('layouts.frontend')

@section('title', 'Single News')

@section('content')
    <!-- Single News Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto">
                <!-- News Image -->
                <img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="News Image" class="rounded-lg mb-8">

                <!-- News Title -->
                <h1 class="text-4xl font-bold mb-6">Top Web Development Trends in 2023</h1>

                <!-- News Content -->
                <div class="prose max-w-none">
                    <p class="text-gray-600 mb-4">In 2023, web development continues to evolve rapidly, with new technologies and trends shaping the industry. Here are some of the top trends to watch out for:</p>
                    <ul class="list-disc list-inside text-gray-600 mb-4">
                        <li class="mb-2">Progressive Web Apps (PWAs) are becoming more popular due to their ability to work offline and provide a native app-like experience.</li>
                        <li class="mb-2">Artificial Intelligence (AI) is being integrated into websites to provide personalized user experiences.</li>
                        <li class="mb-2">WebAssembly is enabling high-performance applications to run directly in the browser.</li>
                    </ul>
                    <p class="text-gray-600">These trends are not only improving user experiences but also helping businesses stay competitive in the digital landscape.</p>
                </div>

                <!-- Back to News Link -->
                <div class="mt-8">
                    <a href="" class="text-blue-600 hover:underline">← Back to News</a>
                </div>
            </div>
        </div>
    </section>
@endsection
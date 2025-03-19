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
                <h1 class="text-4xl font-bold mb-6">Empowering Farmers Through Cooperatives</h1>

                <!-- News Content -->
                <div class="prose max-w-none">
                    <p class="text-gray-600 mb-4">Sahakar Bharati Rajasthan is at the forefront of empowering small farmers through cooperative initiatives. By providing access to resources, training, and market linkages, we are helping farmers improve their productivity and income.</p>
                    <h2 class="text-2xl font-semibold mb-4">Key Initiatives</h2>
                    <ul class="list-disc list-inside text-gray-600 mb-4">
                        <li class="mb-2">**Training Programs**: We conduct regular training sessions to educate farmers about modern agricultural practices and cooperative management.</li>
                        <li class="mb-2">**Resource Sharing**: Through cooperatives, farmers can access shared resources like seeds, fertilizers, and machinery, reducing their individual costs.</li>
                        <li class="mb-2">**Market Access**: We help farmers connect with buyers and markets, ensuring they get fair prices for their produce.</li>
                    </ul>
                    <p class="text-gray-600">These initiatives are transforming the lives of farmers in Rajasthan, enabling them to achieve financial stability and sustainable growth.</p>

                    <h2 class="text-2xl font-semibold mb-4">Success Stories</h2>
                    <p class="text-gray-600 mb-4">One such success story is that of <strong>Ramesh Kumar</strong>, a small farmer from Jaipur district. Through Sahakar Bharati Rajasthan's cooperative program, Ramesh was able to increase his crop yield by 30% and secure a better price for his produce. Today, he is an active member of the cooperative and mentors other farmers in his community.</p>

                    <h2 class="text-2xl font-semibold mb-4">Future Plans</h2>
                    <p class="text-gray-600">We are committed to expanding our reach and impact. In the coming years, we plan to establish more cooperatives in rural areas, focusing on sustainable agriculture and women empowerment. Our goal is to create a self-reliant and prosperous farming community in Rajasthan.</p>
                </div>

                <!-- Back to News Link -->
                <div class="mt-8">
                    <a href="#" class="text-blue-600 hover:underline">← Back to News</a>
                </div>
            </div>
        </div>
    </section>
@endsection
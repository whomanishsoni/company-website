@extends('layouts.frontend')

@section('title', 'Services')

@section('content')
    <!-- Breadcrumb Menu with Background Image -->
    <nav class="relative flex items-center justify-center py-20 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1487017159836-4e23ece2e4cf?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="container mx-auto px-4 relative z-10 text-center">
            <ol class="flex space-x-2 text-white justify-center">
                <li><a href="{{ route('home') }}" class="text-blue-400 hover:text-blue-600">Home</a></li>
                <li class="text-gray-300">/</li>
                <li class="text-gray-300">Services</li>
            </ol>
            <h1 class="text-4xl font-bold text-white mt-4">Our Services</h1>
            <p class="text-lg text-gray-200 mt-2">Explore the wide range of services we offer to help your business grow.</p>
        </div>
    </nav>

    <!-- Services Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">What We Offer</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <div class="bg-blue-100 p-3 rounded-full inline-block mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Web Development</h3>
                    <p class="text-gray-600 mb-4">We build modern, responsive, and scalable websites tailored to your business needs. From simple landing pages to complex web applications, we’ve got you covered.</p>
                    <a href="#" class="text-blue-600 hover:text-blue-800">Learn More →</a>
                </div>

                <!-- Service 2 -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <div class="bg-blue-100 p-3 rounded-full inline-block mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">SEO Optimization</h3>
                    <p class="text-gray-600 mb-4">Improve your website's visibility and ranking on search engines with our proven SEO strategies. We help you attract more organic traffic and grow your online presence.</p>
                    <a href="#" class="text-blue-600 hover:text-blue-800">Learn More →</a>
                </div>

                <!-- Service 3 -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <div class="bg-blue-100 p-3 rounded-full inline-block mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Digital Marketing</h3>
                    <p class="text-gray-600 mb-4">Reach your target audience with effective digital marketing strategies. From social media campaigns to email marketing, we help you connect with your customers.</p>
                    <a href="#" class="text-blue-600 hover:text-blue-800">Learn More →</a>
                </div>

                <!-- Service 4 -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <div class="bg-blue-100 p-3 rounded-full inline-block mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">E-Commerce Solutions</h3>
                    <p class="text-gray-600 mb-4">Build and grow your online store with our e-commerce solutions. We provide everything from platform setup to payment integration.</p>
                    <a href="#" class="text-blue-600 hover:text-blue-800">Learn More →</a>
                </div>

                <!-- Service 5 -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <div class="bg-blue-100 p-3 rounded-full inline-block mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Mobile App Development</h3>
                    <p class="text-gray-600 mb-4">Create engaging and user-friendly mobile applications for iOS and Android. We turn your ideas into reality with cutting-edge technology.</p>
                    <a href="#" class="text-blue-600 hover:text-blue-800">Learn More →</a>
                </div>

                <!-- Service 6 -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <div class="bg-blue-100 p-3 rounded-full inline-block mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">UI/UX Design</h3>
                    <p class="text-gray-600 mb-4">Design intuitive and visually appealing user interfaces that enhance user experience and drive engagement.</p>
                    <a href="#" class="text-blue-600 hover:text-blue-800">Learn More →</a>
                </div>
            </div>
        </div>
    </section>
@endsection
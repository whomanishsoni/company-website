@extends('layouts.frontend')

@section('title', 'Home')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-blue-600 text-white py-32">
        <!-- Background Image with Gradient Overlay -->
        <div class="absolute inset-0 bg-cover bg-center"
            style="background-image: url('https://images.unsplash.com/photo-1487017159836-4e23ece2e4cf?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600/90 to-blue-800/90"></div>

        <!-- Content -->
        <div class="container mx-auto text-center relative z-10 px-4">
            <h1 class="text-5xl md:text-6xl font-bold mb-6">Welcome to Sahakar Bharati Rajasthan</h1>
            <p class="text-xl md:text-2xl mb-8 max-w-2xl mx-auto">Learn more about Sahakar Bharati Rajasthan and our mission
                to empower communities through cooperatives.</p>
            <div class="flex justify-center space-x-4">
                <a href="/services"
                    class="bg-white text-blue-600 px-8 py-3 rounded-full font-semibold hover:bg-blue-50 transition duration-300">Explore
                    Services</a>
                <a href="/join"
                    class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-blue-600 transition duration-300">Join
                    Now</a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="bg-gradient-to-r from-blue-50 to-gray-50 py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12">About Us</h2>
            <div class="flex flex-col md:flex-row items-center">
                <!-- Image Section -->
                <div class="md:w-1/2 relative">
                    <img src="{{ asset('images/about-us-two.jpg') }}" alt="About Us" class="rounded-lg shadow-lg">
                </div>
                <!-- Content Section -->
                <div class="md:w-1/2 md:pl-12 mt-12 md:mt-0">
                    <p class="text-gray-600 mb-6">Sahakar Bharati is a nationwide organization dedicated to strengthening
                        the CoOperative Movement across India. We aim to uplift small farmers, laborers, women, and rural
                        artisans through self-reliant CoOperative institutions.</p>
                    <p class="text-gray-600 mb-6">Our vision is to make the CoOperative Movement a key pillar of India's
                        decentralized economy, ensuring equitable and sustainable growth. Through training, research, and
                        advocacy, we strive to empower CoOperatives and keep them free from political interference.</p>
                    <div class="space-y-4 mb-8">
                        <div class="flex items-center">
                            <div class="bg-blue-100 p-2 rounded-full mr-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="text-gray-600">Empowering CoOperatives through training and research.</p>
                        </div>
                        <div class="flex items-center">
                            <div class="bg-blue-100 p-2 rounded-full mr-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-600">Advocating for policy changes to support CoOperatives.</p>
                        </div>
                    </div>
                    <a href="/about"
                        class="inline-block bg-blue-600 text-white px-8 py-3 rounded-full hover:bg-blue-700 transition duration-300">Learn
                        More</a>
                </div>
            </div>
        </div>
    </section>


    <!-- Services Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Our Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Service 1: Public Awareness -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <div class="bg-blue-100 p-3 rounded-full inline-block mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Public Awareness</h3>
                    <p class="text-gray-600 mb-4">
                        We establish branches across the country to educate the public about the Cooperative Movement and
                        Sahakar Bharati’s mission. Our goal is to inspire individuals to join and support this
                        transformative movement.
                    </p>
                    <a href="#" class="text-blue-600 hover:text-blue-800">Learn More →</a>
                </div>

                <!-- Service 2: Cooperative Promotion -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <div class="bg-blue-100 p-3 rounded-full inline-block mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Cooperative Promotion</h3>
                    <p class="text-gray-600 mb-4">
                        We motivate individuals at the National, State, District, Taluka, and Village levels to promote,
                        establish, and manage various types of need-based Cooperatives. Our efforts ensure that cooperatives
                        are accessible to all.
                    </p>
                    <a href="#" class="text-blue-600 hover:text-blue-800">Learn More →</a>
                </div>

                <!-- Service 3: Advisory Services -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <div class="bg-blue-100 p-3 rounded-full inline-block mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Advisory Services</h3>
                    <p class="text-gray-600 mb-4">
                        We offer advisory services in techno-economic areas to assist Cooperatives in resolving operational
                        challenges. Our experts provide guidance to ensure smooth functioning and growth.
                    </p>
                    <a href="#" class="text-blue-600 hover:text-blue-800">Learn More →</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="bg-blue-600 text-white py-16">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold mb-4">Join the Sahakar Bharati Movement</h2>
            <p class="text-lg mb-6">Be part of India's largest CoOperative network, empowering communities and fostering
                self-reliance.</p>
            <a href="/join"
                class="bg-white text-blue-600 px-6 py-3 rounded-full font-semibold hover:bg-blue-50 transition duration-300">Join
                Now</a>
        </div>
    </section>

    <!-- News/Blog Section -->
    <section class="bg-gray-50 py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Latest News</h2>

            @if ($featuredNews->isEmpty())
                <div class="text-center py-8">
                    <p class="text-gray-500">No lastet news available at the moment.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach ($featuredNews as $news)
                        <div
                            class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            @if ($news->image)
                                <div class="h-48 overflow-hidden">
                                    <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}"
                                        class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                                </div>
                            @endif

                            <div class="p-6">
                                <div class="flex items-center text-sm text-gray-500 mb-2">
                                    <span>{{ $news->created_at->format('M d, Y') }}</span>
                                    @if ($news->categories->isNotEmpty())
                                        <span class="mx-2">•</span>
                                        <span>{{ $news->categories->first()->name }}</span>
                                    @endif
                                </div>

                                <h3 class="text-xl font-semibold mb-3">{{ $news->title }}</h3>
                                <p class="text-gray-600 mb-4 line-clamp-3">
                                    {{ Str::cleanExcerpt($news->content, 120) }}
                                </p>

                                <a href="{{ route('news.show', $news->slug) }}"
                                    class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                                    Read More
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-8">
                    <a href="{{ route('news.index') }}"
                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full transition-colors duration-300">
                        View All News
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Contact Us</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Contact Info -->
                <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col">
                    <h3 class="text-xl font-semibold mb-4">Get in Touch</h3>
                    <p class="text-gray-600 mb-4">We'd love to hear from you! Reach out to us for any inquiries or
                        feedback.
                    </p>
                    <div class="space-y-4 flex-grow">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <p class="text-gray-600">123 Main Street, Melbourne, VIC 3000, Australia</p>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                            <p class="text-gray-600">+61 123 456 789</p>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            <p class="text-gray-600">info@company.com</p>
                        </div>
                    </div>
                    <!-- Map Section -->
                    <div class="mt-8">
                        <h3 class="text-xl font-semibold mb-4">Our Location</h3>
                        <div class="overflow-hidden rounded-lg shadow-lg">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.835434509374!2d144.9537353153166!3d-37.816279742021665!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf577d2aabc5e4f1e!2s123%20Main%20St%2C%20Melbourne%20VIC%203000%2C%20Australia!5e0!3m2!1sen!2sus!4v1622549400000!5m2!1sen!2sus"
                                width="100%" height="200" style="border:0;" allowfullscreen=""
                                loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
                <!-- Contact Form -->
                <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col">
                    <form class="flex flex-col flex-grow">
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">Name</label>
                            <input type="text" id="name"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
                                placeholder="Enter your name">
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700">Email</label>
                            <input type="email" id="email"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
                                placeholder="Enter your email address">
                        </div>
                        <div class="mb-4">
                            <label for="mobile" class="block text-gray-700">Mobile Number</label>
                            <div class="flex">
                                <input type="text" id="country-code" value="+91" readonly
                                    class="w-16 px-4 py-2 border rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-600 bg-gray-100">
                                <input type="tel" id="mobile"
                                    class="w-full px-4 py-2 border rounded-r-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
                                    placeholder="Enter your mobile number">
                            </div>
                        </div>
                        <div class="mb-4 flex-grow">
                            <label for="message" class="block text-gray-700">Message</label>
                            <textarea id="message" rows="4"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
                                placeholder="Enter your message"></textarea>
                        </div>
                        <button type="submit"
                            class="inline-block bg-blue-600 text-white px-8 py-3 rounded-full hover:bg-blue-700 transition duration-300">Send
                            Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

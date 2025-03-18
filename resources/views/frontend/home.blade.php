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
            <h1 class="text-5xl md:text-6xl font-bold mb-6">Welcome to Our Company</h1>
            <p class="text-xl md:text-2xl mb-8 max-w-2xl mx-auto">We provide innovative and tailored solutions to help your
                business grow and succeed in a competitive market.</p>
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
                    <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
                        alt="About Us" class="rounded-lg shadow-lg">
                    <div class="absolute -bottom-6 -right-6 bg-white p-4 rounded-lg shadow-lg">
                        <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="md:w-1/2 md:pl-12 mt-12 md:mt-0">
                    <p class="text-gray-600 mb-6">We are a team of passionate professionals dedicated to delivering
                        high-quality solutions for your business. Our mission is to help you achieve your goals through
                        innovation and technology.</p>
                    <p class="text-gray-600 mb-6">With years of experience in the industry, we have the expertise to handle
                        projects of any size and complexity. Whether you're a startup or an established enterprise, we
                        tailor our services to meet your unique needs.</p>
                    <div class="space-y-4 mb-8">
                        <div class="flex items-center">
                            <div class="bg-blue-100 p-2 rounded-full mr-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="text-gray-600">Innovative solutions tailored to your business needs.</p>
                        </div>
                        <div class="flex items-center">
                            <div class="bg-blue-100 p-2 rounded-full mr-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-600">Timely delivery of projects without compromising quality.</p>
                        </div>
                        <div class="flex items-center">
                            <div class="bg-blue-100 p-2 rounded-full mr-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-gray-600">Dedicated team of experienced professionals.</p>
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
                <!-- Service 1 -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <div class="bg-blue-100 p-3 rounded-full inline-block mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Web Development</h3>
                    <p class="text-gray-600 mb-4">We build modern, responsive, and scalable websites tailored to your
                        business needs.</p>
                    <a href="/services" class="text-blue-600 hover:underline">Learn More →</a>
                </div>

                <!-- Service 2 -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <div class="bg-blue-100 p-3 rounded-full inline-block mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">SEO Optimization</h3>
                    <p class="text-gray-600 mb-4">Improve your website's visibility and ranking on search engines with our
                        proven SEO strategies.</p>
                    <a href="/services" class="text-blue-600 hover:underline">Learn More →</a>
                </div>

                <!-- Service 3 -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <div class="bg-blue-100 p-3 rounded-full inline-block mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Digital Marketing</h3>
                    <p class="text-gray-600 mb-4">Reach your target audience with effective digital marketing strategies.
                    </p>
                    <a href="/services" class="text-blue-600 hover:underline">Learn More →</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="bg-blue-600 text-white py-20">
        <div class="container mx-auto text-center">
            <h2 class="text-4xl font-bold mb-6">Ready to Grow Your Business?</h2>
            <p class="text-xl mb-8">Let us help you achieve your goals with our expert solutions.</p>
            <a href="/join"
                class="bg-white text-blue-600 px-8 py-3 rounded-full font-semibold hover:bg-blue-50 transition duration-300">Join
                Now</a>
        </div>
    </section>

    <!-- News/Blog Section -->
    <section class="bg-gray-50 py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Latest News</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Blog Post 1 -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
                        alt="Blog Post 1" class="rounded-lg mb-4">
                    <h3 class="text-xl font-semibold mb-2">Top Web Development Trends in 2023</h3>
                    <p class="text-gray-600 mb-4">Discover the latest trends in web development and how they can benefit
                        your business.</p>
                    <a href="#" class="text-blue-600 hover:underline">Read More →</a>
                </div>

                <!-- Blog Post 2 -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <img src="https://images.unsplash.com/photo-1496171367470-9ed9a91ea931?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
                        alt="Blog Post 2" class="rounded-lg mb-4">
                    <h3 class="text-xl font-semibold mb-2">Why SEO is Crucial for Your Business</h3>
                    <p class="text-gray-600 mb-4">Learn why SEO is essential for improving your online presence and driving
                        traffic.</p>
                    <a href="#" class="text-blue-600 hover:underline">Read More →</a>
                </div>

                <!-- Blog Post 3 -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
                        alt="Blog Post 3" class="rounded-lg mb-4">
                    <h3 class="text-xl font-semibold mb-2">Digital Marketing Strategies for 2023</h3>
                    <p class="text-gray-600 mb-4">Explore the best digital marketing strategies to grow your business this
                        year.</p>
                    <a href="#" class="text-blue-600 hover:underline">Read More →</a>
                </div>
            </div>
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

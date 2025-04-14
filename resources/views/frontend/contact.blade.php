@extends('layouts.frontend')

@section('title', 'Contact Us')

@if (session('status'))
    <div class="container mx-auto px-4 mt-4">
        <div class="alert alert-{{ session('status') }} p-4 rounded-lg">
            {{ session('message') }}
        </div>
    </div>
@endif

@section('content')
    <!-- Breadcrumb Menu with Background Image -->
    <nav class="relative flex items-center justify-center py-20 bg-cover bg-center"
        style="background-image: url('images/contact-bg.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="container mx-auto px-4 relative z-10 text-center">
            <ol class="flex space-x-2 text-white justify-center">
                <li><a href="{{ route('home') }}" class="text-blue-400 hover:text-blue-600">Home</a></li>
                <li class="text-gray-300">/</li>
                <li class="text-gray-300">Contact Us</li>
            </ol>
            <h1 class="text-4xl font-bold text-white mt-4">Contact Us</h1>
            <p class="text-lg text-gray-200 mt-2">We're here to help. Reach out to us for any inquiries or feedback.</p>
        </div>
    </nav>

    <!-- Contact Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Contact Details on the Left -->
                <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col">
                    <h3 class="text-xl font-semibold mb-4">Get in Touch</h3>
                    <p class="text-gray-600 mb-4">We'd love to hear from you! Reach out to us for any inquiries or feedback
                        related to Sahakar Bharati Rajasthan.</p>
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
                            <p class="text-gray-600"> 506, Sewa Bharti Bhawan,Sahakar Marg, Jaipur, Rajasthan</p>
                        </div>
                        {{-- <div class="flex items-center">
                            <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                            <p class="text-gray-600">+91 123 456 7890</p>
                        </div> --}}
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            <p class="text-gray-600">info@sahakarbharatirajasthan.org</p>
                        </div>
                    </div>
                    <!-- Map Section -->
                    <div class="mt-8">
                        <h3 class="text-xl font-semibold mb-4">Our Location</h3>
                        <div class="overflow-hidden rounded-lg shadow-lg">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3559.248738547583!2d75.7897502746372!3d26.890581776677274!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396db5b0a0a4b8a9%3A0x4f5c8f8b8c8b8c8b!2s506%2C%20Sewa%20Bharti%20Bhawan%2C%20Sahakar%20Marg%2C%20Jaipur%2C%20Rajasthan%2C%20India!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin"
                                width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>

                <!-- Contact Form on the Right -->
                <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col">
                    <form method="POST" action="{{ route('contact.submit') }}" class="flex flex-col flex-grow">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">Name <span
                                    class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('name') border-red-500 @enderror"
                                placeholder="Enter your name" value="{{ old('name') }}">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700">Email <span
                                    class="text-red-500">*</span></label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('email') border-red-500 @enderror"
                                placeholder="Enter your email address" value="{{ old('email') }}">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="mobile" class="block text-gray-700">Mobile</label>
                            <div class="flex">
                                <input type="text" id="country-code" value="+91" readonly
                                    class="w-16 px-4 py-2 border rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-600 bg-gray-100">
                                <input type="tel" id="mobile"
                                    class="w-full px-4 py-2 border rounded-r-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
                                    placeholder="Enter your mobile number">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="subject" class="block text-gray-700">Subject <span
                                    class="text-red-500">*</span></label>
                            <input type="text" id="subject" name="subject" required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('subject') border-red-500 @enderror"
                                placeholder="Enter subject" value="{{ old('subject') }}">
                            @error('subject')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4 flex-grow">
                            <label for="message" class="block text-gray-700">Message <span
                                    class="text-red-500">*</span></label>
                            <textarea id="message" name="message" rows="4" required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('message') border-red-500 @enderror"
                                placeholder="Enter your message">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <input type="hidden" name="ip_address" value="{{ request()->ip() }}">
                        <input type="hidden" name="user_agent" value="{{ request()->userAgent() }}">
                        <button type="submit"
                            class="inline-block bg-blue-600 text-white px-8 py-3 rounded-full hover:bg-blue-700 transition duration-300">
                            Send Message
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>
@endsection

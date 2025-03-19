@extends('layouts.frontend')

@section('title', 'About Us')

@section('content')
    <!-- Breadcrumb Menu with Background Image -->
    <nav class="relative flex items-center justify-center py-20 bg-cover bg-center" style="background-image: url('{{ asset('images/about-us.jpg') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="container mx-auto px-4 relative z-10 text-center">
            <ol class="flex space-x-2 text-white justify-center">
                <li><a href="{{ route('home') }}" class="text-blue-400 hover:text-blue-600">Home</a></li>
                <li class="text-gray-300">/</li>
                <li class="text-gray-300">About Us</li>
            </ol>
            <h1 class="text-4xl font-bold text-white mt-4">About Us</h1>
            <p class="text-lg text-gray-200 mt-2">Learn more about Sahakar Bharati Rajasthan and our mission to empower communities through cooperatives.</p>
        </div>
    </nav>

    <!-- About Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center">
                <!-- Image Section -->
                <div class="md:w-1/2">
                    <img src="{{ asset('images/about-us.jpg') }}" alt="About Us" class="rounded-lg shadow-lg">
                </div>

                <!-- Content Section -->
                <div class="md:w-1/2 md:pl-8 mt-8 md:mt-0">
                    <h2 class="text-3xl font-bold mb-6">Who We Are</h2>
                    <p class="text-gray-600 mb-4">
                        Sahakar Bharati Rajasthan is a part of the nationwide organization, Sahakar Bharati, dedicated to uniting cooperators and cooperatives across India. Our mission is to empower rural and urban communities by promoting the principles of the Cooperative Movement.
                    </p>
                    <p class="text-gray-600 mb-4">
                        We focus on uplifting small farmers, landless laborers, tribal communities, women, self-help groups (SHGs), joint liability groups (JLGs), rural artisans, technicians, and unemployed youth from middle and lower-income backgrounds. Through cooperatives, we aim to drive social and economic progress in Rajasthan.
                    </p>
                    <p class="text-gray-600 mb-4">
                        Our vision is to create a decentralized, labor-intensive economy that fosters rapid, balanced, equitable, and sustainable development. We believe in the power of cooperatives to protect and empower the vulnerable and disadvantaged.
                    </p>
                    <div class="mt-6">
                        <h3 class="text-xl font-semibold mb-4">Our Mission</h3>
                        <ul class="list-disc list-inside text-gray-600">
                            <li class="mb-2">To conduct training camps, seminars, and conferences to educate people about the benefits of cooperatives.</li>
                            <li class="mb-2">To establish self-sustaining and self-reliant cooperative institutions.</li>
                            <li class="mb-2">To protect the autonomy of cooperative institutions from external control and political interference.</li>
                            <li class="mb-2">To advocate for amendments to State and Central Cooperative Acts in alignment with the 97th Constitutional Amendment.</li>
                            <li class="mb-2">To create a network of dedicated cooperators who can drive the cooperative movement forward.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision and Mission Section -->
    <section class="bg-gray-50 py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Our Vision & Mission</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Vision Card 1 -->
                <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col items-center text-center">
                    <div class="bg-blue-100 p-3 rounded-full mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Empowerment</h3>
                    <p class="text-gray-600">
                        To empower small farmers, women, tribal communities, and marginalized groups through cooperative initiatives.
                    </p>
                </div>

                <!-- Vision Card 2 -->
                <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col items-center text-center">
                    <div class="bg-blue-100 p-3 rounded-full mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Decentralized Economy</h3>
                    <p class="text-gray-600">
                        To build a decentralized, labor-intensive economy that ensures equitable and sustainable development.
                    </p>
                </div>

                <!-- Mission Card 1 -->
                <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col items-center text-center">
                    <div class="bg-blue-100 p-3 rounded-full mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Training & Education</h3>
                    <p class="text-gray-600">
                        To conduct regular training programs and workshops to educate people about cooperative principles.
                    </p>
                </div>

                <!-- Mission Card 2 -->
                <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col items-center text-center">
                    <div class="bg-blue-100 p-3 rounded-full mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Policy Advocacy</h3>
                    <p class="text-gray-600">
                        To advocate for policy changes that strengthen the cooperative movement and protect its autonomy.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
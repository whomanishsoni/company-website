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
            <p class="text-lg text-gray-200 mt-2">Explore how Sahakar Bharati Rajasthan empowers communities through the Cooperative Movement.</p>
        </div>
    </nav>

    <!-- Services Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Our Aims & Objectives</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service 1: Public Awareness -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <div class="bg-blue-100 p-3 rounded-full inline-block mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Public Awareness</h3>
                    <p class="text-gray-600 mb-4">
                        We establish branches across the country to educate the public about the Cooperative Movement and Sahakar Bharati’s mission. Our goal is to inspire individuals to join and support this transformative movement.
                    </p>
                    <a href="#" class="text-blue-600 hover:text-blue-800">Learn More →</a>
                </div>

                <!-- Service 2: Cooperative Promotion -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <div class="bg-blue-100 p-3 rounded-full inline-block mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Cooperative Promotion</h3>
                    <p class="text-gray-600 mb-4">
                        We motivate individuals at the National, State, District, Taluka, and Village levels to promote, establish, and manage various types of need-based Cooperatives. Our efforts ensure that cooperatives are accessible to all.
                    </p>
                    <a href="#" class="text-blue-600 hover:text-blue-800">Learn More →</a>
                </div>

                <!-- Service 3: Advisory Services -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <div class="bg-blue-100 p-3 rounded-full inline-block mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Advisory Services</h3>
                    <p class="text-gray-600 mb-4">
                        We offer advisory services in techno-economic areas to assist Cooperatives in resolving operational challenges. Our experts provide guidance to ensure smooth functioning and growth.
                    </p>
                    <a href="#" class="text-blue-600 hover:text-blue-800">Learn More →</a>
                </div>

                <!-- Service 4: Policy Advocacy -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <div class="bg-blue-100 p-3 rounded-full inline-block mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Policy Advocacy</h3>
                    <p class="text-gray-600 mb-4">
                        We advocate on behalf of Cooperatives to State and Central Governments, RBI, NABARD, NHB, CBDT, NITI Aayog, and other institutions. Our goal is to create a favorable environment for cooperatives to thrive.
                    </p>
                    <a href="#" class="text-blue-600 hover:text-blue-800">Learn More →</a>
                </div>

                <!-- Service 5: Research & Development -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <div class="bg-blue-100 p-3 rounded-full inline-block mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Research & Development</h3>
                    <p class="text-gray-600 mb-4">
                        We promote and undertake research, studies, and surveys in various fields, particularly those related to Cooperative, social, and economic sectors. Our findings drive innovation and progress.
                    </p>
                    <a href="#" class="text-blue-600 hover:text-blue-800">Learn More →</a>
                </div>

                <!-- Service 6: Socio-Economic Projects -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <div class="bg-blue-100 p-3 rounded-full inline-block mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Socio-Economic Projects</h3>
                    <p class="text-gray-600 mb-4">
                        We initiate and support projects aimed at improving socio-economic conditions in rural and tribal areas. Our efforts focus on creating sustainable livelihoods and empowering communities.
                    </p>
                    <a href="#" class="text-blue-600 hover:text-blue-800">Learn More →</a>
                </div>
            </div>
        </div>
    </section>
@endsection
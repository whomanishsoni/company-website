@extends('layouts.frontend')

@section('title', 'About Us')

@section('content')
    <!-- Breadcrumb Menu with Background Image -->
    <nav class="relative flex items-center justify-center py-20 bg-cover bg-center" style="background-image: url('images/about-us.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="container mx-auto px-4 relative z-10 text-center">
            <ol class="flex space-x-2 text-white justify-center">
                <li><a href="{{ route('home') }}" class="text-blue-400 hover:text-blue-600">Home</a></li>
                <li class="text-gray-300">/</li>
                <li class="text-gray-300">About Us</li>
            </ol>
            <h1 class="text-4xl font-bold text-white mt-4">About Us</h1>
            <p class="text-lg text-gray-200 mt-2">Learn more about who we are and what we do.</p>
        </div>
    </nav>

    <!-- About Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center">
                <!-- Image Section -->
                <div class="md:w-1/2">
                    <img src="images/about-us.jpg" alt="About Us" class="rounded-lg shadow-lg">
                </div>

                <!-- Content Section -->
                <div class="md:w-1/2 md:pl-8 mt-8 md:mt-0">
                    <h2 class="text-3xl font-bold mb-6">Who We Are</h2>
                    <p class="text-gray-600 mb-4">
                        We are a team of passionate professionals dedicated to delivering high-quality solutions for your business. Our mission is to help you achieve your goals through innovation, creativity, and cutting-edge technology.
                    </p>
                    <p class="text-gray-600 mb-4">
                        With years of experience in the industry, we have the expertise to handle projects of any size and complexity. Whether you're a startup or an established enterprise, we tailor our services to meet your unique needs.
                    </p>
                    <p class="text-gray-600 mb-4">
                        Our core values include integrity, transparency, and a commitment to excellence. We believe in building long-term relationships with our clients by delivering results that exceed expectations.
                    </p>
                    <div class="mt-6">
                        <h3 class="text-xl font-semibold mb-4">Why Choose Us?</h3>
                        <ul class="list-disc list-inside text-gray-600">
                            <li class="mb-2">Experienced and skilled team of professionals.</li>
                            <li class="mb-2">Customized solutions tailored to your business needs.</li>
                            <li class="mb-2">Commitment to delivering projects on time and within budget.</li>
                            <li class="mb-2">Transparent communication and collaboration.</li>
                            <li class="mb-2">Proven track record of successful projects.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Mission Section -->
    {{-- <section class="bg-gray-50 py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Our Mission</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Mission Card 1 -->
                <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col items-center text-center">
                    <div class="bg-blue-100 p-3 rounded-full mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Empowering Businesses</h3>
                    <p class="text-gray-600">
                        We empower businesses by providing innovative solutions that drive growth and success. Our goal is to help you thrive in a competitive market.
                    </p>
                </div>

                <!-- Mission Card 2 -->
                <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col items-center text-center">
                    <div class="bg-blue-100 p-3 rounded-full mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Commitment to Excellence</h3>
                    <p class="text-gray-600">
                        We are committed to delivering excellence in everything we do. From planning to execution, we ensure the highest standards of quality.
                    </p>
                </div>

                <!-- Mission Card 3 -->
                <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col items-center text-center">
                    <div class="bg-blue-100 p-3 rounded-full mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Customer-Centric Approach</h3>
                    <p class="text-gray-600">
                        Our customers are at the heart of everything we do. We listen, understand, and deliver solutions that meet your unique needs.
                    </p>
                </div>

                <!-- Mission Card 4 -->
                <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col items-center text-center">
                    <div class="bg-blue-100 p-3 rounded-full mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Innovation & Creativity</h3>
                    <p class="text-gray-600">
                        We embrace innovation and creativity to solve complex problems and deliver cutting-edge solutions for your business.
                    </p>
                </div>

                <!-- Mission Card 5 -->
                <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col items-center text-center">
                    <div class="bg-blue-100 p-3 rounded-full mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Timely Delivery</h3>
                    <p class="text-gray-600">
                        We understand the importance of time. Our team ensures that every project is delivered on schedule without compromising quality.
                    </p>
                </div>

                <!-- Mission Card 6 -->
                <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col items-center text-center">
                    <div class="bg-blue-100 p-3 rounded-full mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Transparency & Trust</h3>
                    <p class="text-gray-600">
                        We believe in building trust through transparency. Our processes are open, and we keep you informed at every step.
                    </p>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Team Section -->
    {{-- <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Meet Our Team</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Team Member 1 -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <img src="https://via.placeholder.com/150" alt="Team Member" class="w-32 h-32 rounded-full mx-auto mb-4">
                    <h3 class="text-xl font-semibold mb-2">John Doe</h3>
                    <p class="text-gray-600 mb-2">CEO & Founder</p>
                    <p class="text-gray-600">John has over 10 years of experience in the tech industry and is passionate about innovation.</p>
                </div>
                <!-- Team Member 2 -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <img src="https://via.placeholder.com/150" alt="Team Member" class="w-32 h-32 rounded-full mx-auto mb-4">
                    <h3 class="text-xl font-semibold mb-2">Jane Smith</h3>
                    <p class="text-gray-600 mb-2">Creative Director</p>
                    <p class="text-gray-600">Jane specializes in design and user experience, ensuring our solutions are both functional and beautiful.</p>
                </div>
                <!-- Team Member 3 -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <img src="https://via.placeholder.com/150" alt="Team Member" class="w-32 h-32 rounded-full mx-auto mb-4">
                    <h3 class="text-xl font-semibold mb-2">Michael Brown</h3>
                    <p class="text-gray-600 mb-2">Lead Developer</p>
                    <p class="text-gray-600">Michael is a coding wizard who brings ideas to life with his technical expertise.</p>
                </div>
            </div>
        </div>
    </section> --}}
@endsection
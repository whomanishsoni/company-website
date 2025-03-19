<footer class="bg-gray-800 text-white py-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Logo and About -->
            <div>
                <div class="flex flex-col items-left">
                    <!-- Logo Container -->
                    <div class="h-24 w-24 rounded-full bg-white flex items-center justify-center shadow-lg">
                        <!-- Logo -->
                        <img src="{{ asset('images/logo.png') }}" alt="Sahakar Bharati" class="h-full w-auto">
                    </div>
                    <!-- Text Below Logo -->
                    <span class="mt-2 text-lg gray-100 font-semibold text-white">Sahakar Bharati</span>
                </div>
                <p class="text-gray-400 mt-4">We are a team of passionate professionals dedicated to delivering
                    high-quality solutions for your business.</p>
            </div>
            <!-- Quick Links -->
            <div>
                <h3 class="text-xl font-semibold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="/" class="text-gray-400 hover:text-white">Home</a></li>
                    <li><a href="/about" class="text-gray-400 hover:text-white">About</a></li>
                    <li><a href="/services" class="text-gray-400 hover:text-white">Services</a></li>
                    <li><a href="/contact" class="text-gray-400 hover:text-white">Contact</a></li>
                </ul>
            </div>
            <!-- Contact Info -->
            <div>
                <h3 class="text-xl font-semibold mb-4">Contact Info</h3>
                <p class="text-gray-400">506, Sewa Bharti Bhawan,Sahakar Marg, Jaipur, Rajasthan</p>
                {{-- <p class="text-gray-400">+61 123 456 789</p> --}}
                <p class="text-gray-400">info@sahakarbharatirajasthan.org</p>
            </div>
            <!-- Social Media -->
            <div>
                <h3 class="text-xl font-semibold mb-4">Follow Us</h3>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M24 4.56v14.91c0 .98-.81 1.77-1.79 1.77H1.79C.81 21.24 0 20.45 0 19.47V4.56C0 3.58.81 2.79 1.79 2.79h20.42c.98 0 1.79.79 1.79 1.77zM9.6 18.24v-7.2H7.2v7.2h2.4zm-1.2-8.4c.79 0 1.44-.65 1.44-1.44 0-.79-.65-1.44-1.44-1.44-.79 0-1.44.65-1.44 1.44 0 .79.65 1.44 1.44 1.44zm10.8 8.4v-4.08c0-2.18-.47-3.84-3-3.84-1.22 0-2.04.67-2.37 1.3h-.06v-1.1H12v7.2h2.4v-3.6c0-.95.18-1.87 1.36-1.87 1.16 0 1.17 1.08 1.17 1.93v3.54H19.2z" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M22.23 5.924c-.806.358-1.67.6-2.577.71a4.52 4.52 0 001.98-2.49 9.03 9.03 0 01-2.86 1.09 4.51 4.51 0 00-7.69 4.11 12.8 12.8 0 01-9.3-4.71 4.51 4.51 0 001.39 6.02 4.49 4.49 0 01-2.04-.56v.06a4.51 4.51 0 003.62 4.42 4.52 4.52 0 01-2.04.08 4.51 4.51 0 004.21 3.13 9.05 9.05 0 01-5.6 1.93c-.36 0-.72-.02-1.08-.06a12.78 12.78 0 006.92 2.03c8.3 0 12.84-6.88 12.84-12.84 0-.2 0-.39-.01-.58a9.17 9.17 0 002.26-2.34z" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2.04c-5.5 0-9.96 4.46-9.96 9.96 0 4.42 2.87 8.17 6.84 9.5.5.09.68-.22.68-.48v-1.69c-2.77.6-3.36-1.34-3.36-1.34-.46-1.16-1.11-1.47-1.11-1.47-.91-.62.07-.6.07-.6 1 .07 1.53 1.03 1.53 1.03.89 1.52 2.34 1.08 2.91.83.09-.65.35-1.09.63-1.34-2.22-.25-4.55-1.11-4.55-4.94 0-1.09.39-1.98 1.03-2.68-.1-.25-.45-1.27.1-2.64 0 0 .84-.27 2.75 1.02.8-.22 1.65-.33 2.5-.33.85 0 1.7.11 2.5.33 1.91-1.29 2.75-1.02 2.75-1.02.55 1.37.2 2.39.1 2.64.64.7 1.03 1.59 1.03 2.68 0 3.84-2.34 4.68-4.57 4.93.36.31.68.92.68 1.85v2.74c0 .27.18.58.69.48 3.97-1.33 6.84-5.08 6.84-9.5 0-5.5-4.46-9.96-9.96-9.96z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="text-center mt-8">
            <p class="text-gray-400">&copy; 2025 Sahakar Bharati Rajasthan. All rights reserved.</p>
        </div>
    </div>
</footer>

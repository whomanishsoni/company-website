<footer class="bg-gray-800 text-white py-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Logo and About -->
            <div>
                <div class="flex flex-col items-left">
                    <!-- Logo Container -->
                    <div class="h-24 w-24 rounded-full bg-white flex items-center justify-center shadow-lg">
                        @if (!empty($settings['site_logo']))
                            <img src="{{ asset('images/' . $settings['site_logo']) }}" alt="Sahakar Bharati"
                                class="h-full w-auto">
                        @else
                            <img src="{{ asset('images/default-logo.png') }}" alt="Sahakar Bharati" class="h-full w-auto">
                        @endif
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
                <p class="text-gray-400">{{ $settings['contact_email'] ?? 'info@sahakarbharatirajasthan.org' }}</p>
            </div>
            <!-- Social Media -->
            <div>
                <h3 class="text-xl font-semibold mb-4">Follow Us</h3>
                <div class="flex space-x-4">
                    @if (isset($settings['facebook_url']) && filled($settings['facebook_url']))
                        <a href="{{ $settings['facebook_url'] }}" class="text-gray-400 hover:text-white"
                            target="_blank">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 4.56v14.91c0 .98-.81 1.77-1.79 1.77H1.79C.81 21.24 0 20.45 0 19.47V4.56C0 3.58.81 2.79 1.79 2.79h20.42c.98 0 1.79.79 1.79 1.77zM9.6 18.24v-7.2H7.2v7.2h2.4zm-1.2-8.4c.79 0 1.44-.65 1.44-1.44 0-.79-.65-1.44-1.44-1.44-.79 0-1.44.65-1.44 1.44 0 .79.65 1.44 1.44 1.44zm10.8 8.4v-4.08c0-2.18-.47-3.84-3-3.84-1.22 0-2.04.67-2.37 1.3h-.06v-1.1H12v7.2h2.4v-3.6c0-.95.18-1.87 1.36-1.87 1.16 0 1.17 1.08 1.17 1.93v3.54H19.2z" />
                            </svg>
                        </a>
                    @endif
                    @if (isset($settings['twitter_url']) && filled($settings['twitter_url']))
                        <a href="{{ $settings['twitter_url'] }}" class="text-gray-400 hover:text-white" target="_blank">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M22.23 5.924c-.806.358-1.67.6-2.577.71a4.52 4.52 0 001.98-2.49 9.03 9.03 0 01-2.86 1.09 4.51 4.51 0 00-7.69 4.11 12.8 12.8 0 01-9.3-4.71 4.51 4.51 0 001.39 6.02 4.49 4.49 0 01-2.04-.56v.06a4.51 4.51 0 003.62 4.42 4.52 4.52 0 01-2.04.08 4.51 4.51 0 004.21 3.13 9.05 9.05 0 01-5.6 1.93c-.36 0-.72-.02-1.08-.06a12.78 12.78 0 006.92 2.03c8.3 0 12.84-6.88 12.84-12.84 0-.2 0-.39-.01-.58a9.17 9.17 0 002.26-2.34z" />
                            </svg>
                        </a>
                    @endif
                    @if (isset($settings['instagram_url']) && filled($settings['instagram_url']))
                        <a href="{{ $settings['instagram_url'] }}" class="text-gray-400 hover:text-white"
                            target="_blank">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.326 3.608 1.301.975.975 1.24 2.242 1.301 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.326 2.633-1.301 3.608-.975.975-2.242 1.24-3.608 1.301-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.326-3.608-1.301-.975.975-1.24-2.242-1.301-3.608-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.062-1.366.326-2.633 1.301-3.608.975-.975 2.242-1.24 3.608-1.301 1.266-.058 1.646-.07 4.85-.07zm0-2.163c-3.259 0-3.667.014-4.947.072-1.416.062-2.683.344-3.657 1.318-.974.974-1.256 2.241-1.318 3.657-.058 1.28-.072 1.688-.072 4.947s.014 3.667.072 4.947c.062 1.416.344 2.683 1.318 3.657.974.974 2.241 1.256 3.657 1.318 1.28.058 1.688.072 4.947.072s3.667-.014 4.947-.072c1.416-.062 2.683-.344 3.657-1.318.974-.974 1.256-2.241 1.318-3.657.058-1.28.072-1.688.072-4.947s-.014-3.667-.072-4.947c-.062-1.416-.344-2.683-1.318-3.657-.974-.974-2.241-1.256-3.657-1.318-1.28-.058-1.688-.072-4.947-.072zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a4 4 0 110-8 4 4 0 010 8zm5.406-11.845a1.44 1.44 0 11-2.88 0 1.44 1.44 0 012.88 0z" />
                            </svg>
                        </a>
                    @endif
                    @if (isset($settings['linkedin_url']) && filled($settings['linkedin_url']))
                        <a href="{{ $settings['linkedin_url'] }}" class="text-gray-400 hover:text-white"
                            target="_blank">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z" />
                            </svg>
                        </a>
                    @endif
                    @if (isset($settings['youtube_url']) && filled($settings['youtube_url']))
                        <a href="{{ $settings['youtube_url'] }}" class="text-gray-400 hover:text-white" target="_blank">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.5 6.5c-.3-1.1-1.1-2-2.2-2.3C19.3 4 12 4 12 4s-7.3 0-9.3.2c-1.1.3-1.9 1.2-2.2 2.3C.3 8.7 0 12 0 12s.3 3.3.5 5.5c.3 1.1 1.1 2 2.2 2.3 2 .2 9.3.2 9.3.2s7.3 0 9.3-.2c1.1-.3 1.9-1.2 2.2-2.3.2-2.2.5-5.5.5-5.5s-.3-3.3-.5-5.5zm-14.5 9V8.5l6 3.5-6 3.5z" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="text-center mt-8">
            <p class="text-gray-400">&copy; 2025 Sahakar Bharati Rajasthan. All rights reserved.</p>
        </div>
    </div>
</footer>

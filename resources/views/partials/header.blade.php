<nav class="bg-white shadow-lg">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex justify-between">
            <!-- Logo -->
            <div class="flex space-x-7">
                <a href="/" class="flex items-center py-4 px-2">
                    <img src="https://via.placeholder.com/150x50" alt="Company Logo" class="h-10">
                </a>
            </div>

            <!-- Primary Nav (Desktop) -->
            <div class="hidden md:flex items-center space-x-1">
                <a href="/" class="py-4 px-2 text-gray-500 hover:text-gray-900">Home</a>
                <a href="/about" class="py-4 px-2 text-gray-500 hover:text-gray-900">About</a>
                <a href="/services" class="py-4 px-2 text-gray-500 hover:text-gray-900">Services</a>
                <a href="/news" class="py-4 px-2 text-gray-500 hover:text-gray-900">News</a>
                <a href="/contact" class="py-4 px-2 text-gray-500 hover:text-gray-900">Contact</a>
                <a href="/join" class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700">Join Now</a>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <button id="mobileMenuButton" class="text-gray-500 hover:text-gray-900 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu (Dropdown) -->
        <div id="mobileMenu" class="md:hidden hidden mt-2 mb-4">
            <div class="flex flex-col space-y-2">
                <a href="/" class="py-2 px-4 text-gray-500 hover:text-gray-900 w-full">Home</a>
                <a href="/about" class="py-2 px-4 text-gray-500 hover:text-gray-900 w-full">About</a>
                <a href="/services" class="py-2 px-4 text-gray-500 hover:text-gray-900 w-full">Services</a>
                <a href="/news" class="py-2 px-4 text-gray-500 hover:text-gray-900 w-full">News</a>
                <a href="/contact" class="py-2 px-4 text-gray-500 hover:text-gray-900 w-full">Contact</a>
                <a href="/join" class="py-2 px-4 bg-blue-600 text-white rounded-full hover:bg-blue-700 w-full text-center">Join Now</a>
                <br>
            </div>
        </div>
    </div>
</nav>

<!-- JavaScript for Mobile Menu -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const mobileMenu = document.getElementById('mobileMenu');

        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    });
</script>
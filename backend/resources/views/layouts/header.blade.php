<header class="bg-white dark:bg-gray-800 shadow-md">
    <div class="container mx-auto px-4">
        <nav class="flex items-center justify-between py-4">
            <div>
                <a href="{{ url('/') }}" class="text-2xl font-bold text-primary-600">Internship Platform</a>
            </div>
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ url('/') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600">Home</a>
                <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-primary-600">Offers</a>
                <a href="{{ url('/about') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600">About</a>
                <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-primary-600">FAQ</a>
            </div>
            <div class="hidden md:flex items-center space-x-4">
                <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600">Login</a>
                <a href="{{ route('register') }}" class="bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-700">Register</a>
                @include('layouts.theme-switcher')
            </div>
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-gray-600 dark:text-gray-300 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </nav>
    </div>
    <div id="mobile-menu" class="hidden md:hidden">
        <a href="{{ url('/') }}" class="block py-2 px-4 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Home</a>
        <a href="#" class="block py-2 px-4 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Offers</a>
        <a href="{{ url('/about') }}" class="block py-2 px-4 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">About</a>
        <a href="#" class="block py-2 px-4 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">FAQ</a>
        <a href="{{ route('login') }}" class="block py-2 px-4 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Login</a>
        <a href="{{ route('register') }}" class="block py-2 px-4 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Register</a>
        <div class="px-4 py-2">
            @include('layouts.theme-switcher')
        </div>
    </div>
</header>
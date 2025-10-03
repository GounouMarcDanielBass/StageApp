<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Internship Platform</title>
    @vite(['resources/css/main.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    @include('layouts.header')

    <div class="flex">
        <aside class="w-64 bg-white dark:bg-gray-800 shadow-md">
            <div class="p-4">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Admin Menu</h2>
            </div>
            <nav>
                <ul>
                    <li class="px-4 py-2 hover:bg-gray-200 dark:hover:bg-gray-700">
                        <a href="#" class="flex items-center text-gray-700 dark:text-gray-300">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Dashboard
                        </a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-200 dark:hover:bg-gray-700">
                        <a href="#" class="flex items-center text-gray-700 dark:text-gray-300">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197M15 21a6 6 0 006-6v-1a6 6 0 00-9-5.197M12 15a6 6 0 01-6-6v-1a6 6 0 016-6v0z"></path></svg>
                            Users
                        </a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-200 dark:hover:bg-gray-700">
                        <a href="#" class="flex items-center text-gray-700 dark:text-gray-300">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            Offers
                        </a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-200 dark:hover:bg-gray-700">
                        <a href="#" class="flex items-center text-gray-700 dark:text-gray-300">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Applications
                        </a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-200 dark:hover:bg-gray-700">
                        <a href="#" class="flex items-center text-gray-700 dark:text-gray-300">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                            Settings
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="flex-1 p-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Administrator Dashboard</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Total Users</h2>
                    <p class="text-3xl font-bold text-gray-700 dark:text-gray-300">1,234</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Total Offers</h2>
                    <p class="text-3xl font-bold text-gray-700 dark:text-gray-300">567</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Pending Applications</h2>
                    <p class="text-3xl font-bold text-gray-700 dark:text-gray-300">89</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Validated Internships</h2>
                    <p class="text-3xl font-bold text-gray-700 dark:text-gray-300">432</p>
                </div>
            </div>

            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Recent Activity</h2>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                    <ul>
                        <li class="flex items-center justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                            <p class="text-gray-700 dark:text-gray-300">New user registered: John Doe</p>
                            <span class="text-sm text-gray-500 dark:text-gray-400">2 hours ago</span>
                        </li>
                        <li class="flex items-center justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                            <p class="text-gray-700 dark:text-gray-300">New offer posted: "Frontend Developer" by Company Inc.</p>
                            <span class="text-sm text-gray-500 dark:text-gray-400">5 hours ago</span>
                        </li>
                        <li class="flex items-center justify-between py-2">
                            <p class="text-gray-700 dark:text-gray-300">Application received for "Backend Developer"</p>
                            <span class="text-sm text-gray-500 dark:text-gray-400">1 day ago</span>
                        </li>
                    </ul>
                </div>
            </div>
        </main>
    </div>

    @include('layouts.footer')
</body>
</html>
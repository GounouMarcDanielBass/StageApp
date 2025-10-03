<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard - Internship Platform</title>
    @vite(['resources/css/main.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    @include('layouts.header')

    <div class="flex">
        <aside class="w-64 bg-white dark:bg-gray-800 shadow-md">
            <div class="p-4">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Teacher Menu</h2>
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
                            My Students
                        </a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-200 dark:hover:bg-gray-700">
                        <a href="#" class="flex items-center text-gray-700 dark:text-gray-300">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Reports
                        </a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-200 dark:hover:bg-gray-700">
                        <a href="#" class="flex items-center text-gray-700 dark:text-gray-300">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h4M8 7a2 2 0 012-2h4a2 2 0 012 2v8a2 2 0 01-2 2h-4a2 2 0 01-2-2z"></path></svg>
                            Evaluations
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="flex-1 p-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Teacher Dashboard</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Assigned Students</h2>
                    <p class="text-3xl font-bold text-gray-700 dark:text-gray-300">15</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Pending Reports</h2>
                    <p class="text-3xl font-bold text-gray-700 dark:text-gray-300">4</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Completed Evaluations</h2>
                    <p class="text-3xl font-bold text-gray-700 dark:text-gray-300">11</p>
                </div>
            </div>

            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Recent Student Activity</h2>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                    <ul>
                        <li class="flex items-center justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                            <div>
                                <p class="text-gray-700 dark:text-gray-300 font-bold">John Doe</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Submitted intermediate report</p>
                            </div>
                            <a href="#" class="text-sm text-blue-500 hover:underline">View Report</a>
                        </li>
                        <li class="flex items-center justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                            <div>
                                <p class="text-gray-700 dark:text-gray-300 font-bold">Jane Smith</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Received final evaluation</p>
                            </div>
                            <a href="#" class="text-sm text-blue-500 hover:underline">View Evaluation</a>
                        </li>
                        <li class="flex items-center justify-between py-2">
                            <div>
                                <p class="text-gray-700 dark:text-gray-300 font-bold">Peter Jones</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Internship completed</p>
                            </div>
                            <span class="text-sm text-green-500">Validated</span>
                        </li>
                    </ul>
                </div>
            </div>
        </main>
    </div>

    @include('layouts.footer')
</body>
</html>
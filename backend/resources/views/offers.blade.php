<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internship Offers - Internship Platform</title>
    @vite(['resources/css/main.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-text">
    @include('layouts.header')

    <main class="container mx-auto px-4 py-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white">Internship Offers</h1>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">Explore thousands of opportunities from top companies.</p>
        </div>

        <div class="mb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" placeholder="Keywords" class="p-3 border rounded-md col-span-1 md:col-span-2">
                <input type="text" placeholder="Location" class="p-3 border rounded-md">
                <button class="bg-primary-600 text-white px-6 py-3 rounded-md">Search</button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Offer Card -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Software Engineer Intern</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Tech Solutions Inc.</p>
                <p class="mt-2 text-gray-600 dark:text-gray-400">New York, NY</p>
                <div class="mt-4">
                    <span class="bg-primary-100 text-primary-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">Full-time</span>
                    <span class="bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">Remote</span>
                </div>
                <a href="#" class="mt-6 inline-block text-primary-600 hover:underline">View Details</a>
            </div>
            <!-- Repeat Offer Card for more offers -->
        </div>
    </main>

    @include('layouts.footer')
</body>
</html>
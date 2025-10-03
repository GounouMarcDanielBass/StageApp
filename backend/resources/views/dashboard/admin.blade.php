@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Administrator Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Quick Stats -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Total Students</h2>
            <p class="text-3xl font-bold text-primary">1,234</p>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Total Companies</h2>
            <p class="text-3xl font-bold text-primary">567</p>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Pending Applications</h2>
            <p class="text-3xl font-bold text-primary">89</p>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Active Internships</h2>
            <p class="text-3xl font-bold text-primary">45</p>
        </div>
    </div>

    <div class="mt-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Recent Activities</h2>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <!-- Activity items will be dynamically loaded here -->
            <p class="text-gray-700 dark:text-gray-300">No recent activities.</p>
        </div>
    </div>
</div>
@endsection
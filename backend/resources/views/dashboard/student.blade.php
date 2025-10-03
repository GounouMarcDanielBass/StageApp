@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Student Dashboard</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Quick Stats -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Applications</h2>
            <p class="text-3xl font-bold text-blue-600">5</p>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Interviews</h2>
            <p class="text-3xl font-bold text-green-600">2</p>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Offers</h2>
            <p class="text-3xl font-bold text-yellow-600">1</p>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Messages</h2>
            <p class="text-3xl font-bold text-red-600">3</p>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="mt-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Recent Activity</h2>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <ul>
                <li class="border-b border-gray-200 dark:border-gray-700 py-2">You applied for the Web Developer Intern position.</li>
                <li class="border-b border-gray-200 dark:border-gray-700 py-2">You have an interview scheduled with Tech Solutions Inc.</li>
                <li class="py-2">You received a new message from your supervisor.</li>
            </ul>
        </div>
    </div>
</div>
@endsection
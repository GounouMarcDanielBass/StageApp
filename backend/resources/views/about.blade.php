@extends('layouts.app')

@section('content')
    <main class="container mx-auto px-4 py-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white">About Our Platform</h1>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">Connecting talent with opportunity.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Our Mission</h2>
                <p class="text-gray-700 dark:text-gray-300 mb-4">
                    Our mission is to bridge the gap between students and companies, providing a seamless and efficient platform for discovering and managing internships. We believe that practical experience is crucial for career development, and we are dedicated to making that experience accessible to all.
                </p>
                <p class="text-gray-700 dark:text-gray-300">
                    We strive to create a community where students can grow, companies can find the best talent, and educational institutions can support their students' professional journeys.
                </p>
            </div>
            <div>
                <img src="{{ asset('images/about-us.jpg') }}" alt="Our Team" class="rounded-lg shadow-lg">
            </div>
        </div>

        <div class="mt-16">
            <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-8">Why Choose Us?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md text-center">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">For Students</h3>
                    <p class="text-gray-700 dark:text-gray-300">Access a wide range of internship opportunities, build your profile, and track your applications with ease.</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md text-center">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">For Companies</h3>
                    <p class="text-gray-700 dark:text-gray-300">Post offers, manage applications, and connect with a diverse pool of talented and motivated students.</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md text-center">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">For Institutions</h3>
                    <p class="text-gray-700 dark:text-gray-300">Monitor your students' progress, validate reports, and collaborate with companies to ensure a successful internship experience.</p>
                </div>
            </div>
        </div>
    </main>
@endsection
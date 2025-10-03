@extends('layouts.app')

@section('content')
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white p-4">
            <h2 class="text-2xl font-bold mb-4">Company Dashboard</h2>
            <nav>
                <a href="#" class="block py-2 px-4 rounded hover:bg-gray-700">Dashboard</a>
                <a href="#" class="block py-2 px-4 rounded hover:bg-gray-700">Internship Offers</a>
                <a href="#" class="block py-2 px-4 rounded hover:bg-gray-700">Applications</a>
                <a href="#" class="block py-2 px-4 rounded hover:bg-gray-700">Profile</a>
            </nav>
        </div>

        <!-- Main content -->
        <div class="flex-1 p-10">
            <h1 class="text-3xl font-bold mb-6">Welcome, Company!</h1>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-bold mb-2">Active Offers</h3>
                    <p class="text-3xl font-bold text-blue-500">5</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-bold mb-2">New Applications</h3>
                    <p class="text-3xl font-bold text-green-500">12</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-bold mb-2">Interns</h3>
                    <p class="text-3xl font-bold text-purple-500">3</p>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-bold mb-4">Recent Applications</h3>
                <ul>
                    <li class="border-b py-2">
                        <p class="font-semibold">John Doe</p>
                        <p class="text-sm text-gray-600">Applied for "Web Developer Intern"</p>
                    </li>
                    <li class="border-b py-2">
                        <p class="font-semibold">Jane Smith</p>
                        <p class="text-sm text-gray-600">Applied for "UI/UX Designer Intern"</p>
                    </li>
                    <li class="py-2">
                        <p class="font-semibold">Peter Jones</p>
                        <p class="text-sm text-gray-600">Applied for "Software Engineer Intern"</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
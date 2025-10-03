@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="bg-primary-600 text-white text-center py-20">
        <div class="container mx-auto">
            <h1 class="text-4xl font-bold">Find Your Next Internship</h1>
            <p class="mt-4 text-lg">Explore thousands of opportunities from top companies.</p>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-20">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                <div>
                    <h2 class="text-4xl font-bold text-primary-600">{{ $stats['total_offers'] }}+</h2>
                    <p class="text-gray-600">Internship Offers</p>
                </div>
                <div>
                    <h2 class="text-4xl font-bold text-primary-600">{{ $stats['total_companies'] }}+</h2>
                    <p class="text-gray-600">Companies</p>
                </div>
                <div>
                    <h2 class="text-4xl font-bold text-primary-600">{{ $stats['total_students'] }}+</h2>
                    <p class="text-gray-600">Students</p>
                </div>
                <div>
                    <h2 class="text-4xl font-bold text-primary-600">{{ $stats['total_internships'] }}+</h2>
                    <p class="text-gray-600">Completed Internships</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Offers Section -->
    <section class="bg-gray-100 dark:bg-gray-800 py-20">
        <div class="container mx-auto">
            <h2 class="text-3xl font-bold text-center mb-12">Recent Internship Offers</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($recentOffers as $offer)
                    <div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-bold">{{ $offer['title'] }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ $offer['company'] }}</p>
                        <p class="text-gray-600 dark:text-gray-400"><i class="fas fa-map-marker-alt"></i> {{ $offer['location'] }}</p>
                        <div class="mt-4">
                            <span class="bg-primary-100 text-primary-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">{{ $offer['duration'] }} months</span>
                        </div>
                        <a href="{{ route('offres.show', $offer['id']) }}" class="text-primary-600 hover:underline mt-6 inline-block">View Details</a>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('offres') }}" class="bg-primary-600 text-white px-6 py-3 rounded-md">View All Offers</a>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-20">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold mb-12">How It Works</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-6">
                    <div class="text-5xl text-primary-600 mb-4"><i class="fas fa-user-plus"></i></div>
                    <h3 class="text-xl font-bold mb-2">Create Account</h3>
                    <p class="text-gray-600">Sign up and create your student profile.</p>
                </div>
                <div class="p-6">
                    <div class="text-5xl text-primary-600 mb-4"><i class="fas fa-search"></i></div>
                    <h3 class="text-xl font-bold mb-2">Find Internships</h3>
                    <p class="text-gray-600">Search and filter to find the perfect internship.</p>
                </div>
                <div class="p-6">
                    <div class="text-5xl text-primary-600 mb-4"><i class="fas fa-file-alt"></i></div>
                    <h3 class="text-xl font-bold mb-2">Apply</h3>
                    <p class="text-gray-600">Apply to internships with your online profile.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
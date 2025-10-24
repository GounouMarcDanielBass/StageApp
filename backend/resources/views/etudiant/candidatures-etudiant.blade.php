@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 student-bg">
    <!-- Hero Section -->
    <section class="relative py-20 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600/20 to-purple-600/20"></div>
        <div class="relative container mx-auto px-4 text-center">
            <h1 class="text-5xl font-bold text-gray-900 dark:text-white mb-6 animate-fade-in-up">
                Mes Candidatures
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 animate-fade-in-up animation-delay-200">
                Suivez l'état de vos candidatures aux offres de stage
            </p>
            <div class="animate-fade-in-up animation-delay-400">
                <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-full transition duration-300 transform hover:scale-105">
                    Nouvelle Candidature
                </button>
            </div>
        </div>
    </section>

    <!-- Candidatures List -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Example Candidature Card -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 animate-fade-in-up">
                    <div class="mb-4">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Développeur Frontend</h3>
                        <p class="text-gray-600 dark:text-gray-300">Tech Solutions Inc.</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-sm">En Attente</span>
                        <button class="text-blue-600 hover:text-blue-700">Voir Détails</button>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 animate-fade-in-up animation-delay-200">
                    <div class="mb-4">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Designer UI/UX</h3>
                        <p class="text-gray-600 dark:text-gray-300">Creative Minds</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm">Acceptée</span>
                        <button class="text-blue-600 hover:text-blue-700">Voir Détails</button>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 animate-fade-in-up animation-delay-400">
                    <div class="mb-4">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Développeur Backend</h3>
                        <p class="text-gray-600 dark:text-gray-300">DataCorp</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-sm">Rejetée</span>
                        <button class="text-blue-600 hover:text-blue-700">Voir Détails</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-white dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="animate-fade-in-up">
                    <div class="text-4xl font-bold text-blue-600 mb-2">12</div>
                    <div class="text-gray-600 dark:text-gray-300">Candidatures Totales</div>
                </div>
                <div class="animate-fade-in-up animation-delay-200">
                    <div class="text-4xl font-bold text-green-600 mb-2">5</div>
                    <div class="text-gray-600 dark:text-gray-300">Acceptées</div>
                </div>
                <div class="animate-fade-in-up animation-delay-400">
                    <div class="text-4xl font-bold text-yellow-600 mb-2">3</div>
                    <div class="text-gray-600 dark:text-gray-300">En Attente</div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
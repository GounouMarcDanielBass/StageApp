@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-100 dark:from-gray-900 dark:to-gray-800">
    <!-- Hero Section -->
    <section class="relative py-20 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-green-600/20 to-teal-600/20"></div>
        <div class="relative container mx-auto px-4 text-center">
            <h1 class="text-5xl font-bold text-gray-900 dark:text-white mb-6 animate-fade-in-up">
                Gestion des Offres de Stage
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 animate-fade-in-up animation-delay-200">
                Créez, modifiez et suivez vos offres de stage
            </p>
            <div class="animate-fade-in-up animation-delay-400">
                <button class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-full transition duration-300 transform hover:scale-105">
                    Créer une Nouvelle Offre
                </button>
            </div>
        </div>
    </section>

    <!-- Offers List -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Example Offer Card -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 animate-fade-in-up">
                    <div class="mb-4">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Développeur Frontend</h3>
                        <p class="text-gray-600 dark:text-gray-300">Stage de 6 mois</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Publié le 15/10/2025</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm">Active</span>
                        <div class="space-x-2">
                            <button class="text-green-600 hover:text-green-700">Modifier</button>
                            <button class="text-red-600 hover:text-red-700">Supprimer</button>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 animate-fade-in-up animation-delay-200">
                    <div class="mb-4">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Designer UI/UX</h3>
                        <p class="text-gray-600 dark:text-gray-300">Stage de 4 mois</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Publié le 10/10/2025</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm">Complet</span>
                        <div class="space-x-2">
                            <button class="text-green-600 hover:text-green-700">Modifier</button>
                            <button class="text-red-600 hover:text-red-700">Supprimer</button>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 animate-fade-in-up animation-delay-400">
                    <div class="mb-4">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Développeur Backend</h3>
                        <p class="text-gray-600 dark:text-gray-300">Stage de 5 mois</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Publié le 05/10/2025</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-sm">Brouillon</span>
                        <div class="space-x-2">
                            <button class="text-green-600 hover:text-green-700">Modifier</button>
                            <button class="text-red-600 hover:text-red-700">Supprimer</button>
                        </div>
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
                    <div class="text-4xl font-bold text-green-600 mb-2">8</div>
                    <div class="text-gray-600 dark:text-gray-300">Offres Actives</div>
                </div>
                <div class="animate-fade-in-up animation-delay-200">
                    <div class="text-4xl font-bold text-blue-600 mb-2">45</div>
                    <div class="text-gray-600 dark:text-gray-300">Candidatures Reçues</div>
                </div>
                <div class="animate-fade-in-up animation-delay-400">
                    <div class="text-4xl font-bold text-purple-600 mb-2">12</div>
                    <div class="text-gray-600 dark:text-gray-300">Stages Pourvus</div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
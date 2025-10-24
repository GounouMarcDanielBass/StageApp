@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-100 dark:from-gray-900 dark:to-gray-800 entreprise-bg">
    <!-- Hero Section -->
    <section class="relative py-20 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-green-600/20 to-teal-600/20"></div>
        <div class="relative container mx-auto px-4 text-center">
            <h1 class="text-5xl font-bold text-gray-900 dark:text-white mb-6 animate-fade-in-up">
                Candidatures Reçues
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 animate-fade-in-up animation-delay-200">
                Gérez les candidatures à vos offres de stage
            </p>
        </div>
    </section>

    <!-- Candidatures List -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Example Candidature Card -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 animate-fade-in-up">
                    <div class="mb-4">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Jean Dupont</h3>
                        <p class="text-gray-600 dark:text-gray-300">Candidature pour Développeur Frontend</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Reçue le 20/10/2025</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-sm">En Attente</span>
                        <div class="space-x-2">
                            <button class="text-blue-600 hover:text-blue-700">Voir CV</button>
                            <button class="text-green-600 hover:text-green-700">Accepter</button>
                            <button class="text-red-600 hover:text-red-700">Refuser</button>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 animate-fade-in-up animation-delay-200">
                    <div class="mb-4">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Marie Martin</h3>
                        <p class="text-gray-600 dark:text-gray-300">Candidature pour Designer UI/UX</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Reçue le 18/10/2025</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm">Acceptée</span>
                        <div class="space-x-2">
                            <button class="text-blue-600 hover:text-blue-700">Voir CV</button>
                            <button class="text-purple-600 hover:text-purple-700">Contacter</button>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 animate-fade-in-up animation-delay-400">
                    <div class="mb-4">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Pierre Durand</h3>
                        <p class="text-gray-600 dark:text-gray-300">Candidature pour Développeur Backend</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Reçue le 15/10/2025</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-sm">Refusée</span>
                        <div class="space-x-2">
                            <button class="text-blue-600 hover:text-blue-700">Voir CV</button>
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
                    <div class="text-4xl font-bold text-green-600 mb-2">45</div>
                    <div class="text-gray-600 dark:text-gray-300">Candidatures Totales</div>
                </div>
                <div class="animate-fade-in-up animation-delay-200">
                    <div class="text-4xl font-bold text-blue-600 mb-2">12</div>
                    <div class="text-gray-600 dark:text-gray-300">En Attente</div>
                </div>
                <div class="animate-fade-in-up animation-delay-400">
                    <div class="text-4xl font-bold text-purple-600 mb-2">8</div>
                    <div class="text-gray-600 dark:text-gray-300">Acceptées</div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
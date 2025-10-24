@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-red-50 to-pink-100 dark:from-gray-900 dark:to-gray-800 admin-bg">
    <!-- Hero Section -->
    <section class="relative py-20 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-red-600/20 to-pink-600/20"></div>
        <div class="relative container mx-auto px-4 text-center">
            <h1 class="text-5xl font-bold text-gray-900 dark:text-white mb-6 animate-fade-in-up">
                Gestion des Utilisateurs
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 animate-fade-in-up animation-delay-200">
                Administrez les comptes utilisateurs du système
            </p>
        </div>
    </section>

    <!-- Users Management -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Liste des Utilisateurs</h2>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-300">
                        Ajouter un Utilisateur
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700">
                                <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Nom</th>
                                <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Email</th>
                                <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Rôle</th>
                                <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Statut</th>
                                <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <td class="px-4 py-2 text-gray-900 dark:text-white">Jean Dupont</td>
                                <td class="px-4 py-2 text-gray-600 dark:text-gray-300">jean.dupont@example.com</td>
                                <td class="px-4 py-2">
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm">Étudiant</span>
                                </td>
                                <td class="px-4 py-2">
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm">Actif</span>
                                </td>
                                <td class="px-4 py-2 space-x-2">
                                    <button class="text-blue-600 hover:text-blue-700">Modifier</button>
                                    <button class="text-red-600 hover:text-red-700">Supprimer</button>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <td class="px-4 py-2 text-gray-900 dark:text-white">Marie Martin</td>
                                <td class="px-4 py-2 text-gray-600 dark:text-gray-300">marie.martin@example.com</td>
                                <td class="px-4 py-2">
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm">Entreprise</span>
                                </td>
                                <td class="px-4 py-2">
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm">Actif</span>
                                </td>
                                <td class="px-4 py-2 space-x-2">
                                    <button class="text-blue-600 hover:text-blue-700">Modifier</button>
                                    <button class="text-red-600 hover:text-red-700">Supprimer</button>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <td class="px-4 py-2 text-gray-900 dark:text-white">Pierre Durand</td>
                                <td class="px-4 py-2 text-gray-600 dark:text-gray-300">pierre.durand@example.com</td>
                                <td class="px-4 py-2">
                                    <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-sm">Encadrant</span>
                                </td>
                                <td class="px-4 py-2">
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-sm">Inactif</span>
                                </td>
                                <td class="px-4 py-2 space-x-2">
                                    <button class="text-blue-600 hover:text-blue-700">Modifier</button>
                                    <button class="text-red-600 hover:text-red-700">Supprimer</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-white dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                <div class="animate-fade-in-up">
                    <div class="text-4xl font-bold text-blue-600 mb-2">150</div>
                    <div class="text-gray-600 dark:text-gray-300">Étudiants</div>
                </div>
                <div class="animate-fade-in-up animation-delay-200">
                    <div class="text-4xl font-bold text-green-600 mb-2">45</div>
                    <div class="text-gray-600 dark:text-gray-300">Entreprises</div>
                </div>
                <div class="animate-fade-in-up animation-delay-400">
                    <div class="text-4xl font-bold text-purple-600 mb-2">20</div>
                    <div class="text-gray-600 dark:text-gray-300">Encadrants</div>
                </div>
                <div class="animate-fade-in-up animation-delay-600">
                    <div class="text-4xl font-bold text-red-600 mb-2">5</div>
                    <div class="text-gray-600 dark:text-gray-300">Administrateurs</div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
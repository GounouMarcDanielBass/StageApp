@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-pink-100 dark:from-gray-900 dark:to-gray-800 entreprise-bg">
    <!-- Hero Section -->
    <section class="relative py-20 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-600/20 to-pink-600/20"></div>
        <div class="relative container mx-auto px-4 text-center">
            <h1 class="text-5xl font-bold text-gray-900 dark:text-white mb-6 animate-fade-in-up">
                Détail de la Candidature
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 animate-fade-in-up animation-delay-200">
                Consultez les détails et le statut de votre candidature
            </p>
        </div>
    </section>

    <!-- Candidature Details -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Développeur Frontend</h2>
                        <p class="text-xl text-gray-600 dark:text-gray-300 mb-2">Tech Solutions Inc.</p>
                        <p class="text-gray-500 dark:text-gray-400">Stage de 6 mois • Publié le 15/10/2025</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Informations sur l'Offre</h3>
                            <ul class="space-y-2 text-gray-600 dark:text-gray-300">
                                <li><strong>Salaire:</strong> 800€/mois</li>
                                <li><strong>Localisation:</strong> Paris, France</li>
                                <li><strong>Type:</strong> Stage conventionné</li>
                                <li><strong>Date limite:</strong> 30/11/2025</li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Statut de la Candidature</h3>
                            <div class="flex items-center space-x-4">
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">En Attente</span>
                                <span class="text-gray-500 dark:text-gray-400">Soumise le 20/10/2025</span>
                            </div>
                            <div class="mt-4">
                                <h4 class="font-bold text-gray-900 dark:text-white">Prochaines Étapes:</h4>
                                <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mt-2">
                                    <li>Attendre la réponse de l'entreprise</li>
                                    <li>Préparer un entretien si sélectionné</li>
                                    <li>Finaliser les documents si accepté</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-8">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Description du Poste</h3>
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            Nous recherchons un développeur frontend passionné pour rejoindre notre équipe. Vous travaillerez sur des projets innovants en utilisant les dernières technologies web. Ce stage est une opportunité unique d'apprendre et de contribuer à des projets réels.
                        </p>
                    </div>

                    <div class="mt-8 flex space-x-4">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-300">
                            Modifier la Candidature
                        </button>
                        <button class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg transition duration-300">
                            Retirer la Candidature
                        </button>
                        <button class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition duration-300">
                            Contacter l'Entreprise
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
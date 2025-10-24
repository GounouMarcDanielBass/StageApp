<header class="bg-white dark:bg-gray-800 shadow-md">
    <div class="container mx-auto px-4">
        <nav class="flex items-center justify-between py-4">
            <div>
                <a href="{{ url('/') }}" class="text-2xl font-bold text-primary-600">Internship Platform</a>
            </div>
            <div class="hidden md:flex items-center space-x-8">
                @if(auth()->check())
                    @if(auth()->user()->isEtudiant())
                        <a href="{{ route('dashboard.student') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600">Dashboard</a>
                        <a href="{{ route('etudiant.candidatures') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600">Candidatures</a>
                        <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-primary-600">Profile</a>
                    @elseif(auth()->user()->isEntreprise())
                        <a href="{{ route('dashboard.company') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600">Dashboard</a>
                        <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-primary-600">Offres</a>
                        <a href="{{ route('etudiant.candidatures') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600">Candidatures</a>
                    @elseif(auth()->user()->isEncadrant())
                        <a href="{{ route('dashboard.teacher') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600">Dashboard</a>
                        <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-primary-600">Suivi Étudiants</a>
                        <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-primary-600">Évaluations</a>
                    @elseif(auth()->user()->isAdmin())
                        <a href="{{ route('dashboard.admin') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600">Dashboard</a>
                        <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-primary-600">Gestion Utilisateurs</a>
                        <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-primary-600">Statistiques</a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600">Profile</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-600 dark:text-gray-300 hover:text-primary-600">Logout</button>
                    </form>
                @else
                    <a href="{{ url('/') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600">Home</a>
                    <a href="{{ route('offres-stage') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600">Offers</a>
                    <a href="{{ url('/about') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600">About</a>
                    <a href="{{ url('/faq') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600">FAQ</a>
                @endif
                @include('layouts.theme-switcher')
            </div>
            <div class="hidden md:flex items-center space-x-4">
                @if(!auth()->check())
                    <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600">Login</a>
                    <a href="{{ route('register') }}" class="bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-700">Register</a>
                @endif
            </div>
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-gray-600 dark:text-gray-300 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </nav>
    </div>
    <div id="mobile-menu" class="hidden md:hidden">
        @if(auth()->check())
            @if(auth()->user()->isEtudiant())
                <a href="{{ route('dashboard.student') }}" class="block py-2 px-4 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Dashboard</a>
                <a href="#" class="block py-2 px-4 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Candidatures</a>
                <a href="#" class="block py-2 px-4 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Profile</a>
            @elseif(auth()->user()->isEntreprise())
                <a href="{{ route('dashboard.company') }}" class="block py-2 px-4 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Dashboard</a>
                <a href="#" class="block py-2 px-4 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Offres</a>
                <a href="#" class="block py-2 px-4 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Candidatures</a>
            @elseif(auth()->user()->isEncadrant())
                <a href="{{ route('dashboard.teacher') }}" class="block py-2 px-4 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Dashboard</a>
                <a href="#" class="block py-2 px-4 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Suivi Étudiants</a>
                <a href="#" class="block py-2 px-4 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Évaluations</a>
            @elseif(auth()->user()->isAdmin())
                <a href="{{ route('dashboard.admin') }}" class="block py-2 px-4 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Dashboard</a>
                <a href="#" class="block py-2 px-4 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Gestion Utilisateurs</a>
                <a href="#" class="block py-2 px-4 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Statistiques</a>
            @endif
            <a href="{{ route('profile.edit') }}" class="block py-2 px-4 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Profile</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="block py-2 px-4 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Logout</button>
            </form>
        @else
            <a href="{{ url('/') }}" class="block py-2 px-4 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Home</a>
            <a href="{{ route('offres-stage') }}" class="block py-2 px-4 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Offers</a>
            <a href="{{ url('/about') }}" class="block py-2 px-4 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">About</a>
            <a href="{{ url('/faq') }}" class="block py-2 px-4 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">FAQ</a>
            <a href="{{ route('login') }}" class="block py-2 px-4 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Login</a>
            <a href="{{ route('register') }}" class="block py-2 px-4 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Register</a>
        @endif
        <div class="px-4 py-2">
            @include('layouts.theme-switcher')
        </div>
    </div>
</header>
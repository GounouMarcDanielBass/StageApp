<!-- Navbar Start -->
<header id="topnav" class="defaultscroll sticky">
    <div class="container">
        <!-- Logo -->
        <a class="logo" href="{{ route('home') }}">
            <span class="logo-light-mode">
                <img src="{{ asset('images/logo-dark.png') }}" class="l-dark" alt="">
                <img src="{{ asset('images/logo-light.png') }}" class="l-light" alt="">
            </span>
            <img src="{{ asset('images/logo-light.png') }}" class="logo-dark-mode" alt="">
        </a>

        <!-- Menu -->
        <div class="menu-extras">
            <div class="menu-item">
                <a class="navbar-toggle" id="isToggle" onclick="toggleMenu()">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
            </div>
        </div>

        <!-- Navigation -->
        <div id="navigation">
            <ul class="navigation-menu nav-left">
                <li><a href="{{ route('home') }}" class="sub-menu-item">Accueil</a></li>
                <li><a href="{{ route('offres') }}" class="sub-menu-item">Offres de Stages</a></li>
                <li><a href="{{ route('about') }}" class="sub-menu-item">À propos</a></li>
                <li><a href="{{ route('faq') }}" class="sub-menu-item">FAQ</a></li>
                @auth
                    <li><a href="{{ route('dashboard') }}" class="sub-menu-item">Tableau de bord</a></li>
                @endauth
            </ul>

            @guest
                <ul class="navigation-menu nav-right">
                    <li class="ms-1">
                        <a href="{{ route('login') }}" class="btn btn-primary">Se connecter</a>
                    </li>
                    <li class="ms-1">
                        <a href="{{ route('register') }}" class="btn btn-soft-primary">S'inscrire</a>
                    </li>
                </ul>
            @else
                <ul class="navigation-menu nav-right">
                    <li class="dropdown ms-1">
                        <button class="btn btn-icon btn-pills btn-soft-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ auth()->user()->profile_photo_url }}" class="avatar avatar-ex-small rounded-circle" alt="">
                        </button>
                        <div class="dropdown-menu dd-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="mdi mdi-account-circle me-2"></i> Modifier le Profil
                            </a>
                            <a class="dropdown-item" href="{{ route('profile.settings') }}">
                                <i class="mdi mdi-cog me-2"></i> Paramètres
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="mdi mdi-logout me-2"></i> Se déconnecter
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            @endguest
        </div>
    </div>
</header>
<!-- Navbar End -->
<header id="topnav" class="defaultscroll sticky bg-white shadow-md">
    <div class="container">
        <a class="logo" href="{{ url('/') }}">
            <span class="logo-light-mode">
                <img src="{{ asset('images/logo-dark.png') }}" class="l-dark h-8" alt="Internship Platform Logo">
                <img src="{{ asset('images/logo-white.png') }}" class="l-light h-8" alt="Internship Platform Logo">
            </span>
            <img src="{{ asset('images/logo-white.png') }}" class="logo-dark-mode h-8" alt="Internship Platform Logo">
        </a>

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

        <ul class="buy-button list-inline mb-0">
            <li class="list-inline-item ps-1 mb-0">
                <div class="dropdown">
                    <button type="button" class="dropdown-toggle btn btn-sm btn-icon btn-pills btn-primary" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i data-feather="search" class="icons"></i>
                    </button>
                    <div class="dropdown-menu dd-menu dropdown-menu-end bg-white dark:bg-gray-800 rounded border-0 mt-3 p-0" style="width: 240px;">
                        <div class="search-bar">
                            <div id="itemSearch" class="menu-search mb-0">
                                <form role="search" method="get" id="searchItemform" class="searchform">
                                    <input type="text" class="form-control rounded border dark:bg-gray-700 dark:text-white dark:border-gray-600" name="s" id="searchItem" placeholder="Search internships...">
                                    <input type="submit" id="searchItemsubmit" value="Search">
                                    <i data-feather="search" class="search-icon fea icon-sm dark:text-gray-400"></i>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </li>

            <!-- Theme Switcher -->
            <li class="list-inline-item ps-1 mb-0">
                @include('layouts.theme-switcher')
            </li>

            @if(auth()->check())
                <li class="list-inline-item ps-1 mb-0">
                    <div class="dropdown dropdown-primary">
                        <button type="button" class="dropdown-toggle btn btn-sm btn-icon btn-pills btn-primary" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ asset('images/team/01.jpg') }}" class="img-fluid rounded-pill avatar avatar-sm" alt="User Profile">
                        </button>
                        <div class="dropdown-menu dd-menu dropdown-menu-end bg-white rounded shadow border-0 mt-3">
                            @if(auth()->user()->isEtudiant())
                                <a href="{{ route('dashboard.student') }}" class="dropdown-item fw-medium fs-6"><i data-feather="user" class="fea icon-sm me-2 align-middle"></i>Dashboard</a>
                                <a href="{{ route('etudiant.candidatures') }}" class="dropdown-item fw-medium fs-6"><i data-feather="file-text" class="fea icon-sm me-2 align-middle"></i>Candidatures</a>
                            @elseif(auth()->user()->isEntreprise())
                                <a href="{{ route('dashboard.company') }}" class="dropdown-item fw-medium fs-6"><i data-feather="user" class="fea icon-sm me-2 align-middle"></i>Dashboard</a>
                                <a href="#" class="dropdown-item fw-medium fs-6"><i data-feather="briefcase" class="fea icon-sm me-2 align-middle"></i>Offres</a>
                                <a href="{{ route('etudiant.candidatures') }}" class="dropdown-item fw-medium fs-6"><i data-feather="file-text" class="fea icon-sm me-2 align-middle"></i>Candidatures</a>
                            @elseif(auth()->user()->isEncadrant())
                                <a href="{{ route('dashboard.teacher') }}" class="dropdown-item fw-medium fs-6"><i data-feather="user" class="fea icon-sm me-2 align-middle"></i>Dashboard</a>
                                <a href="#" class="dropdown-item fw-medium fs-6"><i data-feather="users" class="fea icon-sm me-2 align-middle"></i>Suivi Étudiants</a>
                                <a href="#" class="dropdown-item fw-medium fs-6"><i data-feather="clipboard" class="fea icon-sm me-2 align-middle"></i>Évaluations</a>
                            @elseif(auth()->user()->isAdmin())
                                <a href="{{ route('dashboard.admin') }}" class="dropdown-item fw-medium fs-6"><i data-feather="user" class="fea icon-sm me-2 align-middle"></i>Dashboard</a>
                                <a href="#" class="dropdown-item fw-medium fs-6"><i data-feather="settings" class="fea icon-sm me-2 align-middle"></i>Gestion Utilisateurs</a>
                                <a href="#" class="dropdown-item fw-medium fs-6"><i data-feather="bar-chart" class="fea icon-sm me-2 align-middle"></i>Statistiques</a>
                            @endif
                            <a href="{{ route('profile.edit') }}" class="dropdown-item fw-medium fs-6"><i data-feather="settings" class="fea icon-sm me-2 align-middle"></i>Profile</a>
                            <div class="dropdown-divider border-top"></div>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item fw-medium fs-6"><i data-feather="log-out" class="fea icon-sm me-2 align-middle"></i>Logout</button>
                            </form>
                        </div>
                    </div>
                </li>
            @else
                <li class="list-inline-item ps-1 mb-0">
                    <a href="{{ route('login') }}" class="btn btn-sm btn-pills btn-primary">Login</a>
                </li>
                <li class="list-inline-item ps-1 mb-0">
                    <a href="{{ route('register') }}" class="btn btn-sm btn-pills btn-outline-primary">Register</a>
                </li>
            @endif
        </ul>

        <div id="navigation">
            <ul class="navigation-menu nav-right nav-light">
                <li class="has-submenu parent-menu-item">
                    <a href="javascript:void(0)">Home</a><span class="menu-arrow"></span>
                    <ul class="submenu">
                        <li><a href="{{ url('/') }}" class="sub-menu-item">Home</a></li>
                        <li><a href="{{ route('offres-stage') }}" class="sub-menu-item">Internship Offers</a></li>
                        <li><a href="{{ url('/about') }}" class="sub-menu-item">About Us</a></li>
                        <li><a href="{{ url('/faq') }}" class="sub-menu-item">FAQ</a></li>
                    </ul>
                </li>

                <li class="has-submenu parent-menu-item">
                    <a href="javascript:void(0)">Internships</a><span class="menu-arrow"></span>
                    <ul class="submenu">
                        <li><a href="{{ route('offres-stage') }}" class="sub-menu-item">Browse Internships</a></li>
                        <li><a href="#" class="sub-menu-item">Categories</a></li>
                        <li><a href="#" class="sub-menu-item">Application Guide</a></li>
                    </ul>
                </li>

                <li class="has-submenu parent-menu-item">
                    <a href="javascript:void(0)">Companies</a><span class="menu-arrow"></span>
                    <ul class="submenu">
                        <li><a href="{{ route('employers') }}" class="sub-menu-item">Browse Companies</a></li>
                        <li><a href="#" class="sub-menu-item">Company Profiles</a></li>
                    </ul>
                </li>

                <li class="has-submenu parent-menu-item">
                    <a href="javascript:void(0)">Students</a><span class="menu-arrow"></span>
                    <ul class="submenu">
                        <li><a href="{{ route('candidates') }}" class="sub-menu-item">Student Profiles</a></li>
                        <li><a href="#" class="sub-menu-item">Success Stories</a></li>
                    </ul>
                </li>

                <li class="has-submenu parent-menu-item">
                    <a href="javascript:void(0)">Resources</a><span class="menu-arrow"></span>
                    <ul class="submenu">
                        <li><a href="{{ url('/about') }}" class="sub-menu-item">About Us</a></li>
                        <li><a href="{{ route('services') }}" class="sub-menu-item">Services</a></li>
                        <li><a href="{{ route('blogs') }}" class="sub-menu-item">Blog</a></li>
                        <li class="has-submenu parent-menu-item">
                            <a href="javascript:void(0)">Help Center</a><span class="submenu-arrow"></span>
                            <ul class="submenu">
                                <li><a href="{{ route('helpcenter.overview') }}" class="sub-menu-item">Overview</a></li>
                                <li><a href="{{ route('helpcenter.faqs') }}" class="sub-menu-item">FAQs</a></li>
                                <li><a href="{{ route('helpcenter.guides') }}" class="sub-menu-item">Guides</a></li>
                                <li><a href="{{ route('helpcenter.support') }}" class="sub-menu-item">Support</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ url('/contact') }}" class="sub-menu-item">Contact</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</header>
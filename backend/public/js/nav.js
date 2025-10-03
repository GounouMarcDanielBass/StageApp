document.addEventListener('DOMContentLoaded', async () => {
    const navbarContainer = document.getElementById('navbar-container');
    if (!navbarContainer) return;

    // Inject the basic navbar structure
    navbarContainer.innerHTML = `
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
            <div class="container">
                <a class="navbar-brand" href="index.html"><strong>Stage</strong>Connect</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto"></ul>
                </div>
            </div>
        </nav>
    `;

    const token = localStorage.getItem('auth_token');
    const navbarNav = navbarContainer.querySelector('.navbar-nav');

    if (token) {
        try {
            const response = await fetch('/api/auth/me', {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                const user = await response.json();
                // User is authenticated, update navbar
                navbarNav.innerHTML = `
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="offres-stage.html">Offres de Stage</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.html">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="faq.html">FAQ</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i> ${user.name}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Profil</a></li>
                            <li><a class="dropdown-item" href="#">Paramètres</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" id="logoutBtn">Déconnexion</a></li>
                        </ul>
                    </li>
                `;

                document.getElementById('logoutBtn').addEventListener('click', async () => {
                    try {
                        await fetch('/api/auth/logout', {
                            method: 'POST',
                            headers: {
                                'Authorization': `Bearer ${token}`,
                                'Accept': 'application/json'
                            }
                        });
                    } finally {
                        localStorage.removeItem('auth_token');
                        window.location.href = 'login.html';
                    }
                });

            } else {
                // Token is invalid, show default navbar
                showDefaultNavbar(navbarNav);
            }
        } catch (error) {
            console.error('Error fetching user data:', error);
            showDefaultNavbar(navbarNav);
        }
    } else {
        // No token, show default navbar
        showDefaultNavbar(navbarNav);
    }
});

function showDefaultNavbar(navbarNav) {
    navbarNav.innerHTML = `
        <li class="nav-item">
            <a class="nav-link" href="index.html">Accueil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="offres-stage.html">Offres de Stage</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="about.html">À propos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="faq.html">FAQ</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="contact.html">Contact</a>
        </li>
        <li class="nav-item ms-lg-3">
            <a class="btn btn-outline-primary" href="login.html">Connexion</a>
        </li>
        <li class="nav-item ms-lg-2">
            <a class="btn btn-primary" href="signup.html">Inscription</a>
        </li>
    `;
}
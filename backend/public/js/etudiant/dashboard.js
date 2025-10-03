document.addEventListener('DOMContentLoaded', function() {
    // Vérification de l'authentification
    const token = localStorage.getItem('token');
    if (!token) {
        window.location.href = '../login.html';
        return;
    }

    // Chargement des données de l'utilisateur
    loadUserData();
    
    // Chargement des statistiques
    loadStatistics();
    
    // Chargement des activités récentes
    loadRecentActivities();

    // Gestion de la déconnexion
    document.getElementById('logout').addEventListener('click', function(e) {
        e.preventDefault();
        logout();
    });
});

async function loadUserData() {
    try {
        const response = await fetch('/api/user', {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error('Erreur lors du chargement des données utilisateur');
        }

        const data = await response.json();
        
        // Vérification du rôle
        if (data.role !== 'etudiant') {
            window.location.href = '../login.html';
            return;
        }

        // Mise à jour du message de bienvenue
        document.getElementById('welcome-message').textContent = `Bienvenue ${data.name}`;

    } catch (error) {
        console.error('Erreur:', error);
        showError('Erreur lors du chargement des données utilisateur');
    }
}

async function loadStatistics() {
    try {
        const response = await fetch('/api/etudiant/statistics', {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error('Erreur lors du chargement des statistiques');
        }

        const data = await response.json();
        
        // Mise à jour des compteurs avec animation
        animateCounter('candidatures-count', data.candidatures_count);
        animateCounter('pending-count', data.pending_count);
        animateCounter('interviews-count', data.interviews_count);
        animateCounter('offers-count', data.offers_count);

    } catch (error) {
        console.error('Erreur:', error);
        showError('Erreur lors du chargement des statistiques');
    }
}

async function loadRecentActivities() {
    const activitiesList = document.getElementById('activities-list');
    
    try {
        const response = await fetch('/api/etudiant/activities', {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error('Erreur lors du chargement des activités');
        }

        const activities = await response.json();
        
        // Effacer le spinner
        activitiesList.innerHTML = '';

        if (activities.length === 0) {
            activitiesList.innerHTML = `
                <div class="text-center text-muted">
                    <i class="fas fa-info-circle fa-2x mb-2"></i>
                    <p>Aucune activité récente</p>
                </div>
            `;
            return;
        }

        // Afficher les activités
        activities.forEach(activity => {
            const date = new Date(activity.created_at).toLocaleDateString('fr-FR', {
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            const item = document.createElement('div');
            item.className = 'list-group-item list-group-item-action animate-on-scroll';
            item.setAttribute('data-animation', 'slide-in');
            
            let icon = '';
            switch(activity.type) {
                case 'candidature':
                    icon = '<i class="fas fa-paper-plane text-primary"></i>';
                    break;
                case 'entretien':
                    icon = '<i class="fas fa-calendar-check text-success"></i>';
                    break;
                case 'offre':
                    icon = '<i class="fas fa-briefcase text-warning"></i>';
                    break;
                default:
                    icon = '<i class="fas fa-info-circle text-info"></i>';
            }

            item.innerHTML = `
                <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1">
                        ${icon}
                        ${activity.title}
                    </h6>
                    <small class="text-muted">${date}</small>
                </div>
                <p class="mb-1">${activity.description}</p>
                ${activity.link ? `<small><a href="${activity.link}">Voir plus</a></small>` : ''}
            `;

            activitiesList.appendChild(item);
        });

    } catch (error) {
        console.error('Erreur:', error);
        activitiesList.innerHTML = `
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                Erreur lors du chargement des activités
            </div>
        `;
    }
}

function animateCounter(elementId, target) {
    const element = document.getElementById(elementId);
    const duration = 1000;
    const steps = 50;
    const stepDuration = duration / steps;
    const increment = target / steps;
    let current = 0;
    let step = 0;

    const timer = setInterval(() => {
        step++;
        current += increment;
        element.textContent = Math.round(current);

        if (step >= steps) {
            clearInterval(timer);
            element.textContent = target;
        }
    }, stepDuration);
}

async function logout() {
    try {
        const response = await fetch('/api/logout', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error('Erreur lors de la déconnexion');
        }

        // Supprimer le token et rediriger vers la page de connexion
        localStorage.removeItem('token');
        window.location.href = '../login.html';

    } catch (error) {
        console.error('Erreur:', error);
        showError('Erreur lors de la déconnexion');
    }
}

function showError(message) {
    const alert = document.createElement('div');
    alert.className = 'alert alert-danger alert-dismissible fade show';
    alert.innerHTML = `
        <i class="fas fa-exclamation-circle"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    document.querySelector('.container').insertAdjacentElement('afterbegin', alert);
}
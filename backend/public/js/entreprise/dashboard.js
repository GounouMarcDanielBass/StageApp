// Initialisation des animations
document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });

    // Vérification de l'authentification
    checkAuth();

    // Initialisation des événements
    initializeEventListeners();

    // Chargement des données
    loadDashboardData();
});

// Vérification de l'authentification
function checkAuth() {
    const token = localStorage.getItem('access_token');
    if (!token) {
        window.location.href = '/login.html';
        return;
    }

    // Vérification du rôle
    fetch('/api/user', {
        headers: {
            'Authorization': `Bearer ${token}`
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.role !== 'entreprise') {
            window.location.href = '/login.html';
            return;
        }
        document.getElementById('company-name').textContent = data.entreprise.company_name;
    })
    .catch(() => {
        window.location.href = '/login.html';
    });
}

// Initialisation des écouteurs d'événements
function initializeEventListeners() {
    // Menu utilisateur
    const userMenuButton = document.getElementById('user-menu-button');
    const userMenu = document.getElementById('user-menu');
    
    userMenuButton.addEventListener('click', () => {
        const expanded = userMenuButton.getAttribute('aria-expanded') === 'true';
        userMenuButton.setAttribute('aria-expanded', !expanded);
        userMenu.classList.toggle('hidden');
    });

    // Déconnexion
    document.getElementById('logout-button').addEventListener('click', (e) => {
        e.preventDefault();
        logout();
    });

    // Fermeture du menu au clic en dehors
    document.addEventListener('click', (e) => {
        if (!userMenuButton.contains(e.target) && !userMenu.contains(e.target)) {
            userMenuButton.setAttribute('aria-expanded', 'false');
            userMenu.classList.add('hidden');
        }
    });
}

// Chargement des données du tableau de bord
async function loadDashboardData() {
    const token = localStorage.getItem('access_token');
    
    try {
        // Chargement des statistiques
        const statsResponse = await fetch('/api/entreprise/statistics', {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });
        const stats = await statsResponse.json();
        
        updateStatistics(stats);
        
        // Chargement des activités récentes
        const activitiesResponse = await fetch('/api/entreprise/activities', {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });
        const activities = await activitiesResponse.json();
        
        displayActivities(activities);
        
        // Chargement des données pour les graphiques
        const chartsDataResponse = await fetch('/api/entreprise/charts-data', {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });
        const chartsData = await chartsDataResponse.json();
        
        initializeCharts(chartsData);
    } catch (error) {
        console.error('Erreur lors du chargement des données:', error);
        // Afficher un message d'erreur à l'utilisateur
    }
}

// Mise à jour des statistiques
function updateStatistics(stats) {
    // Animation des compteurs
    animateCounter('stages-count', stats.total_stages);
    animateCounter('active-stages-count', stats.active_stages);
    animateCounter('candidatures-count', stats.total_applications);
    animateCounter('interviews-count', stats.scheduled_interviews);
}

// Animation des compteurs
function animateCounter(elementId, targetValue) {
    const element = document.getElementById(elementId);
    const duration = 1000; // Durée de l'animation en ms
    const steps = 50; // Nombre d'étapes
    const stepDuration = duration / steps;
    let currentValue = 0;
    
    const increment = targetValue / steps;
    
    const timer = setInterval(() => {
        currentValue += increment;
        if (currentValue >= targetValue) {
            clearInterval(timer);
            element.textContent = targetValue;
        } else {
            element.textContent = Math.floor(currentValue);
        }
    }, stepDuration);
}

// Affichage des activités récentes
function displayActivities(activities) {
    const activitiesList = document.getElementById('activities-list');
    activitiesList.innerHTML = '';

    activities.forEach(activity => {
        const li = document.createElement('li');
        li.className = 'px-4 py-4 sm:px-6 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200';
        
        const icon = getActivityIcon(activity.type);
        
        li.innerHTML = `
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    ${icon}
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                        ${activity.description}
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        ${formatDate(activity.created_at)}
                    </p>
                </div>
            </div>
        `;
        
        activitiesList.appendChild(li);
    });
}

// Obtention de l'icône en fonction du type d'activité
function getActivityIcon(type) {
    const iconClasses = 'h-6 w-6';
    
    const icons = {
        'new_stage': `<svg class="${iconClasses} text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
        </svg>`,
        'new_application': `<svg class="${iconClasses} text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>`,
        'interview_scheduled': `<svg class="${iconClasses} text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>`,
        'application_status_changed': `<svg class="${iconClasses} text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>`
    };
    
    return icons[type] || icons['new_stage'];
}

// Formatage de la date
function formatDate(dateString) {
    const options = { 
        day: 'numeric', 
        month: 'long', 
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    return new Date(dateString).toLocaleDateString('fr-FR', options);
}

// Initialisation des graphiques
function initializeCharts(data) {
    // Graphique des candidatures par stage
    const applicationsCtx = document.getElementById('applications-chart').getContext('2d');
    new Chart(applicationsCtx, {
        type: 'bar',
        data: {
            labels: data.applications_per_stage.map(item => item.stage_title),
            datasets: [{
                label: 'Nombre de candidatures',
                data: data.applications_per_stage.map(item => item.count),
                backgroundColor: 'rgba(99, 102, 241, 0.5)',
                borderColor: 'rgb(99, 102, 241)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Graphique des statuts des candidatures
    const statusCtx = document.getElementById('status-chart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: data.applications_by_status.map(item => item.status),
            datasets: [{
                data: data.applications_by_status.map(item => item.count),
                backgroundColor: [
                    'rgba(99, 102, 241, 0.5)',  // Indigo
                    'rgba(59, 130, 246, 0.5)',  // Blue
                    'rgba(16, 185, 129, 0.5)',  // Green
                    'rgba(245, 158, 11, 0.5)',  // Yellow
                    'rgba(239, 68, 68, 0.5)'    // Red
                ],
                borderColor: [
                    'rgb(99, 102, 241)',
                    'rgb(59, 130, 246)',
                    'rgb(16, 185, 129)',
                    'rgb(245, 158, 11)',
                    'rgb(239, 68, 68)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}

// Déconnexion
async function logout() {
    const token = localStorage.getItem('access_token');
    
    try {
        await fetch('/api/logout', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });
    } catch (error) {
        console.error('Erreur lors de la déconnexion:', error);
    } finally {
        localStorage.removeItem('access_token');
        window.location.href = '/login.html';
    }
}
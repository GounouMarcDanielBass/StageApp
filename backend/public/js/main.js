// Main JavaScript for StageConnect

// Initialize AOS animations
document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS animation library
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 600,
            easing: 'ease-in-out',
            once: true,
            mirror: false
        });
    }

    // Counter animation
    if ($.fn.counterUp) {
        $('.counter').counterUp({
            delay: 10,
            time: 1000
        });
    }

    // Back to top button
    const backToTopButton = document.getElementById('backToTop');
    
    if (backToTopButton) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.style.display = 'block';
            } else {
                backToTopButton.style.display = 'none';
            }
        });

        backToTopButton.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({top: 0, behavior: 'smooth'});
        });
    }

    // Navbar scroll behavior
    const navbar = document.querySelector('.navbar');
    
    if (navbar) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 50) {
                navbar.classList.add('shadow-sm');
            } else {
                navbar.classList.remove('shadow-sm');
            }
        });
    }

    // Fetch real-time data from backend
    fetchStatistics();
    fetchLatestOffers();
});

// Function to fetch statistics from backend
function fetchStatistics() {
    // This would be replaced with actual API call to Laravel backend
    // For now, we'll simulate with static data
    console.log('Fetching statistics from backend...');
    
    // Example of how to update statistics with real data
    // In a real implementation, you would use fetch() or axios to get data from your Laravel API
    /*
    fetch('/api/statistics')
        .then(response => response.json())
        .then(data => {
            document.querySelector('#entreprises-count').textContent = data.entreprises;
            document.querySelector('#etudiants-count').textContent = data.etudiants;
            document.querySelector('#offres-count').textContent = data.offres;
            document.querySelector('#satisfaction-count').textContent = data.satisfaction;
        })
        .catch(error => console.error('Error fetching statistics:', error));
    */
}

// Function to fetch latest offers from backend
function fetchLatestOffers() {
    // This would be replaced with actual API call to Laravel backend
    // For now, we'll simulate with static data
    console.log('Fetching latest offers from backend...');
    
    // Example of how to update offers with real data
    // In a real implementation, you would use fetch() or axios to get data from your Laravel API
    /*
    fetch('/api/offres/latest')
        .then(response => response.json())
        .then(data => {
            const offersContainer = document.querySelector('#latest-offers .row');
            offersContainer.innerHTML = '';
            
            data.forEach(offer => {
                const offerCard = createOfferCard(offer);
                offersContainer.appendChild(offerCard);
            });
        })
        .catch(error => console.error('Error fetching latest offers:', error));
    */
}

// Helper function to create offer card
function createOfferCard(offer) {
    const card = document.createElement('div');
    card.className = 'col-md-4';
    card.setAttribute('data-aos', 'fade-up');
    
    card.innerHTML = `
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <span class="badge bg-primary mb-2">${offer.categorie}</span>
                <h4 class="card-title">${offer.titre}</h4>
                <p class="company-name text-muted"><i class="fas fa-building me-2"></i>${offer.entreprise}</p>
                <p class="location text-muted"><i class="fas fa-map-marker-alt me-2"></i>${offer.lieu}</p>
                <p class="duration text-muted"><i class="fas fa-calendar-alt me-2"></i>${offer.duree}</p>
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">Publié il y a ${offer.publie_il_y_a}</span>
                    <a href="/offres/${offer.id}" class="btn btn-sm btn-outline-primary">Voir détails</a>
                </div>
            </div>
        </div>
    `;
    
    return card;
}
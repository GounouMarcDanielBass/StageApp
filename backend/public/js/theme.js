// Gestion du thème
document.addEventListener('DOMContentLoaded', () => {
    // Initialisation du thème
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.body.setAttribute('data-theme', savedTheme);
    updateThemeIcon(savedTheme);

    // Gestion du sélecteur de thème
    const themeToggle = document.getElementById('theme-toggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            const currentTheme = document.body.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            document.body.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);
        });
    }

    // Animation du curseur personnalisé
    const cursor = document.createElement('div');
    cursor.classList.add('custom-cursor');
    document.body.appendChild(cursor);

    // Mise à jour de la position du curseur
    document.addEventListener('mousemove', (e) => {
        cursor.style.left = e.clientX + 'px';
        cursor.style.top = e.clientY + 'px';
    });

    // Gestion des interactions avec les éléments
    document.querySelectorAll('a, button, input, select, .clickable').forEach(element => {
        element.addEventListener('mouseenter', () => {
            cursor.classList.add('hover');
        });
        
        element.addEventListener('mouseleave', () => {
            cursor.classList.remove('hover');
        });
    });
});

// Mise à jour de l'icône du thème
function updateThemeIcon(theme) {
    const themeIcon = document.getElementById('theme-icon');
    if (themeIcon) {
        themeIcon.className = theme === 'light' 
            ? 'fas fa-moon theme-switcher-icon' 
            : 'fas fa-sun theme-switcher-icon';
    }
}

// Animation des éléments au défilement
document.addEventListener('DOMContentLoaded', () => {
    const animateOnScroll = () => {
        const elements = document.querySelectorAll('.animate-on-scroll:not(.animated)');
        
        elements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            const elementBottom = element.getBoundingClientRect().bottom;
            
            if (elementTop < window.innerHeight && elementBottom > 0) {
                element.classList.add('animated');
                
                // Ajout des classes d'animation selon l'attribut data-animation
                const animation = element.getAttribute('data-animation') || 'fade-in';
                element.classList.add(animation);
            }
        });
    };

    // Exécuter l'animation au défilement
    window.addEventListener('scroll', animateOnScroll);
    // Exécuter une première fois pour les éléments déjà visibles
    animateOnScroll();
});
// Attendre que le DOM soit chargé et vérifier les préférences d'accessibilité
document.addEventListener('DOMContentLoaded', function() {
    // Vérifier si l'utilisateur préfère les animations réduites
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReducedMotion) {
        return; // Ne pas initialiser les animations de curseur
    }
    // Créer l'élément du curseur personnalisé
    const cursor = document.createElement('div');
    cursor.className = 'custom-cursor';
    document.body.appendChild(cursor);

    // Mettre à jour la position du curseur
    document.addEventListener('mousemove', function(e) {
        cursor.style.left = e.clientX + 'px';
        cursor.style.top = e.clientY + 'px';
    });

    // Gérer les interactions avec les éléments
    const interactiveElements = document.querySelectorAll('a, button, input, select, textarea');
    
    interactiveElements.forEach(element => {
        // Au survol
        element.addEventListener('mouseenter', () => {
            cursor.classList.add('active');
        });

        // À la sortie du survol
        element.addEventListener('mouseleave', () => {
            cursor.classList.remove('active');
        });

        // Au clic
        element.addEventListener('mousedown', () => {
            cursor.style.transform = 'translate(-50%, -50%) scale(0.8)';
        });

        // Au relâchement du clic
        element.addEventListener('mouseup', () => {
            cursor.style.transform = 'translate(-50%, -50%) scale(1)';
        });
    });

    // Gérer le survol des cartes
    const cards = document.querySelectorAll('.card');
    
    cards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            cursor.style.mixBlendMode = 'difference';
            cursor.style.border = '2px solid white';
        });

        card.addEventListener('mouseleave', () => {
            cursor.style.mixBlendMode = 'normal';
            cursor.style.border = '2px solid var(--primary)';
        });
    });

    // Gérer le survol des images
    const images = document.querySelectorAll('img');
    
    images.forEach(image => {
        image.addEventListener('mouseenter', () => {
            cursor.style.borderRadius = '0';
            cursor.style.width = '40px';
            cursor.style.height = '40px';
            cursor.style.border = '2px solid white';
            cursor.style.mixBlendMode = 'difference';
        });

        image.addEventListener('mouseleave', () => {
            cursor.style.borderRadius = '50%';
            cursor.style.width = '20px';
            cursor.style.height = '20px';
            cursor.style.border = '2px solid var(--primary)';
            cursor.style.mixBlendMode = 'normal';
        });
    });

    // Gérer le survol du texte
    const textElements = document.querySelectorAll('p, h1, h2, h3, h4, h5, h6, span');
    
    textElements.forEach(element => {
        element.addEventListener('mouseenter', () => {
            cursor.style.width = '5px';
            cursor.style.height = '25px';
            cursor.style.borderRadius = '2px';
        });

        element.addEventListener('mouseleave', () => {
            cursor.style.width = '20px';
            cursor.style.height = '20px';
            cursor.style.borderRadius = '50%';
        });
    });

    // Gérer le survol des liens de navigation
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        link.addEventListener('mouseenter', () => {
            cursor.style.backgroundColor = 'var(--primary)';
            cursor.style.mixBlendMode = 'multiply';
        });

        link.addEventListener('mouseleave', () => {
            cursor.style.backgroundColor = 'transparent';
            cursor.style.mixBlendMode = 'normal';
        });
    });

    // Gérer le survol des boutons
    const buttons = document.querySelectorAll('.btn');
    
    buttons.forEach(button => {
        button.addEventListener('mouseenter', () => {
            cursor.style.transform = 'translate(-50%, -50%) scale(1.5)';
            cursor.style.backgroundColor = 'var(--primary)';
            cursor.style.opacity = '0.5';
        });

        button.addEventListener('mouseleave', () => {
            cursor.style.transform = 'translate(-50%, -50%) scale(1)';
            cursor.style.backgroundColor = 'transparent';
            cursor.style.opacity = '1';
        });
    });

    // Gérer le survol des champs de formulaire
    const formFields = document.querySelectorAll('input, textarea, select');
    
    formFields.forEach(field => {
        field.addEventListener('mouseenter', () => {
            cursor.style.transform = 'translate(-50%, -50%) scale(0.5)';
            cursor.style.border = '2px solid var(--primary)';
        });

        field.addEventListener('mouseleave', () => {
            cursor.style.transform = 'translate(-50%, -50%) scale(1)';
            cursor.style.border = '2px solid var(--primary)';
        });

        // Gérer le focus
        field.addEventListener('focus', () => {
            cursor.style.display = 'none';
        });

        field.addEventListener('blur', () => {
            cursor.style.display = 'block';
        });
    });

    // Masquer le curseur par défaut
    document.body.style.cursor = 'none';

    // Gérer la sortie de la fenêtre
    document.addEventListener('mouseout', () => {
        cursor.style.display = 'none';
    });

    document.addEventListener('mouseover', () => {
        cursor.style.display = 'block';
    });

    // Gérer le défilement de la page
    let scrollTimeout;
    window.addEventListener('scroll', () => {
        cursor.style.display = 'none';
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(() => {
            cursor.style.display = 'block';
        }, 150);
    });

    // Gérer les animations de transition de page
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            cursor.style.display = 'none';
        } else {
            cursor.style.display = 'block';
        }
    });
});
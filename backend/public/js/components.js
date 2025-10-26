// Load shared components
async function loadComponents() {
    try {
        // Load navbar
        const navbarResponse = await fetch('components/navbar.html');
        const navbarHtml = await navbarResponse.text();
        document.getElementById('navbar-placeholder').innerHTML = navbarHtml;

        // Load footer
        const footerResponse = await fetch('components/footer.html');
        const footerHtml = await footerResponse.text();
        document.getElementById('footer-placeholder').innerHTML = footerHtml;

        // Initialize Feather icons
        feather.replace();

        // Auth state is now handled dynamically in navbar.html

    } catch (error) {
        console.error('Error loading components:', error);
    }
}

// Theme switching is now handled by theme.js for consistency

// Load components when DOM is ready
document.addEventListener('DOMContentLoaded', loadComponents);
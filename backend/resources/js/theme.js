// Professional Theme Switcher with Smooth Transitions
document.addEventListener('DOMContentLoaded', function() {
    const themeToggleBtn = document.getElementById('theme-toggle');
    const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

    // Get system theme preference
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

    // Initialize theme
    function initializeTheme() {
        const savedTheme = localStorage.getItem('color-theme');
        const systemTheme = prefersDark ? 'dark' : 'light';
        const currentTheme = savedTheme || systemTheme;

        setTheme(currentTheme);

        // Listen for system theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
            if (!localStorage.getItem('color-theme')) {
                setTheme(e.matches ? 'dark' : 'light');
            }
        });
    }

    // Set theme function
    function setTheme(theme) {
        const html = document.documentElement;
        const darkStyles = document.getElementById('dark-theme-styles');

        if (theme === 'dark') {
            html.classList.add('dark');
            if (darkStyles) {
                darkStyles.media = 'all';
            }
            themeToggleLightIcon.classList.remove('hidden');
            themeToggleDarkIcon.classList.add('hidden');
        } else {
            html.classList.remove('dark');
            if (darkStyles) {
                darkStyles.media = 'none';
            }
            themeToggleDarkIcon.classList.remove('hidden');
            themeToggleLightIcon.classList.add('hidden');
        }

        // Add smooth transition class
        html.style.setProperty('--theme-transition', 'all 0.3s ease');

        // Save theme preference
        localStorage.setItem('color-theme', theme);

        // Dispatch custom event for theme change
        window.dispatchEvent(new CustomEvent('themeChanged', { detail: { theme } }));
    }

    // Toggle theme function
    function toggleTheme() {
        const currentTheme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

        // Add transition effect
        document.documentElement.style.setProperty('--theme-transition', 'all 0.3s ease');

        setTheme(newTheme);

        // Add button animation
        themeToggleBtn.style.transform = 'scale(0.95)';
        setTimeout(() => {
            themeToggleBtn.style.transform = 'scale(1)';
        }, 150);
    }

    // Initialize theme on page load
    initializeTheme();

    // Add click event listener
    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', toggleTheme);

        // Add keyboard support
        themeToggleBtn.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggleTheme();
            }
        });

        // Make button focusable
        themeToggleBtn.setAttribute('tabindex', '0');
        themeToggleBtn.setAttribute('role', 'button');
        themeToggleBtn.setAttribute('aria-label', 'Toggle dark mode');
    }

    // Update aria-label based on current theme
    function updateAriaLabel() {
        const currentTheme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
        if (themeToggleBtn) {
            themeToggleBtn.setAttribute('aria-label',
                currentTheme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'
            );
        }
    }

    // Listen for theme changes
    window.addEventListener('themeChanged', updateAriaLabel);

    // Update aria-label initially
    updateAriaLabel();
});
// Attendre que le DOM soit chargé
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser AOS (Animate On Scroll)
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
        mirror: false,
        offset: 50
    });



    // Preloader
    const preloader = document.getElementById('preloader');
    if (preloader) {
        window.addEventListener('load', () => {
            preloader.classList.add('fade-out');
            setTimeout(() => {
                preloader.remove();
            }, 500);
        });
    };

    // Sticky Navbar
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navbar.classList.add('nav-sticky');
            } else {
                navbar.classList.remove('nav-sticky');
            }
        });
    }

    // Counter Animation
    const counterElements = document.querySelectorAll('.counter-value');
    const animationDuration = 2000;
    let animated = false;

    function animateCounter(element) {
        const target = parseInt(element.getAttribute('data-target'));
        const increment = target / (animationDuration / 16);
        let current = 0;

        const updateCounter = () => {
            current += increment;
            if (current < target) {
                element.textContent = Math.ceil(current).toLocaleString();
                requestAnimationFrame(updateCounter);
            } else {
                element.textContent = target.toLocaleString();
            }
        };

        updateCounter();
    }

    function checkCounters() {
        if (!animated) {
            counterElements.forEach(counter => {
                const rect = counter.getBoundingClientRect();
                if (rect.top < window.innerHeight && rect.bottom > 0) {
                    animateCounter(counter);
                    animated = true;
                }
            });
        }
    }

    window.addEventListener('scroll', checkCounters);
    checkCounters();

    // Theme Switcher
    const themeSwitcher = document.querySelector('.t-light-dark');
    if (themeSwitcher) {
        // Check for saved theme preference
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            document.documentElement.setAttribute('data-theme', savedTheme);
            themeSwitcher.innerHTML = savedTheme === 'dark' ? 
                '<span><i class="mdi mdi-brightness-5"></i></span>' : 
                '<span><i class="mdi mdi-brightness-6"></i></span>';
        }

        themeSwitcher.addEventListener('click', function() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            
            themeSwitcher.innerHTML = newTheme === 'dark' ? 
                '<span><i class="mdi mdi-brightness-5"></i></span>' : 
                '<span><i class="mdi mdi-brightness-6"></i></span>';
            themeSwitcher.classList.add('animate-bounceIn');
            
            setTimeout(() => {
                themeSwitcher.classList.remove('animate-bounceIn');
            }, 1000);
        });
    }

    // Back to Top Button
    const backToTop = document.querySelector('.back-to-top');
    if (backToTop) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 100) {
                backToTop.style.display = 'block';
                setTimeout(() => {
                    backToTop.style.opacity = '1';
                }, 10);
            } else {
                backToTop.style.opacity = '0';
                setTimeout(() => {
                    backToTop.style.display = 'none';
                }, 300);
            }
        });

        backToTop.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // Mobile Menu Toggle
    const menuToggle = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    
    if (menuToggle && navbarCollapse) {
        menuToggle.addEventListener('click', function() {
            navbarCollapse.classList.toggle('show');
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!menuToggle.contains(e.target) && !navbarCollapse.contains(e.target)) {
                navbarCollapse.classList.remove('show');
            }
        });
    }

    // Scroll Animation
    const animatedElements = document.querySelectorAll('.animate-on-scroll');
    
    function checkScroll() {
        animatedElements.forEach(element => {
            const rect = element.getBoundingClientRect();
            const triggerPoint = window.innerHeight * 0.8;

            if (rect.top < triggerPoint) {
                element.classList.add('animate-slideInUp');
                element.style.opacity = '1';
            }
        });
    }

    window.addEventListener('scroll', checkScroll);
    checkScroll();

    // Initialize Feather Icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
});
// AOS is initialized in app.js, but we can add custom logic here

// Check for reduced motion preference
const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

if (!prefersReducedMotion) {
    // Add AOS classes to elements that need scroll animations
    const sections = document.querySelectorAll('section, .card, .feature, .testimonial, .blog-post');
    sections.forEach((section, index) => {
        section.setAttribute('data-aos', 'fade-up');
        section.setAttribute('data-aos-delay', (index * 100).toString());
    });

    // Add hover effects and transitions
    const interactiveElements = document.querySelectorAll('button, .btn, a, .card');
    interactiveElements.forEach(element => {
        element.classList.add('transition-all', 'duration-300', 'ease-in-out');
    });
}

// Page loading animation
document.addEventListener('DOMContentLoaded', () => {
    if (!prefersReducedMotion) {
        document.body.classList.add('animate-fade-in');
    }
});
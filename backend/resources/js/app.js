import './bootstrap';
import './theme.js';
import './animations.js';
import './scrolling.js';

// Import AOS for scroll animations
import AOS from 'aos';
import 'aos/dist/aos.css';

// Initialize AOS with options
AOS.init({
    duration: 800,
    easing: 'ease-in-out',
    once: true,
    offset: 100,
});
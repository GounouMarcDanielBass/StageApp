<!-- Theme Switcher Button -->
<button id="theme-toggle" type="button" class="btn btn-sm btn-icon btn-pills btn-outline-primary theme-switcher-btn" title="Toggle theme">
    <!-- Sun Icon (Light Mode) -->
    <svg id="theme-toggle-light-icon" class="theme-icon w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.707.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 5.05A1 1 0 003.636 6.464l.707.707a1 1 0 001.414-1.414l-.707-.707zM3 11a1 1 0 100-2H2a1 1 0 100 2h1zM6.464 16.364a1 1 0 01-1.414 0l-.707-.707a1 1 0 011.414-1.414l.707.707a1 1 0 010 1.414z"></path>
    </svg>
    <!-- Moon Icon (Dark Mode) -->
    <svg id="theme-toggle-dark-icon" class="theme-icon w-4 h-4 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
    </svg>
</button>

<style>
.theme-switcher-btn {
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.theme-switcher-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.theme-switcher-btn:focus {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
}

.theme-icon {
    transition: all 0.3s ease;
}

.theme-switcher-btn svg {
    display: inline-block;
}

/* Dark theme styles for theme switcher */
.dark .theme-switcher-btn {
    border-color: rgba(59, 130, 246, 0.5) !important;
    color: #3b82f6 !important;
}

.dark .theme-switcher-btn:hover {
    background-color: rgba(59, 130, 246, 0.1) !important;
    border-color: #3b82f6 !important;
    color: #3b82f6 !important;
}

/* Smooth transition animations */
* {
    transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
}

/* Dark theme body styles */
.dark body {
    background-color: #161c2d !important;
    color: #ffffff !important;
}

.dark .bg-white {
    background-color: #1f2d3d !important;
}

.dark .text-dark {
    color: #ffffff !important;
}

.dark .text-muted {
    color: #9bacc4 !important;
}

.dark .border {
    border-color: #495057 !important;
}

.dark .form-control {
    background-color: #1f2d3d !important;
    border-color: #495057 !important;
    color: #ffffff !important;
}

.dark .form-control:focus {
    background-color: #1f2d3d !important;
    border-color: #3b82f6 !important;
}

.dark .card {
    background-color: #161c2d !important;
    color: #ffffff !important;
}

.dark .dropdown-menu {
    background-color: #1f2d3d !important;
    border-color: #495057 !important;
}

.dark .dropdown-item {
    color: #ffffff !important;
}

.dark .dropdown-item:hover {
    background-color: rgba(59, 130, 246, 0.1) !important;
    color: #3b82f6 !important;
}
</style>
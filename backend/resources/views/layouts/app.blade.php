<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Feather Icons -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style-dark.css') }}" rel="stylesheet" id="dark-theme-styles">
    <link href="{{ asset('css/themes.css') }}" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Theme Styles and Scripts -->
    <script src="{{ asset('js/theme.js') }}"></script>

    <script>
        // Enable smooth theme transitions
        document.documentElement.style.setProperty('--theme-transition', 'all 0.3s ease');

        // Handle theme loading and page animations
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('color-theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const currentTheme = savedTheme || (prefersDark ? 'dark' : 'light');

            const darkStyles = document.getElementById('dark-theme-styles');
            if (currentTheme === 'dark') {
                darkStyles.media = 'all';
                document.documentElement.classList.add('dark');
            } else {
                darkStyles.media = 'none';
                document.documentElement.classList.remove('dark');
            }

            // Add page loading animation if reduced motion is not preferred
            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            if (!prefersReducedMotion) {
                document.body.classList.add('animate-fade-in');
            }
        });
    </script>
</head>
<body>

    @include('layouts.header')

    <main>
        @yield('content')
    </main>

    @include('layouts.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Feather Icons Init -->
    <script>
        feather.replace()
    </script>
    <!-- Custom Scripts -->
    <script src="{{ asset('js/main.js') }}"></script>
    <!-- Custom Cursor Script -->
    <script src="{{ asset('js/cursor.js') }}"></script>
</body>
</html>
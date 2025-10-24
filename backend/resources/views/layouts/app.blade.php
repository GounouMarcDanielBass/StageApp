<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

    @include('layouts.header')

    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    @include('layouts.footer')

</body>
</html>
    <!-- Custom Cursor Script -->
    <script src="{{ asset('js/cursor.js') }}"></script>
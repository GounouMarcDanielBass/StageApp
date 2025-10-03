<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - Internship Platform</title>
    @vite(['resources/css/main.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-text">
    @include('layouts.header')

    <main class="container mx-auto px-4 py-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white">Frequently Asked Questions</h1>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">Find answers to common questions about our platform.</p>
        </div>

        <div class="max-w-3xl mx-auto">
            <div class="space-y-4" x-data="{ open: null }">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
                    <button @click="open = open === 1 ? null : 1" class="w-full text-left p-4">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-lg text-gray-900 dark:text-white">How do I create an account?</span>
                            <span x-show="open !== 1">+</span>
                            <span x-show="open === 1">-</span>
                        </div>
                    </button>
                    <div x-show="open === 1" class="p-4 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-gray-700 dark:text-gray-300">To create an account, click the "Sign Up" button on the homepage and fill out the registration form. You will be asked to provide your name, email address, and a password.</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
                    <button @click="open = open === 2 ? null : 2" class="w-full text-left p-4">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-lg text-gray-900 dark:text-white">How do I apply for an internship?</span>
                            <span x-show="open !== 2">+</span>
                            <span x-show="open === 2">-</span>
                        </div>
                    </button>
                    <div x-show="open === 2" class="p-4 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-gray-700 dark:text-gray-300">Once you have completed your profile, you can browse the available internships on the "Offers" page. Click on an offer to view the details and then click the "Apply" button to submit your application.</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
                    <button @click="open = open === 3 ? null : 3" class="w-full text-left p-4">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-lg text-gray-900 dark:text-white">Can I upload my CV and other documents?</span>
                            <span x-show="open !== 3">+</span>
                            <span x-show="open === 3">-</span>
                        </div>
                    </button>
                    <div x-show="open === 3" class="p-4 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-gray-700 dark:text-gray-300">Yes, you can upload your CV, motivation letter, and other relevant documents in the "My Documents" section of your dashboard. These documents will be attached to your applications.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('layouts.footer')
</body>
</html>
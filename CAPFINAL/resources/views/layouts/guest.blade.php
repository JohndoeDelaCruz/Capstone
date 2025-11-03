<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                background-color: #f5f5dc; /* Light beige matching landing page */
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <!-- Header with Back to Home Button -->
        <header class="fixed top-3 md:top-6 left-0 right-0 z-50 flex justify-center px-3 md:px-0">
            <div class="bg-white rounded-full shadow-xl px-4 md:px-8 py-3 md:py-4 inline-flex">
                <nav class="flex items-center justify-center">
                    <a href="{{ route('welcome') }}" class="text-gray-900 text-sm md:text-base font-medium hover:text-lime-400 transition-colors duration-300 relative group inline-flex items-center gap-2">
                        <span>←</span>
                        Back to Home
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-lime-400 group-hover:w-full transition-all duration-300"></span>
                    </a>
                </nav>
            </div>
        </header>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-24 sm:pt-32 pb-6 px-4">
            <div class="mb-6 md:mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 text-center">
                    BenguetCropMap
                </h1>
            </div>

            <div class="w-full sm:max-w-md px-4 sm:px-6 py-6 md:py-8 bg-white shadow-xl overflow-hidden rounded-2xl border-t-4 border-lime-400">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>

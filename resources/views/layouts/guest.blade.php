<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-gray-900 via-red-900 to-black">
            <div class="w-full sm:max-w-md flex flex-col items-center mb-6">
                <a href="/" class="transition-transform duration-300 hover:scale-105">
                    <x-application-logo class="w-auto h-40 drop-shadow-2xl filter" />
                </a>
                <h1 class="text-4xl font-extrabold text-white mt-6 tracking-wider text-shadow-lg text-center">
                    LSM <span class="text-red-500">HARIMAU</span>
                </h1>
                <p class="text-gray-300 mt-2 text-sm text-center">Lembaga Swadaya Masyarakat Harapan Rakyat Indonesia Maju</p>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white/10 backdrop-blur-md border border-white/20 shadow-2xl overflow-hidden sm:rounded-2xl relative">
                <!-- Decorative element -->
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-500 via-white to-red-500"></div>
                
                <div class="text-white">
                    {{ $slot }}
                </div>
            </div>
            
            <div class="mt-8 text-gray-400 text-xs">
                &copy; {{ date('Y') }} LSM HARIMAU. All rights reserved.
            </div>
        </div>
    </body>
</html>

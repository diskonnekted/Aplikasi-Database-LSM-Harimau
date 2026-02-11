<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
        <link rel="manifest" href="{{ asset('manifest.json') }}">
        <meta name="theme-color" content="#000000">
        <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 selection:bg-red-100 selection:text-red-700">
        <div class="flex h-screen bg-gray-50/50">
            <!-- Sidebar (Desktop) -->
            <div class="hidden md:flex md:flex-shrink-0">
                @include('layouts.sidebar')
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Top Navigation (Mobile Toggle & Profile) -->
                @include('layouts.navigation')

                <!-- Main Content -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50/50 pb-20 md:pb-8">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <!-- Mobile Bottom Navigation -->
        <div class="md:hidden fixed bottom-0 left-0 z-50 w-full px-4 pb-4">
            <div class="bg-gray-900/90 backdrop-blur-lg rounded-2xl shadow-2xl border border-white/10 flex h-16 w-full overflow-hidden">
                <a href="{{ route('home') }}" class="flex-1 flex flex-col items-center justify-center hover:bg-gray-800 group">
                    <svg class="w-6 h-6 mb-1 {{ request()->routeIs('home') ? 'text-red-500' : 'text-gray-400 group-hover:text-red-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="text-[10px] {{ request()->routeIs('home') ? 'text-red-500' : 'text-gray-400 group-hover:text-red-500' }}">Beranda</span>
                </a>
                <a href="{{ route('news.index') }}" class="flex-1 flex flex-col items-center justify-center hover:bg-gray-800 group">
                    <svg class="w-6 h-6 mb-1 {{ request()->routeIs('news.*') ? 'text-red-500' : 'text-gray-400 group-hover:text-red-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l5 5v11a2 2 0 01-2 2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2v6h6"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 13h8M8 17h8"></path>
                    </svg>
                    <span class="text-[10px] {{ request()->routeIs('news.*') ? 'text-red-500' : 'text-gray-400 group-hover:text-red-500' }}">Berita</span>
                </a>
                <a href="{{ route('public.profile') }}" class="flex-1 flex flex-col items-center justify-center hover:bg-gray-800 group">
                    <svg class="w-6 h-6 mb-1 {{ request()->routeIs('public.profile') ? 'text-red-500' : 'text-gray-400 group-hover:text-red-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="text-[10px] {{ request()->routeIs('public.profile') ? 'text-red-500' : 'text-gray-400 group-hover:text-red-500' }}">Profil</span>
                </a>
                <a href="{{ route('public.reports.create') }}" class="flex-1 flex flex-col items-center justify-center hover:bg-gray-800 group">
                    <svg class="w-6 h-6 mb-1 {{ request()->routeIs('public.reports.*') ? 'text-red-500' : 'text-gray-400 group-hover:text-red-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span class="text-[10px] {{ request()->routeIs('public.reports.*') ? 'text-red-500' : 'text-gray-400 group-hover:text-red-500' }}">Lapor</span>
                </a>
            </div>
        </div>

        <x-pwa-installer />
    </body>
</html>

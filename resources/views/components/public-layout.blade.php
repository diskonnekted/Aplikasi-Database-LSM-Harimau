<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'LSM Harimau') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#000000">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50 flex flex-col min-h-screen selection:bg-red-100 selection:text-red-700">
    <nav class="bg-black border-b-4 border-red-600 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center gap-8">
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center gap-3">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto object-contain">
                            <span class="text-2xl font-bold tracking-tighter">
                                <span class="text-red-600">LSM</span>
                                <span class="text-white ml-1">HARIMAU</span>
                            </span>
                        </a>
                    </div>
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="{{ route('home') }}" class="relative py-2 text-sm font-bold {{ request()->routeIs('home') ? 'text-white' : 'text-gray-300 hover:text-white' }} transition-colors duration-200 group">
                            Beranda
                            @if(request()->routeIs('home'))
                                <span class="absolute bottom-0 left-0 w-full h-1 bg-red-600 rounded-full"></span>
                            @endif
                        </a>
                        <a href="{{ route('public.profile') }}" class="relative py-2 text-sm font-bold {{ request()->routeIs('public.profile') ? 'text-white' : 'text-gray-300 hover:text-white' }} transition-colors duration-200 group">
                            Profil
                            @if(request()->routeIs('public.profile'))
                                <span class="absolute bottom-0 left-0 w-full h-1 bg-red-600 rounded-full"></span>
                            @endif
                        </a>
                        <a href="{{ route('public.rules') }}" class="relative py-2 text-sm font-bold {{ request()->routeIs('public.rules') ? 'text-white' : 'text-gray-300 hover:text-white' }} transition-colors duration-200 group">
                            Tata Tertib
                            @if(request()->routeIs('public.rules'))
                                <span class="absolute bottom-0 left-0 w-full h-1 bg-red-600 rounded-full"></span>
                            @endif
                        </a>
                        <a href="{{ route('news.index') }}" class="relative py-2 text-sm font-bold {{ request()->routeIs('news.*') ? 'text-white' : 'text-gray-300 hover:text-white' }} transition-colors duration-200 group">
                            Berita
                            @if(request()->routeIs('news.*'))
                                <span class="absolute bottom-0 left-0 w-full h-1 bg-red-600 rounded-full"></span>
                            @endif
                        </a>
                        <a href="{{ route('public.reports.create') }}" class="relative py-2 text-sm font-bold {{ request()->routeIs('public.reports.*') ? 'text-white' : 'text-gray-300 hover:text-white' }} transition-colors duration-200 group">
                            Lapor
                            @if(request()->routeIs('public.reports.*'))
                                <span class="absolute bottom-0 left-0 w-full h-1 bg-red-600 rounded-full"></span>
                            @endif
                        </a>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-6">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-bold text-gray-300 hover:text-white transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-white hover:text-gray-200 transition-colors">Login</a>
                        <a href="{{ route('registration') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded font-bold transition-all duration-200 shadow-lg">Daftar Anggota</a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center md:hidden">
                    <button class="p-2 rounded-xl text-gray-400 hover:text-white transition-all">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>


    <main class="flex-grow">
        {{ $slot }}
    </main>

    <footer class="bg-black text-white py-8 border-t-4 border-red-600 mt-auto mb-16 md:mb-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                <!-- Left: Logo & Info -->
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-20 w-auto object-contain">
                    <div>
                        <h3 class="text-xl font-bold text-red-600">LSM HARIMAU</h3>
                        <p class="text-sm text-gray-400">Lembaga Swadaya Masyarakat Harapan Rakyat Indonesia Maju</p>
                    </div>
                </div>

                <!-- Center: Social Media Icons -->
                <div class="flex space-x-6">
                    <a href="https://www.facebook.com/people/Lsm-Harimau/100059036196004/#" target="_blank" class="text-gray-400 hover:text-[#1877F2] transition transform hover:scale-110" title="Facebook">
                        <span class="sr-only">Facebook</span>
                        <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="https://www.youtube.com/@LsmHarimau-j4j" target="_blank" class="text-gray-400 hover:text-[#FF0000] transition transform hover:scale-110" title="YouTube">
                        <span class="sr-only">YouTube</span>
                        <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.254.418-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418zM15.194 12 10 15V9l5.194 3z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="https://www.instagram.com/lsmharimau_indonesia/" target="_blank" class="text-gray-400 hover:text-[#E4405F] transition transform hover:scale-110" title="Instagram">
                        <span class="sr-only">Instagram</span>
                        <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 0 1 1.772 1.153 4.902 4.902 0 0 1 1.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 0 1-1.153 1.772 4.902 4.902 0 0 1-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 0 1-1.772-1.153 4.902 4.902 0 0 1-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 0 1 1.153-1.772 4.902 4.902 0 0 1 1.772-1.153c.636-.247 1.363-.416 2.427-.465C9.673 2.013 10.03 2 12.315 2zm-2.008 1.996c-2.457 0-2.67.01-3.616.052-.945.043-1.461.196-1.805.33-.454.175-.778.384-1.117.723-.339.339-.548.663-.723 1.117-.133.344-.287.86-.33 1.805-.043.946-.052 1.159-.052 3.616s.009 2.67.052 3.616c.043.945.196 1.461.33 1.805.175.454.384.778.723 1.117.339.339.663.548 1.117.723.344.133.86.287 1.805.33.946.043 1.159.052 3.616.052s2.67-.009 3.616-.052c.945-.043 1.461-.196 1.805-.33.454-.175.778-.384 1.117-.723.339-.339.548-.663.723-1.117.133-.344.287-.86.33-1.805.043-.946.052-1.159.052-3.616s-.009-2.67-.052-3.616c-.043-.945-.196-1.461-.33-1.805-.175-.454-.384-.778-.723-1.117-.339-.339-.663-.548-1.117-.723-.344-.133-.86-.287-1.805-.33-.946-.043-1.159-.052-3.616-.052zm0 3.602a5.397 5.397 0 0 1 5.397 5.397 5.397 5.397 0 0 1-5.397 5.397 5.397 5.397 0 0 1-5.397-5.397 5.397 5.397 0 0 1 5.397-5.397zm0 1.996a3.401 3.401 0 1 0 0 6.802 3.401 3.401 0 0 0 0-6.802zm5.884-2.884a1.328 1.328 0 1 1 0 2.656 1.328 1.328 0 0 1 0-2.656z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>

                <!-- Right: Links -->
                <div class="flex space-x-6 text-sm text-gray-400">
                    <a href="#" class="hover:text-white transition">Kontak</a>
                    <a href="#" class="hover:text-white transition">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition">Terms of Service</a>
                </div>
            </div>
            <div class="mt-8 text-center text-xs text-gray-500">
                &copy; {{ date('Y') }} LSM Harimau. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Mobile Bottom Navigation -->
    <div class="md:hidden fixed bottom-0 left-0 z-50 w-full h-16 bg-black border-t-2 border-red-600">
        <div class="flex h-full w-full font-medium">
            <a href="{{ route('home') }}" class="flex-1 flex flex-col items-center justify-center hover:bg-gray-900 group">
                <svg class="w-6 h-6 mb-1 {{ request()->routeIs('home') ? 'text-red-500' : 'text-gray-400 group-hover:text-red-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="text-[10px] {{ request()->routeIs('home') ? 'text-red-500' : 'text-gray-400 group-hover:text-red-500' }}">Beranda</span>
            </a>
            <a href="{{ route('news.index') }}" class="flex-1 flex flex-col items-center justify-center hover:bg-gray-900 group">
                <svg class="w-6 h-6 mb-1 {{ request()->routeIs('news.*') ? 'text-red-500' : 'text-gray-400 group-hover:text-red-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l5 5v11a2 2 0 01-2 2z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2v6h6"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 13h8M8 17h8"></path>
                </svg>
                <span class="text-[10px] {{ request()->routeIs('news.*') ? 'text-red-500' : 'text-gray-400 group-hover:text-red-500' }}">Berita</span>
            </a>
            <a href="{{ route('public.profile') }}" class="flex-1 flex flex-col items-center justify-center hover:bg-gray-900 group">
                <svg class="w-6 h-6 mb-1 {{ request()->routeIs('public.profile') ? 'text-red-500' : 'text-gray-400 group-hover:text-red-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="text-[10px] {{ request()->routeIs('public.profile') ? 'text-red-500' : 'text-gray-400 group-hover:text-red-500' }}">Profil</span>
            </a>
            <!-- Pendaftaran/Lapor -->
            <a href="{{ route('public.reports.create') }}" class="{{ request()->routeIs('public.reports.*') ? 'text-red-600' : 'text-gray-400' }} flex-1 flex flex-col items-center justify-center transition-colors duration-200">
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                <span class="text-[10px] font-medium uppercase tracking-wider">Lapor</span>
            </a>
        </div>
    </div>

    <x-pwa-installer />
</body>
</html>

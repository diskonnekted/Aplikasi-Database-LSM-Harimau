<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-40">
    <!-- Primary Navigation Menu -->
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Mobile Logo -->
                <div class="shrink-0 flex items-center md:hidden">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <x-application-logo class="block h-10 w-auto" />
                    </a>
                </div>

                <!-- Breadcrumbs or Page Title (Optional) -->
                <div class="hidden md:flex items-center space-x-3 text-sm font-medium text-gray-500">
                    <span class="text-gray-300">/</span>
                    <span class="text-gray-900 font-black text-2xl tracking-tight">
                        @if(request()->routeIs('admin.members.*'))
                            Data Anggota LSM Harimau
                        @elseif(request()->routeIs('admin.news.*'))
                            Berita & Informasi LSM Harimau
                        @elseif(request()->routeIs('admin.pages.*'))
                            Manajemen Halaman Website
                        @else
                            {{ Str::headline(request()->segment(count(request()->segments()))) }}
                        @endif
                    </span>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="flex items-center space-x-4">
                    <!-- Notifications (Placeholder) -->
                    <button class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-50 rounded-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </button>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center space-x-3 p-1 pr-3 hover:bg-gray-50 rounded-xl transition-all duration-200">
                                <img class="h-8 w-8 rounded-lg object-cover ring-2 ring-white shadow-sm" src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}">
                                <div class="text-left hidden lg:block">
                                    <p class="text-sm font-bold text-gray-900 leading-none">{{ Auth::user()->name }}</p>
                                    <p class="text-[10px] text-gray-500 font-medium uppercase tracking-wider mt-0.5">Administrator</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-3 border-b border-gray-50">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-widest">Akun Saya</p>
                            </div>
                            
                            <x-dropdown-link :href="route('profile.edit')" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ __('Profil') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    {{ __('Keluar') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-gray-400 hover:text-gray-900 hover:bg-gray-100 focus:outline-none transition-all duration-200">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-gray-100">
        <div class="pt-2 pb-3 space-y-1 px-2">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="rounded-xl">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.members.index')" :active="request()->routeIs('admin.members.*')" class="rounded-xl">
                {{ __('Anggota') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.news.index')" :active="request()->routeIs('admin.news.*')" class="rounded-xl">
                {{ __('Berita') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-100">
            <div class="flex items-center px-4 mb-4">
                <div class="shrink-0 me-3">
                    <img class="h-10 w-10 rounded-xl object-cover ring-2 ring-red-50" src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}">
                </div>
                <div>
                    <div class="font-bold text-base text-gray-900 leading-none">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-xs text-gray-500 mt-1">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="px-2 space-y-1 pb-4">
                <x-responsive-nav-link :href="route('profile.edit')" class="rounded-xl">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            class="rounded-xl text-red-600 hover:bg-red-50"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>


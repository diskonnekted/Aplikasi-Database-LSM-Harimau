<div class="flex flex-col w-64 h-screen border-r border-white/5" style="background-color: #0b090a !important;">
    <!-- Logo -->
    <div class="flex items-center justify-center px-6 h-28 border-b border-white/5">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-2">
            <img src="{{ asset('images/logo.png') }}" alt="LSM Harimau" class="h-16 w-16 object-contain filter drop-shadow-[0_0_8px_rgba(186,24,27,0.4)]">
            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-white">LSM Harimau</span>
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto custom-scrollbar">
        <div class="pb-2 px-2 text-[10px] font-bold text-gray-500 uppercase tracking-[0.2em]">
            Utama
        </div>
        
        <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span class="font-medium">{{ __('Dashboard') }}</span>
        </x-sidebar-link>

        <div class="pt-6 pb-2 px-2 text-[10px] font-bold text-gray-500 uppercase tracking-[0.2em]">
            Administrasi
        </div>

        <x-sidebar-link :href="route('admin.members.index')" :active="request()->routeIs('admin.members.*')">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <span class="font-medium">{{ __('Data Anggota') }}</span>
        </x-sidebar-link>

        <x-sidebar-link :href="route('admin.news.index')" :active="request()->routeIs('admin.news.*')">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
            </svg>
            <span class="font-medium">{{ __('Berita') }}</span>
        </x-sidebar-link>

        <x-sidebar-link :href="route('admin.pages.index')" :active="request()->routeIs('admin.pages.*')">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <span class="font-medium">{{ __('Halaman') }}</span>
        </x-sidebar-link>

        <div class="pt-6 pb-2 px-2 text-[10px] font-bold text-gray-500 uppercase tracking-[0.2em]">
            Layanan
        </div>

        <x-sidebar-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.*')">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            <span class="font-medium">{{ __('Laporan Masyarakat') }}</span>
        </x-sidebar-link>

        <div class="pt-6 pb-2 px-2 text-[10px] font-bold text-gray-500 uppercase tracking-[0.2em]">
            Sistem
        </div>

        <x-sidebar-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
            </svg>
            <span class="font-medium">{{ __('Manajemen User') }}</span>
        </x-sidebar-link>

        <x-sidebar-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')">
             <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span class="font-medium">{{ __('Pengaturan') }}</span>
        </x-sidebar-link>
    </nav>

    <!-- User Info / Bottom -->
    <div class="p-4 border-t border-white/5 bg-white/5">
        <div class="flex items-center p-2 rounded-xl hover:bg-white/5 transition-all duration-200">
            <div class="flex-shrink-0 relative">
                <img class="h-10 w-10 rounded-xl object-cover ring-2 ring-white/10 shadow-sm" src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}">
                <div class="absolute bottom-0 right-0 h-3 w-3 bg-green-500 border-2 border-[#0b090a] rounded-full"></div>
            </div>
            <div class="ml-3 min-w-0 flex-1">
                <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="ml-2">
                @csrf
                <button type="submit" class="p-2 text-gray-500 hover:text-red-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e5e7eb;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #d1d5db;
    }
</style>

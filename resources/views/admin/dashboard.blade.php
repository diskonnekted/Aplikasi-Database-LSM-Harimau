<x-app-layout>
    <div class="py-8 min-h-screen bg-[#f8f9fa]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="relative overflow-hidden rounded-3xl p-8 shadow-2xl group border border-[#a4161a]/20" style="background-color: #0b090a !important;">
                    <!-- Subtle Glow -->
                    <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#a4161a] opacity-10 rounded-full blur-3xl transition-opacity duration-700 group-hover:opacity-20"></div>
                    
                    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="space-y-1">
                            <h1 class="text-4xl font-black tracking-tight" style="color: #ffffff !important;">Dashboard</h1>
                            <p class="font-medium flex items-center gap-2" style="color: #b1a7a6 !important;">
                                <span class="w-2 h-2 rounded-full bg-[#a4161a] animate-pulse"></span>
                                Selamat datang kembali, {{ Auth::user()->name }}
                            </p>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="px-5 py-2.5 rounded-2xl border border-white/10 flex items-center gap-3" style="background-color: rgba(255, 255, 255, 0.05) !important; backdrop-filter: blur(12px);">
                                <svg class="w-4 h-4 text-[#a4161a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-sm font-bold" style="color: #ffffff !important;">{{ now()->format('l, d F Y') }}</span>
                            </div>
                            <div class="flex items-center">
                                 <img src="{{ asset('images/logo.png') }}" alt="Logo LSM Harimau" class="h-20 w-auto filter drop-shadow-[0_0_8px_rgba(186,24,27,0.4)]">
                             </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                @php
                    $statItems = [
                        [
                            'label' => 'Total Anggota',
                            'value' => $stats['total_members'],
                            'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
                            'color' => '#a4161a',
                            'status' => 'Data Terupdate',
                            'status_color' => 'text-green-600',
                            'status_icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6'
                        ],
                        [
                            'label' => 'Pending',
                            'value' => $stats['pending_members'],
                            'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                            'color' => '#0b090a',
                            'status' => 'Menunggu Tindakan',
                            'status_color' => 'text-orange-600',
                            'status_icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
                        ],
                        [
                            'label' => 'Total Berita',
                            'value' => $stats['total_news'],
                            'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l5 5v11a2 2 0 01-2 2z',
                            'color' => '#660708',
                            'status' => 'Publikasi Aktif',
                            'status_color' => 'text-blue-600',
                            'status_icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'
                        ],
                        [
                            'label' => 'Laporan',
                            'value' => $stats['total_reports'],
                            'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01',
                            'color' => '#e5383b',
                            'status' => 'Perlu Ditinjau',
                            'status_color' => 'text-red-600',
                            'status_icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'
                        ]
                    ];
                @endphp

                @foreach($statItems as $item)
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 rounded-2xl group-hover:scale-110 transition-transform duration-300" style="background-color: {{ $item['color'] }}">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-bold text-[#b1a7a6] uppercase tracking-wider">{{ $item['label'] }}</p>
                            <h3 class="text-3xl font-black text-[#0b090a]">{{ number_format($item['value']) }}</h3>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 {{ $item['status_color'] }} text-[10px] font-bold uppercase tracking-tight">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['status_icon'] }}"></path>
                        </svg>
                        {{ $item['status'] }}
                    </div>
                </div>
                @endforeach
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Recent Members Table -->
                <div class="lg:col-span-8 space-y-6">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-50 flex items-center justify-between" style="background-color: #0b090a !important;">
                            <div>
                                <h3 class="text-lg font-black tracking-tight" style="color: #ffffff !important;">Pendaftaran Terbaru</h3>
                                <p class="text-xs" style="color: #b1a7a6 !important;">Kelola anggota yang baru mendaftar</p>
                            </div>
                            <a href="{{ route('admin.members.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-widest border border-white/10 hover:bg-white/10 transition-all" style="color: #ffffff !important;">
                                Lihat Semua
                            </a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50/50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-[10px] font-black text-[#b1a7a6] uppercase tracking-widest">Informasi Anggota</th>
                                        <th class="px-6 py-4 text-left text-[10px] font-black text-[#b1a7a6] uppercase tracking-widest">Wilayah</th>
                                        <th class="px-6 py-4 text-left text-[10px] font-black text-[#b1a7a6] uppercase tracking-widest">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($recentMembers as $member)
                                    <tr class="hover:bg-gray-50/50 transition-colors group">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-full bg-[#f5f3f4] border border-gray-100 flex items-center justify-center text-sm font-black text-[#0b090a]">
                                                    {{ substr($member->full_name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="text-sm font-bold text-[#161a1d] group-hover:text-[#a4161a] transition-colors">{{ $member->full_name }}</div>
                                                    <div class="text-[10px] font-medium text-[#b1a7a6]">ID: #{{ str_pad($member->id, 5, '0', STR_PAD_LEFT) }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-[#161a1d]">{{ $member->region->name }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full border
                                                @if($member->status === 'approved') bg-green-50 text-green-600 border-green-100
                                                @elseif($member->status === 'rejected') bg-red-50 text-red-600 border-red-100
                                                @else bg-orange-50 text-orange-600 border-orange-100
                                                @endif">
                                                {{ $member->status }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center gap-2 opacity-20">
                                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                                <span class="text-sm font-bold uppercase tracking-widest">Tidak ada data</span>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="lg:col-span-4 space-y-8">
                    <!-- Quick Actions -->
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                        <div class="flex items-center gap-2 mb-6">
                            <div class="w-8 h-8 rounded-lg bg-[#a4161a]/10 flex items-center justify-center text-[#a4161a]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <h3 class="text-lg font-black text-[#0b090a]">Aksi Cepat</h3>
                        </div>
                        <div class="grid gap-4">
                            <a href="{{ route('admin.news.create') }}" class="flex items-center gap-4 p-4 rounded-2xl bg-[#f8f9fa] border border-transparent hover:border-[#a4161a]/10 hover:bg-white hover:shadow-lg transition-all duration-300 group">
                                <div class="w-10 h-10 rounded-xl text-white flex items-center justify-center shadow-lg shadow-red-900/20 group-hover:rotate-12 transition-transform" style="background-color: #a4161a !important;">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm font-bold text-[#161a1d]">Buat Berita</div>
                                    <div class="text-[10px] text-[#b1a7a6] font-medium">Publikasi informasi</div>
                                </div>
                                <svg class="w-4 h-4 text-[#b1a7a6] group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                            <a href="{{ route('admin.members.index') }}" class="flex items-center gap-4 p-4 rounded-2xl bg-[#f8f9fa] border border-transparent hover:border-[#0b090a]/10 hover:bg-white hover:shadow-lg transition-all duration-300 group">
                                <div class="w-10 h-10 rounded-xl text-white flex items-center justify-center shadow-lg group-hover:-rotate-12 transition-transform" style="background-color: #0b090a !important;">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm font-bold text-[#161a1d]">Verifikasi</div>
                                    <div class="text-[10px] text-[#b1a7a6] font-medium">Tinjau pendaftar</div>
                                </div>
                                <svg class="w-4 h-4 text-[#b1a7a6] group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </div>
                    </div>

                    <!-- System Status Card -->
                    <div class="relative overflow-hidden rounded-3xl p-6 shadow-2xl group border border-[#660708]" style="background-color: #161a1d !important;">
                        <!-- Subtle Glow Fix -->
                        <div class="absolute -bottom-12 -left-12 w-32 h-32 bg-[#a4161a] opacity-10 rounded-full blur-3xl group-hover:opacity-20 transition-opacity duration-700"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xs font-black uppercase tracking-widest flex items-center gap-2" style="color: #b1a7a6 !important;">
                                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> Status Sistem
                                </h3>
                                <span class="text-[10px] font-black px-2 py-0.5 rounded-full uppercase tracking-tighter" style="background-color: #ba181b !important; color: #ffffff !important;">Live</span>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-3 rounded-2xl border border-white/5" style="background-color: rgba(255, 255, 255, 0.05) !important;">
                                    <span class="text-[10px] font-bold uppercase tracking-wider" style="color: #b1a7a6 !important;">Waktu Server</span>
                                    <span class="text-xs font-black font-mono" style="color: #ffffff !important;">{{ now()->format('H:i:s') }}</span>
                                </div>
                                <div class="flex items-center justify-between p-3 rounded-2xl border border-white/5" style="background-color: rgba(255, 255, 255, 0.05) !important;">
                                    <span class="text-[10px] font-bold uppercase tracking-wider" style="color: #b1a7a6 !important;">Koneksi DB</span>
                                    <span class="text-[10px] font-black text-green-400 bg-green-400/10 px-2 py-1 rounded-lg">Terhubung</span>
                                </div>
                                <div class="flex items-center justify-between p-3 rounded-2xl border border-white/5" style="background-color: rgba(255, 255, 255, 0.05) !important;">
                                    <span class="text-[10px] font-bold uppercase tracking-wider" style="color: #b1a7a6 !important;">Status Admin</span>
                                    <span class="text-[10px] font-black text-[#a4161a] bg-[#a4161a]/10 px-2 py-1 rounded-lg">Online</span>
                                </div>
                            </div>
                            <div class="mt-6 pt-6 border-t border-white/5 text-center">
                                <p class="text-[8px] font-bold uppercase tracking-[0.2em]" style="color: #b1a7a6 !important;">Versi 1.0.0 • PHP 8.2.12</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-public-layout>
    <div class="min-h-screen bg-gray-900 flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-white rounded-3xl overflow-hidden shadow-2xl relative">
            <!-- Header Background -->
            <div class="h-32 bg-gradient-to-r from-red-900 to-red-600 relative">
                <div class="absolute inset-0 bg-black/20"></div>
                <div class="absolute bottom-0 left-0 w-full h-16 bg-gradient-to-t from-white to-transparent"></div>
            </div>

            <!-- Profile Content -->
            <div class="px-6 pb-8 relative text-center">
                <!-- Photo -->
                <div class="relative -mt-16 mb-4 inline-block">
                    <div class="w-32 h-32 rounded-full border-4 border-white shadow-lg overflow-hidden bg-gray-200 mx-auto relative z-10">
                        @if($member->image_path)
                            <img src="{{ Storage::url($member->image_path) }}" alt="{{ $member->full_name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-100">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <!-- Status Badge -->
                    @if($member->status == 'approved')
                        <div class="absolute bottom-2 right-2 z-20">
                            <svg class="w-8 h-8 text-blue-500 bg-white rounded-full border-2 border-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Name & KTA -->
                <h1 class="text-2xl font-bold text-gray-900 mb-1">{{ $member->full_name }}</h1>
                <p class="text-sm font-medium text-gray-500 mb-6">NO KTA: {{ $member->kta_number }}</p>

                <!-- Validation Status -->
                <div class="mb-8">
                    @if($member->status == 'approved')
                        <div class="inline-flex items-center gap-2 px-6 py-2 rounded-full bg-green-100 text-green-700 border border-green-200">
                            <span class="relative flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                            </span>
                            <span class="font-bold tracking-wide">ANGGOTA VALID</span>
                        </div>
                    @elseif($member->status == 'pending')
                        <div class="inline-flex items-center gap-2 px-6 py-2 rounded-full bg-yellow-100 text-yellow-700 border border-yellow-200">
                            <span class="w-3 h-3 bg-yellow-500 rounded-full"></span>
                            <span class="font-bold tracking-wide">MENUNGGU VERIFIKASI</span>
                        </div>
                    @else
                        <div class="inline-flex items-center gap-2 px-6 py-2 rounded-full bg-red-100 text-red-700 border border-red-200">
                            <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                            <span class="font-bold tracking-wide">TIDAK AKTIF</span>
                        </div>
                    @endif
                </div>

                <!-- Details List -->
                <div class="text-left space-y-4 bg-gray-50 p-6 rounded-2xl border border-gray-100">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Jabatan</p>
                        <p class="font-medium text-gray-800">{{ $member->position ?? 'Anggota' }}</p>
                    </div>
                    
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Wilayah</p>
                        <p class="font-medium text-gray-800">{{ $member->region->name ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Bergabung Sejak</p>
                        <p class="font-medium text-gray-800">{{ $member->join_date ? $member->join_date->format('d F Y') : '-' }}</p>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-8 pt-6 border-t border-gray-100">
                    <p class="text-xs text-gray-400 text-center">
                        Halaman ini adalah bukti validasi keanggotaan resmi<br>
                        <strong>LSM HARIMAU</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
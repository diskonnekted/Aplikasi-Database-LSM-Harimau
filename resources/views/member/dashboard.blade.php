<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Anggota') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="flex-shrink-0 h-20 w-20">
                             @if($member && $member->image_path)
                                <img class="h-20 w-20 rounded-full object-cover" src="{{ Storage::url($member->image_path) }}" alt="{{ $member->full_name }}">
                            @else
                                <div class="h-20 w-20 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold text-xl">
                                    {{ $member ? substr($member->full_name, 0, 1) : '?' }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold">{{ $member ? $member->full_name : Auth::user()->name }}</h3>
                            <p class="text-gray-500">{{ $member ? $member->nik : '' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Status Card -->
                        <div class="bg-gray-50 p-6 rounded-lg border">
                            <h4 class="font-semibold text-lg mb-2">Status Keanggotaan</h4>
                            @if($member)
                                @if($member->status == 'approved')
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Aktif / Disetujui
                                    </span>
                                    <p class="mt-2 text-sm text-gray-600">Selamat! Anda adalah anggota resmi LSM Harimau.</p>
                                    <div class="mt-4">
                                        <p class="font-bold">Nomor KTA: {{ $member->kta_number }}</p>
                                    </div>
                                    <div class="mt-4">
                                        <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow text-sm">
                                            Download KTA (PDF)
                                        </button>
                                    </div>
                                @elseif($member->status == 'pending')
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Menunggu Persetujuan
                                    </span>
                                    <p class="mt-2 text-sm text-gray-600">Pendaftaran Anda sedang diverifikasi oleh admin wilayah.</p>
                                @else
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Ditolak
                                    </span>
                                    <p class="mt-2 text-sm text-gray-600">Maaf, pendaftaran Anda ditolak. Silakan hubungi admin.</p>
                                @endif
                            @else
                                <p class="text-red-500">Data anggota tidak ditemukan.</p>
                            @endif
                        </div>

                        <!-- Info Card -->
                        <div class="bg-gray-50 p-6 rounded-lg border">
                            <h4 class="font-semibold text-lg mb-2">Informasi Wilayah</h4>
                            @if($member && $member->region)
                                <p class="mb-1"><strong>Wilayah:</strong> {{ $member->region->name }}</p>
                                <p class="mb-1"><strong>Tingkat:</strong> {{ ucfirst($member->region->level) }}</p>
                            @else
                                <p class="text-gray-500">Belum ditentukan.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

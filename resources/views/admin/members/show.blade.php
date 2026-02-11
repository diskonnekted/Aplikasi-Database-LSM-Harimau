<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Anggota') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-700">Informasi Anggota</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.members.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                                Kembali
                            </a>
                            <a href="{{ route('admin.members.edit', $member) }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                                Edit
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Photo Column -->
                        <div class="col-span-1 flex flex-col items-center">
                            <!-- Photos Container: Side by Side -->
                            <div class="flex flex-row gap-4 mb-4 w-full justify-center">
                                <!-- Profile Photo -->
                                <div class="w-1/2 flex flex-col items-center">
                                    <span class="text-xs font-semibold text-gray-500 mb-1">Foto Profil</span>
                                    <div class="w-full aspect-[3/4] bg-gray-200 rounded-lg overflow-hidden shadow-md">
                                        @if($member->image_path)
                                            <img src="{{ Storage::url($member->image_path) }}" alt="{{ $member->full_name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- KTP Photo -->
                                <div class="w-1/2 flex flex-col items-center">
                                    <span class="text-xs font-semibold text-gray-500 mb-1">Foto KTP</span>
                                    <div class="w-full aspect-[3/4] bg-gray-200 rounded-lg overflow-hidden shadow-md">
                                        @if($member->ktp_path)
                                            <a href="{{ Storage::url($member->ktp_path) }}" target="_blank">
                                                <img src="{{ Storage::url($member->ktp_path) }}" alt="KTP {{ $member->full_name }}" class="w-full h-full object-cover hover:opacity-75 transition-opacity">
                                            </a>
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            @if($member->status == 'approved')
                            <div class="w-full text-center">
                                <span class="inline-block px-4 py-2 rounded-full bg-green-100 text-green-800 font-semibold mb-4">
                                    Aktif
                                </span>
                                <div>
                                    <a href="{{ route('admin.members.kta', $member) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                                        Cetak KTA
                                    </a>
                                </div>
                            </div>
                            @elseif($member->status == 'pending')
                                <span class="inline-block px-4 py-2 rounded-full bg-yellow-100 text-yellow-800 font-semibold">
                                    Pending
                                </span>
                            @else
                                <span class="inline-block px-4 py-2 rounded-full bg-red-100 text-red-800 font-semibold">
                                    Ditolak
                                </span>
                            @endif
                        </div>

                        <!-- Details Column -->
                        <div class="col-span-1 md:col-span-2">
                            <div class="grid grid-cols-1 gap-y-4">
                                <div class="border-b border-gray-200 pb-4">
                                    <h4 class="text-sm font-medium text-gray-500">Nomor KTA</h4>
                                    <p class="mt-1 text-lg font-bold text-gray-900">{{ $member->kta_number ?? '-' }}</p>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="border-b border-gray-200 pb-4">
                                        <h4 class="text-sm font-medium text-gray-500">Nama Lengkap</h4>
                                        <p class="mt-1 text-base text-gray-900">{{ $member->full_name }}</p>
                                    </div>
                                    <div class="border-b border-gray-200 pb-4">
                                        <h4 class="text-sm font-medium text-gray-500">NIK</h4>
                                        <p class="mt-1 text-base text-gray-900">{{ $member->nik }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="border-b border-gray-200 pb-4">
                                        <h4 class="text-sm font-medium text-gray-500">Tempat, Tanggal Lahir</h4>
                                        <p class="mt-1 text-base text-gray-900">{{ $member->birth_place }}, {{ $member->birth_date ? $member->birth_date->format('d F Y') : '-' }}</p>
                                    </div>
                                    <div class="border-b border-gray-200 pb-4">
                                        <h4 class="text-sm font-medium text-gray-500">Jenis Kelamin</h4>
                                        <p class="mt-1 text-base text-gray-900">{{ $member->gender ?? '-' }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="border-b border-gray-200 pb-4">
                                        <h4 class="text-sm font-medium text-gray-500">Jabatan</h4>
                                        <p class="mt-1 text-base text-gray-900">{{ $member->position ?? '-' }}</p>
                                    </div>
                                    <div class="border-b border-gray-200 pb-4">
                                        <h4 class="text-sm font-medium text-gray-500">Agama</h4>
                                        <p class="mt-1 text-base text-gray-900">{{ $member->religion ?? '-' }}</p>
                                    </div>
                                </div>

                                <div class="border-b border-gray-200 pb-4">
                                    <h4 class="text-sm font-medium text-gray-500">Wilayah Kepengurusan</h4>
                                    <p class="mt-1 text-base text-gray-900">{{ $member->region->name }} ({{ ucfirst($member->region->level) }})</p>
                                </div>

                                <div class="border-b border-gray-200 pb-4">
                                    <h4 class="text-sm font-medium text-gray-500">Alamat Lengkap</h4>
                                    <p class="mt-1 text-base text-gray-900">{{ $member->address }}</p>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="border-b border-gray-200 pb-4">
                                        <h4 class="text-sm font-medium text-gray-500">Nomor Telepon / WhatsApp</h4>
                                        <p class="mt-1 text-base text-gray-900">{{ $member->phone_number }}</p>
                                    </div>
                                    <div class="border-b border-gray-200 pb-4">
                                        <h4 class="text-sm font-medium text-gray-500">Email Akun</h4>
                                        <p class="mt-1 text-base text-gray-900">{{ $member->user->email ?? '-' }}</p>
                                    </div>
                                </div>
                                
                                <div class="border-b border-gray-200 pb-4">
                                    <h4 class="text-sm font-medium text-gray-500">Tanggal Bergabung</h4>
                                    <p class="mt-1 text-base text-gray-900">{{ $member->join_date ? $member->join_date->format('d F Y') : '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
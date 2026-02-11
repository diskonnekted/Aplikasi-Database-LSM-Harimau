<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Laporan: ') }} {{ $report->title }}
            </h2>
            <a href="{{ route('admin.reports.index') }}" class="text-sm text-gray-600 hover:text-gray-900">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-bold mb-4 border-b pb-2">Isi Laporan</h3>
                            <div class="prose max-w-none text-gray-700 whitespace-pre-line">
                                {{ $report->content }}
                            </div>
                        </div>
                    </div>

                    <!-- Workflow History / Status Info -->
                    @if($report->disposition_notes || $report->investigation_notes || $report->resolution_notes)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 space-y-4">
                                <h3 class="text-lg font-bold mb-4 border-b pb-2">Riwayat Penanganan</h3>
                                
                                @if($report->disposition_notes)
                                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                                        <h4 class="font-bold text-blue-800 text-sm mb-1">Disposisi Pimpinan</h4>
                                        <p class="text-sm text-gray-700">{{ $report->disposition_notes }}</p>
                                        @if($report->disposition_to_region_id)
                                            <p class="text-xs text-blue-600 mt-2">Kepada Wilayah: {{ \App\Models\Region::find($report->disposition_to_region_id)->name ?? '-' }}</p>
                                        @endif
                                    </div>
                                @endif

                                @if($report->investigation_notes)
                                    <div class="bg-indigo-50 p-4 rounded-lg border border-indigo-100">
                                        <h4 class="font-bold text-indigo-800 text-sm mb-1">Hasil Investigasi</h4>
                                        <p class="text-sm text-gray-700">{{ $report->investigation_notes }}</p>
                                    </div>
                                @endif

                                @if($report->resolution_notes)
                                    <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                                        <h4 class="font-bold text-green-800 text-sm mb-1">Penyelesaian Akhir</h4>
                                        <p class="text-sm text-gray-700">{{ $report->resolution_notes }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-bold mb-4 border-b pb-2">Bukti Pendukung</h3>
                            @if($report->evidence_path)
                                @php
                                    $extension = pathinfo($report->evidence_path, PATHINFO_EXTENSION);
                                    $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png']);
                                @endphp

                                @if($isImage)
                                    <div class="mb-4">
                                        <img src="{{ Storage::url($report->evidence_path) }}" alt="Bukti Laporan" class="max-w-full h-auto rounded-lg shadow-sm border border-gray-100">
                                    </div>
                                @endif

                                <div class="flex items-center gap-3">
                                    <a href="{{ Storage::url($report->evidence_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-red-50 text-red-600 border border-red-100 rounded-xl text-sm font-bold hover:bg-red-100 transition-all">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Lihat File {{ strtoupper($extension) }}
                                    </a>
                                    <a href="{{ Storage::url($report->evidence_path) }}" download class="inline-flex items-center px-4 py-2 bg-gray-50 text-gray-600 border border-gray-100 rounded-xl text-sm font-bold hover:bg-gray-100 transition-all">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                        Download
                                    </a>
                                </div>
                            @else
                                <div class="p-4 bg-gray-50 rounded-xl text-gray-500 text-sm italic">
                                    Tidak ada bukti yang diunggah.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar / Action Panel -->
                <div class="space-y-6">
                    <!-- Status Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-bold mb-4">Status Laporan</h3>
                            <div class="flex items-center justify-between mb-4">
                                <span class="px-3 py-1 rounded-full text-sm font-semibold bg-{{ $report->status_color }}-100 text-{{ $report->status_color }}-800">
                                    {{ $report->status_label }}
                                </span>
                            </div>

                            <div class="border-t pt-4 mt-4">
                                <h4 class="text-sm font-bold text-gray-700 mb-3">Tindakan Selanjutnya</h4>
                                
                                <form action="{{ route('admin.reports.update', $report) }}" method="POST" class="space-y-4">
                                    @csrf
                                    @method('PATCH')

                                    @if($report->report_status == 'pending')
                                        <!-- Admin Actions -->
                                        <div class="space-y-2">
                                            <button type="submit" name="report_status" value="escalated" class="w-full text-left px-4 py-2 bg-yellow-50 text-yellow-700 hover:bg-yellow-100 rounded-lg border border-yellow-200 text-sm font-medium transition-colors flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                                Teruskan ke Pimpinan
                                            </button>
                                            <button type="button" onclick="document.getElementById('resolveForm').classList.toggle('hidden')" class="w-full text-left px-4 py-2 bg-green-50 text-green-700 hover:bg-green-100 rounded-lg border border-green-200 text-sm font-medium transition-colors flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Selesaikan Langsung
                                            </button>
                                            <button type="submit" name="report_status" value="rejected" class="w-full text-left px-4 py-2 bg-red-50 text-red-700 hover:bg-red-100 rounded-lg border border-red-200 text-sm font-medium transition-colors flex items-center" onclick="return confirm('Apakah Anda yakin ingin menolak laporan ini?')">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                Tolak Laporan
                                            </button>
                                        </div>

                                    @elseif($report->report_status == 'escalated')
                                        <!-- Pimpinan Actions -->
                                        <div class="space-y-2">
                                            <button type="button" onclick="document.getElementById('dispositionForm').classList.toggle('hidden')" class="w-full text-left px-4 py-2 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-lg border border-blue-200 text-sm font-medium transition-colors flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                Disposisi ke Wilayah
                                            </button>
                                            <button type="button" onclick="document.getElementById('resolveForm').classList.toggle('hidden')" class="w-full text-left px-4 py-2 bg-green-50 text-green-700 hover:bg-green-100 rounded-lg border border-green-200 text-sm font-medium transition-colors flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Selesaikan Laporan
                                            </button>
                                        </div>

                                    @elseif($report->report_status == 'disposition')
                                        <!-- Wilayah Actions -->
                                        <div class="space-y-2">
                                            <button type="button" onclick="document.getElementById('investigationForm').classList.toggle('hidden')" class="w-full text-left px-4 py-2 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 rounded-lg border border-indigo-200 text-sm font-medium transition-colors flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                                Lapor Hasil Investigasi
                                            </button>
                                        </div>

                                    @elseif($report->report_status == 'investigation_done')
                                        <!-- Pimpinan Actions (Final Review) -->
                                        <div class="space-y-2">
                                            <button type="button" onclick="document.getElementById('resolveForm').classList.toggle('hidden')" class="w-full text-left px-4 py-2 bg-green-50 text-green-700 hover:bg-green-100 rounded-lg border border-green-200 text-sm font-medium transition-colors flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Verifikasi & Selesaikan
                                            </button>
                                        </div>

                                    @elseif($report->report_status == 'resolved')
                                        <div class="text-center py-4 bg-gray-50 rounded-lg text-gray-500 text-sm">
                                            Laporan telah selesai.
                                        </div>
                                    @endif
                                </form>

                                <!-- Hidden Forms -->
                                <!-- 1. Disposition Form -->
                                <div id="dispositionForm" class="hidden mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <h5 class="font-bold text-gray-700 text-sm mb-3">Form Disposisi</h5>
                                    <form action="{{ route('admin.reports.update', $report) }}" method="POST" class="space-y-3">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="report_status" value="disposition">
                                        
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Pilih Wilayah</label>
                                            <select name="disposition_to_region_id" class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:border-red-500 focus:ring-red-500" required>
                                                <option value="">-- Pilih Wilayah --</option>
                                                @foreach($regions as $region)
                                                    <option value="{{ $region->id }}">{{ $region->name }} ({{ ucfirst($region->level) }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Catatan Disposisi</label>
                                            <textarea name="disposition_notes" rows="3" class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:border-red-500 focus:ring-red-500" placeholder="Instruksi investigasi..." required></textarea>
                                        </div>
                                        <div class="flex justify-end gap-2">
                                            <button type="button" onclick="document.getElementById('dispositionForm').classList.add('hidden')" class="px-3 py-1 text-xs text-gray-500 hover:text-gray-700">Batal</button>
                                            <button type="submit" class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">Kirim Disposisi</button>
                                        </div>
                                    </form>
                                </div>

                                <!-- 2. Investigation Form -->
                                <div id="investigationForm" class="hidden mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <h5 class="font-bold text-gray-700 text-sm mb-3">Lapor Hasil Investigasi</h5>
                                    <form action="{{ route('admin.reports.update', $report) }}" method="POST" class="space-y-3">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="report_status" value="investigation_done">
                                        
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Hasil Temuan</label>
                                            <textarea name="investigation_notes" rows="4" class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:border-red-500 focus:ring-red-500" placeholder="Jelaskan hasil investigasi di lapangan..." required></textarea>
                                        </div>
                                        <div class="flex justify-end gap-2">
                                            <button type="button" onclick="document.getElementById('investigationForm').classList.add('hidden')" class="px-3 py-1 text-xs text-gray-500 hover:text-gray-700">Batal</button>
                                            <button type="submit" class="px-3 py-1 bg-indigo-600 text-white text-xs rounded hover:bg-indigo-700">Kirim Laporan</button>
                                        </div>
                                    </form>
                                </div>

                                <!-- 3. Resolution Form -->
                                <div id="resolveForm" class="hidden mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <h5 class="font-bold text-gray-700 text-sm mb-3">Penyelesaian Laporan</h5>
                                    <form action="{{ route('admin.reports.update', $report) }}" method="POST" class="space-y-3">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="report_status" value="resolved">
                                        
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Catatan Penyelesaian</label>
                                            <textarea name="resolution_notes" rows="4" class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:border-red-500 focus:ring-red-500" placeholder="Tindakan akhir yang diambil..." required></textarea>
                                        </div>
                                        <div class="flex justify-end gap-2">
                                            <button type="button" onclick="document.getElementById('resolveForm').classList.add('hidden')" class="px-3 py-1 text-xs text-gray-500 hover:text-gray-700">Batal</button>
                                            <button type="submit" class="px-3 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700">Selesaikan</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Reporter Info -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-bold mb-4 border-b pb-2">Informasi Pelapor</h3>
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                                    <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $report->reporter_name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">WhatsApp</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $report->whatsapp) }}" target="_blank" class="text-green-600 hover:underline flex items-center gap-1">
                                            {{ $report->whatsapp }}
                                        </a>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $report->address }}
                                        @if($report->province_id)
                                            <div class="mt-1 text-xs text-gray-500">
                                                @if($report->rt || $report->rw)
                                                    RT {{ $report->rt ?? '-' }} / RW {{ $report->rw ?? '-' }}<br>
                                                @endif
                                                {{ $report->village->name ?? '-' }}, 
                                                {{ $report->district->name ?? '-' }}<br>
                                                {{ $report->city->name ?? '-' }}, 
                                                {{ $report->province->name ?? '-' }}
                                            </div>
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

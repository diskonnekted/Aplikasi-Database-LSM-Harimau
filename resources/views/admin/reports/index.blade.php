<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Manajemen Laporan</h1>
                    <p class="text-sm text-gray-500 mt-1 font-medium">Kelola dan tindak lanjuti laporan dari masyarakat.</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold bg-white border border-gray-100 shadow-sm text-gray-600">
                        Total: {{ $reports->total() }} Laporan
                    </span>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-600 rounded-2xl flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-bold text-sm">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Tanggal</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Pelapor</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Judul Laporan</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Status Pelapor</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Status Laporan</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($reports as $report)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $report->created_at->format('d M Y') }}</div>
                                        <div class="text-[10px] text-gray-400 font-medium mt-1">{{ $report->created_at->format('H:i') }} WIB</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-xl bg-red-50 flex items-center justify-center text-red-600 font-bold border border-red-100">
                                                {{ strtoupper(substr($report->reporter_name, 0, 1)) }}
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-bold text-gray-900 leading-none">{{ $report->reporter_name }}</p>
                                                <p class="text-[10px] text-gray-500 font-medium mt-1">{{ $report->whatsapp }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-700 max-w-xs truncate">{{ $report->title }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-3 py-1 text-[10px] font-bold uppercase tracking-widest rounded-full {{ $report->status === 'anggota' ? 'bg-red-100 text-red-700 border border-red-200' : 'bg-gray-100 text-gray-600' }}">
                                            {{ $report->status }}
                                            @if($report->status === 'anggota')
                                                <span class="ml-1 text-[8px]">★</span>
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $statusClasses = [
                                                'pending' => 'bg-yellow-50 text-yellow-600 border-yellow-100',
                                                'investigating' => 'bg-blue-50 text-blue-600 border-blue-100',
                                                'resolved' => 'bg-green-50 text-green-600 border-green-100',
                                                'rejected' => 'bg-red-50 text-red-600 border-red-100',
                                            ];
                                            $statusLabels = [
                                                'pending' => 'Pending',
                                                'investigating' => 'Investigasi',
                                                'resolved' => 'Selesai',
                                                'rejected' => 'Ditolak',
                                            ];
                                        @endphp
                                        <span class="inline-flex px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full border {{ $statusClasses[$report->report_status] ?? 'bg-gray-50 text-gray-600 border-gray-100' }}">
                                            {{ $statusLabels[$report->report_status] ?? $report->report_status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end items-center space-x-2">
                                            <a href="{{ route('admin.reports.show', $report) }}" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.reports.destroy', $report) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="p-4 bg-gray-50 rounded-full mb-4">
                                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                            <p class="text-gray-500 font-bold">Belum ada laporan masuk.</p>
                                            <p class="text-gray-400 text-sm mt-1">Laporan dari masyarakat akan muncul di sini.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($reports->hasPages())
                    <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-50">
                        {{ $reports->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
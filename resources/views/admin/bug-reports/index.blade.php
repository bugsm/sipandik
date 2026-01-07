<x-admin-layout>
    <x-slot name="title">Laporan Bug</x-slot>
    
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Kelola Laporan Bug
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Daftar semua laporan bug dari pengguna</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.bug-reports.export', ['format' => 'xlsx']) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Excel
                </a>
                <a href="{{ route('admin.bug-reports.export', ['format' => 'pdf']) }}" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    PDF
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow">
            <p class="text-sm text-gray-500">Total</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ \App\Models\BugReport::count() }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow">
            <p class="text-sm text-gray-500">Diajukan</p>
            <p class="text-2xl font-bold text-yellow-500">{{ \App\Models\BugReport::where('status', 'diajukan')->count() }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow">
            <p class="text-sm text-gray-500">Diverifikasi</p>
            <p class="text-2xl font-bold text-blue-500">{{ \App\Models\BugReport::where('status', 'diverifikasi')->count() }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow">
            <p class="text-sm text-gray-500">Diproses</p>
            <p class="text-2xl font-bold text-purple-500">{{ \App\Models\BugReport::where('status', 'diproses')->count() }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow">
            <p class="text-sm text-gray-500">Selesai</p>
            <p class="text-2xl font-bold text-green-500">{{ \App\Models\BugReport::where('status', 'selesai')->count() }}</p>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Nama Pelapor</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Aplikasi</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">PD Pengelola</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Kerentanan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Apresiasi</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Folder</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($bugReports as $report)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-white whitespace-nowrap">{{ $report->created_at->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $report->user->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">{{ $report->user->email ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $report->application->nama ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">{{ $report->application->opd->singkatan ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($report->vulnerabilityType->nama ?? '-', 20) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $report->getStatusColorAttribute() }}">
                                    {{ $report->getStatusLabelAttribute() }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $report->getApresiasiColorAttribute() }}">
                                    {{ $report->getApresiasiLabelAttribute() }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($report->folder_checked)
                                    <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <a href="{{ route('admin.bug-reports.show', $report) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-4 py-8 text-center text-gray-500">Belum ada laporan bug</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
            {{ $bugReports->links() }}
        </div>
    </div>
</x-admin-layout>

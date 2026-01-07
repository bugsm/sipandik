<x-user-layout>
    <x-slot name="title">Dashboard</x-slot>
    
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Dashboard
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Selamat datang kembali, {{ auth()->user()->name }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Report Bug Card -->
                <a href="{{ route('user.bug-reports.create') }}" class="block bg-gradient-to-br from-red-500 to-red-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-all hover:scale-[1.02]">
                    <div class="flex items-center">
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold">Laporkan Bug</h3>
                            <p class="text-red-100 text-sm">Laporkan kerentanan atau bug sistem</p>
                        </div>
                        <svg class="w-6 h-6 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </a>

                <!-- Request Data Card -->
                <a href="{{ route('user.data-requests.create') }}" class="block bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-all hover:scale-[1.02]">
                    <div class="flex items-center">
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold">Ajukan Permintaan Data</h3>
                            <p class="text-green-100 text-sm">Minta data statistik (Open Data)</p>
                        </div>
                        <svg class="w-6 h-6 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Laporan Bug</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $bugReportStats['total'] }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Permintaan Data</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $dataRequestStats['total'] }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Dalam Proses</p>
                    <p class="text-2xl font-bold text-yellow-500">{{ $bugReportStats['diproses'] + $dataRequestStats['diproses'] }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Selesai</p>
                    <p class="text-2xl font-bold text-green-500">{{ $bugReportStats['selesai'] + $dataRequestStats['tersedia'] }}</p>
                </div>
            </div>

            <!-- Recent Reports -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Bug Reports -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Laporan Bug Terbaru</h3>
                        <a href="{{ route('user.bug-reports.index') }}" class="text-sm text-blue-600 hover:text-blue-800">Lihat Semua</a>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($recentBugReports as $report)
                            <a href="{{ route('user.bug-reports.show', $report) }}" class="block p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $report->judul }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ $report->ticket_number }} • {{ $report->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <span class="ml-2 px-2 py-1 text-xs rounded-full {{ $report->getStatusColorAttribute() }}">
                                        {{ $report->getStatusLabelAttribute() }}
                                    </span>
                                </div>
                            </a>
                        @empty
                            <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p>Belum ada laporan bug</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Data Requests -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Permintaan Data Terbaru</h3>
                        <a href="{{ route('user.data-requests.index') }}" class="text-sm text-blue-600 hover:text-blue-800">Lihat Semua</a>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($recentDataRequests as $request)
                            <a href="{{ route('user.data-requests.show', $request) }}" class="block p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $request->nama_data }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ $request->ticket_number }} • {{ $request->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <span class="ml-2 px-2 py-1 text-xs rounded-full {{ $request->getStatusColorAttribute() }}">
                                        {{ $request->getStatusLabelAttribute() }}
                                    </span>
                                </div>
                            </a>
                        @empty
                            <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p>Belum ada permintaan data</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-user-layout>

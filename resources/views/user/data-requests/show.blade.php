<x-user-layout>
    <x-slot name="title">Detail Permintaan #{{ $dataRequest->ticket_number }}</x-slot>
    
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('user.data-requests.index') }}" class="mr-4 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Permintaan #{{ $dataRequest->ticket_number }}
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Dibuat {{ $dataRequest->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
            <span class="px-4 py-2 text-sm font-medium rounded-full {{ $dataRequest->getStatusColorAttribute() }}">
                {{ $dataRequest->getStatusLabelAttribute() }}
            </span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Request Details -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ $dataRequest->nama_data }}</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tujuan Penggunaan</h4>
                                <p class="text-gray-600 dark:text-gray-400 whitespace-pre-wrap">{{ $dataRequest->tujuan_penggunaan }}</p>
                            </div>

                            @if($dataRequest->deskripsi)
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deskripsi Tambahan</h4>
                                    <p class="text-gray-600 dark:text-gray-400 whitespace-pre-wrap">{{ $dataRequest->deskripsi }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Download Section (if available) -->
                    @if($dataRequest->status === 'tersedia' && $dataRequest->file_path)
                        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg mr-4">
                                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-green-800 dark:text-green-200">Data Tersedia!</h4>
                                        <p class="text-sm text-green-700 dark:text-green-300">{{ $dataRequest->file_name }}</p>
                                        @if($dataRequest->expired_at)
                                            <p class="text-xs text-green-600 dark:text-green-400 mt-1">
                                                Berlaku sampai: {{ $dataRequest->expired_at->format('d M Y') }}
                                                @if($dataRequest->isExpired())
                                                    <span class="text-red-500">(Kadaluarsa)</span>
                                                @endif
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                @if(!$dataRequest->isExpired())
                                    <a href="{{ route('user.data-requests.download', $dataRequest) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        Download
                                    </a>
                                @endif
                            </div>
                            @if($dataRequest->download_count > 0)
                                <p class="text-xs text-green-600 dark:text-green-400 mt-3">
                                    Didownload {{ $dataRequest->download_count }}x
                                </p>
                            @endif
                        </div>
                    @endif

                    <!-- History Timeline -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Riwayat</h3>
                        
                        <div class="flow-root">
                            <ul class="-mb-8">
                                @foreach($dataRequest->histories as $history)
                                    <li>
                                        <div class="relative pb-8">
                                            @if(!$loop->last)
                                                <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700" aria-hidden="true"></span>
                                            @endif
                                            <div class="relative flex items-start space-x-3">
                                                <div class="relative">
                                                    <div class="h-10 w-10 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center">
                                                        <span class="text-sm font-medium text-green-600 dark:text-green-300">{{ substr($history->user->name ?? 'S', 0, 1) }}</span>
                                                    </div>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <div>
                                                        <p class="text-sm text-gray-900 dark:text-white">
                                                            <span class="font-medium">{{ $history->user->name ?? 'Sistem' }}</span>
                                                            <span class="text-gray-500 dark:text-gray-400 ml-2">{{ $history->keterangan }}</span>
                                                        </p>
                                                        <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                                                            {{ $history->created_at->format('d M Y, H:i') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Info Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">Informasi</h3>
                        
                        <dl class="space-y-4">
                            @if($dataRequest->opd)
                                <div>
                                    <dt class="text-xs text-gray-500 dark:text-gray-400">OPD Sumber</dt>
                                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $dataRequest->opd->nama }}</dd>
                                </div>
                            @endif
                            @if($dataRequest->sumber_data)
                                <div>
                                    <dt class="text-xs text-gray-500 dark:text-gray-400">Sumber Data</dt>
                                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $dataRequest->sumber_data }}</dd>
                                </div>
                            @endif
                            @if($dataRequest->tahun_periode)
                                <div>
                                    <dt class="text-xs text-gray-500 dark:text-gray-400">Periode</dt>
                                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $dataRequest->tahun_periode }}</dd>
                                </div>
                            @endif
                            <div>
                                <dt class="text-xs text-gray-500 dark:text-gray-400">Format Data</dt>
                                <dd class="flex flex-wrap gap-1 mt-1">
                                    @foreach($dataRequest->format_data ?? [] as $format)
                                        <span class="px-2 py-0.5 text-xs bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded">{{ strtoupper($format) }}</span>
                                    @endforeach
                                </dd>
                            </div>
                            @if($dataRequest->tanggal_dibutuhkan)
                                <div>
                                    <dt class="text-xs text-gray-500 dark:text-gray-400">Tanggal Dibutuhkan</dt>
                                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $dataRequest->tanggal_dibutuhkan->format('d M Y') }}</dd>
                                </div>
                            @endif
                            @if($dataRequest->handler)
                                <div>
                                    <dt class="text-xs text-gray-500 dark:text-gray-400">Ditangani Oleh</dt>
                                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $dataRequest->handler->name }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                    <!-- Admin Notes -->
                    @if($dataRequest->catatan_admin)
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-6">
                            <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200 mb-2">Catatan Admin</h3>
                            <p class="text-sm text-yellow-700 dark:text-yellow-300">{{ $dataRequest->catatan_admin }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-user-layout>

<x-user-layout>
    <x-slot name="title">Detail Laporan #{{ $bugReport->ticket_number }}</x-slot>
    
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('user.bug-reports.index') }}" class="mr-4 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Laporan #{{ $bugReport->ticket_number }}
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Dibuat {{ $bugReport->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
            <span class="px-4 py-2 text-sm font-medium rounded-full {{ $bugReport->getStatusColorAttribute() }}">
                {{ $bugReport->getStatusLabelAttribute() }}
            </span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Report Details -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ $bugReport->judul }}</h3>
                        
                        <div class="prose prose-sm dark:prose-invert max-w-none">
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deskripsi Masalah</h4>
                            <p class="text-gray-600 dark:text-gray-400 whitespace-pre-wrap">{{ $bugReport->deskripsi }}</p>
                        </div>

                        @if($bugReport->langkah_reproduksi)
                            <div class="mt-6">
                                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Langkah Reproduksi</h4>
                                <p class="text-gray-600 dark:text-gray-400 whitespace-pre-wrap">{{ $bugReport->langkah_reproduksi }}</p>
                            </div>
                        @endif

                        @if($bugReport->dampak)
                            <div class="mt-6">
                                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Dampak</h4>
                                <p class="text-gray-600 dark:text-gray-400 whitespace-pre-wrap">{{ $bugReport->dampak }}</p>
                            </div>
                        @endif

                        @if($bugReport->url_terkait)
                            <div class="mt-6">
                                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">URL Terkait</h4>
                                <a href="{{ $bugReport->url_terkait }}" target="_blank" class="text-blue-600 hover:text-blue-800 break-all">{{ $bugReport->url_terkait }}</a>
                            </div>
                        @endif
                    </div>

                    <!-- Attachments -->
                    @if($bugReport->attachments->count() > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Lampiran ({{ $bugReport->attachments->count() }})</h3>
                            
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($bugReport->attachments as $attachment)
                                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-3">
                                        @if(in_array($attachment->ekstensi, ['jpg', 'jpeg', 'png', 'gif']))
                                            <a href="{{ Storage::url($attachment->path) }}" target="_blank">
                                                <img src="{{ Storage::url($attachment->path) }}" alt="{{ $attachment->nama_asli }}" class="w-full h-24 object-cover rounded mb-2">
                                            </a>
                                        @else
                                            <div class="w-full h-24 bg-gray-100 dark:bg-gray-700 rounded mb-2 flex items-center justify-center">
                                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <p class="text-xs text-gray-600 dark:text-gray-400 truncate" title="{{ $attachment->nama_asli }}">{{ $attachment->nama_asli }}</p>
                                        <p class="text-xs text-gray-400">{{ $attachment->getFileSizeAttribute() }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- History Timeline -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Riwayat</h3>
                        
                        <div class="flow-root">
                            <ul class="-mb-8">
                                @foreach($bugReport->histories as $history)
                                    <li>
                                        <div class="relative pb-8">
                                            @if(!$loop->last)
                                                <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700" aria-hidden="true"></span>
                                            @endif
                                            <div class="relative flex items-start space-x-3">
                                                <div class="relative">
                                                    <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                                        <span class="text-sm font-medium text-blue-600 dark:text-blue-300">{{ substr($history->user->name ?? 'S', 0, 1) }}</span>
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
                            <div>
                                <dt class="text-xs text-gray-500 dark:text-gray-400">Aplikasi</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $bugReport->application->nama ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500 dark:text-gray-400">OPD Pengelola</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $bugReport->application->opd->nama ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500 dark:text-gray-400">Jenis Kerentanan</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $bugReport->vulnerabilityType->nama ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500 dark:text-gray-400">Severity</dt>
                                <dd>
                                    <span class="px-2 py-1 text-xs font-medium rounded {{ $bugReport->vulnerabilityType?->getSeverityColorAttribute() ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($bugReport->vulnerabilityType->severity ?? '-') }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500 dark:text-gray-400">Tanggal Kejadian</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $bugReport->tanggal_kejadian?->format('d M Y') ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500 dark:text-gray-400">Status Apresiasi</dt>
                                <dd>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $bugReport->getApresiasiColorAttribute() }}">
                                        {{ $bugReport->getApresiasiLabelAttribute() }}
                                    </span>
                                </dd>
                            </div>
                            @if($bugReport->handler)
                                <div>
                                    <dt class="text-xs text-gray-500 dark:text-gray-400">Ditangani Oleh</dt>
                                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $bugReport->handler->name }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                    <!-- Admin Notes -->
                    @if($bugReport->catatan_admin)
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-6">
                            <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200 mb-2">Catatan Admin</h3>
                            <p class="text-sm text-yellow-700 dark:text-yellow-300">{{ $bugReport->catatan_admin }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-user-layout>

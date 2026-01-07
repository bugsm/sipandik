<x-admin-layout>
    <x-slot name="title">Detail Laporan #{{ $bugReport->ticket_number }}</x-slot>
    
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('admin.bug-reports.index') }}" class="mr-4 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Laporan #{{ $bugReport->ticket_number }}
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">{{ $bugReport->judul }}</p>
                </div>
            </div>
            <span class="px-4 py-2 text-sm font-medium rounded-full {{ $bugReport->getStatusColorAttribute() }}">
                {{ $bugReport->getStatusLabelAttribute() }}
            </span>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Report Details -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Detail Laporan</h3>
                
                <div class="prose prose-sm dark:prose-invert max-w-none space-y-4">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Deskripsi</h4>
                        <p class="text-gray-900 dark:text-white whitespace-pre-wrap">{{ $bugReport->deskripsi }}</p>
                    </div>
                    
                    @if($bugReport->langkah_reproduksi)
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Langkah Reproduksi</h4>
                        <p class="text-gray-900 dark:text-white whitespace-pre-wrap">{{ $bugReport->langkah_reproduksi }}</p>
                    </div>
                    @endif
                    
                    @if($bugReport->dampak)
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Dampak</h4>
                        <p class="text-gray-900 dark:text-white whitespace-pre-wrap">{{ $bugReport->dampak }}</p>
                    </div>
                    @endif
                    
                    @if($bugReport->url_terkait)
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">URL Terkait</h4>
                        <a href="{{ $bugReport->url_terkait }}" target="_blank" class="text-blue-600 hover:underline">{{ $bugReport->url_terkait }}</a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Attachments -->
            @if($bugReport->attachments->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Lampiran ({{ $bugReport->attachments->count() }})</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($bugReport->attachments as $attachment)
                    <a href="{{ Storage::url($attachment->path) }}" target="_blank" class="block border rounded-lg p-2 hover:border-blue-500 transition">
                        @if(in_array($attachment->ekstensi, ['jpg', 'jpeg', 'png', 'gif']))
                            <img src="{{ Storage::url($attachment->path) }}" class="w-full h-20 object-cover rounded mb-2">
                        @else
                            <div class="w-full h-20 bg-gray-100 dark:bg-gray-700 rounded flex items-center justify-center mb-2">
                                <span class="text-xs text-gray-500 uppercase">{{ $attachment->ekstensi }}</span>
                            </div>
                        @endif
                        <p class="text-xs text-gray-600 truncate">{{ $attachment->nama_asli }}</p>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- History -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Riwayat</h3>
                <div class="space-y-4">
                    @foreach($bugReport->histories as $history)
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-sm font-medium">
                            {{ substr($history->user->name ?? 'S', 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-900 dark:text-white">{{ $history->keterangan }}</p>
                            <p class="text-xs text-gray-500">{{ $history->user->name ?? 'Sistem' }} - {{ $history->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar - Admin Actions -->
        <div class="space-y-6">
            <!-- Update Status -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">Update Status</h3>
                <form action="{{ route('admin.bug-reports.update-status', $bugReport) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm text-gray-600 dark:text-gray-400 mb-1">Status</label>
                            <select name="status" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm">
                                <option value="diajukan" {{ $bugReport->status == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                                <option value="diverifikasi" {{ $bugReport->status == 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                                <option value="diproses" {{ $bugReport->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ $bugReport->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak" {{ $bugReport->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 dark:text-gray-400 mb-1">Catatan (opsional)</label>
                            <textarea name="catatan" rows="2" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm" placeholder="Tambahkan catatan..."></textarea>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg text-sm hover:bg-blue-700 transition">
                            Update Status
                        </button>
                    </div>
                </form>
            </div>

            <!-- Update Apresiasi -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">Status Apresiasi</h3>
                <form action="{{ route('admin.bug-reports.update-apresiasi', $bugReport) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="space-y-4">
                        <select name="status_apresiasi" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm">
                            <option value="belum_dinilai" {{ $bugReport->status_apresiasi == 'belum_dinilai' ? 'selected' : '' }}>Belum Dinilai</option>
                            <option value="ditolak" {{ $bugReport->status_apresiasi == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="diapresiasi" {{ $bugReport->status_apresiasi == 'diapresiasi' ? 'selected' : '' }}>Diapresiasi</option>
                            <option value="hall_of_fame" {{ $bugReport->status_apresiasi == 'hall_of_fame' ? 'selected' : '' }}>Hall of Fame</option>
                        </select>
                        <button type="submit" class="w-full bg-yellow-500 text-white py-2 rounded-lg text-sm hover:bg-yellow-600 transition">
                            Update Apresiasi
                        </button>
                    </div>
                </form>
            </div>

            <!-- Folder Status -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">Status Folder</h3>
                <form action="{{ route('admin.bug-reports.toggle-folder', $bugReport) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="space-y-4">
                        <label class="flex items-center">
                            <input type="hidden" name="folder_checked" value="0">
                            <input type="checkbox" name="folder_checked" value="1" class="rounded border-gray-300 text-blue-600" {{ $bugReport->folder_checked ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Folder sudah dicek</span>
                        </label>
                        <div>
                            <label class="block text-sm text-gray-600 dark:text-gray-400 mb-1">Path Folder (opsional)</label>
                            <input type="text" name="folder_path" value="{{ $bugReport->folder_path }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm" placeholder="D:\Arsip\Bug\...">
                        </div>
                        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg text-sm hover:bg-green-700 transition">
                            Update Folder
                        </button>
                    </div>
                </form>
            </div>

            <!-- Info -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">Informasi</h3>
                <dl class="space-y-3 text-sm">
                    <div>
                        <dt class="text-gray-500">Pelapor</dt>
                        <dd class="text-gray-900 dark:text-white font-medium">{{ $bugReport->user->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Email</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $bugReport->user->email ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Telepon</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $bugReport->user->phone ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Aplikasi</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $bugReport->application->nama ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">OPD Pengelola</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $bugReport->application->opd->nama ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Jenis Kerentanan</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $bugReport->vulnerabilityType->nama ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Severity</dt>
                        <dd><span class="px-2 py-1 rounded text-xs {{ $bugReport->vulnerabilityType?->getSeverityColorAttribute() ?? 'bg-gray-100 text-gray-800' }}">{{ ucfirst($bugReport->vulnerabilityType->severity ?? '-') }}</span></dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Tanggal Kejadian</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $bugReport->tanggal_kejadian?->format('d M Y') ?? '-' }}</dd>
                    </div>
                    @if($bugReport->handler)
                    <div>
                        <dt class="text-gray-500">Ditangani Oleh</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $bugReport->handler->name }}</dd>
                    </div>
                    @endif
                </dl>
            </div>

            <!-- Admin Note -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">Catatan Admin</h3>
                <form action="{{ route('admin.bug-reports.add-note', $bugReport) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <textarea name="catatan_admin" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm mb-3" placeholder="Tambahkan catatan internal...">{{ $bugReport->catatan_admin }}</textarea>
                    <button type="submit" class="w-full bg-gray-600 text-white py-2 rounded-lg text-sm hover:bg-gray-700 transition">
                        Simpan Catatan
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>

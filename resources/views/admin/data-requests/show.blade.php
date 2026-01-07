<x-admin-layout>
    <x-slot name="title">Detail Permintaan #{{ $dataRequest->ticket_number }}</x-slot>
    
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('admin.data-requests.index') }}" class="mr-4 p-2 rounded-lg hover:bg-gray-100 transition">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Permintaan #{{ $dataRequest->ticket_number }}</h2>
                    <p class="text-sm text-gray-500 mt-1">{{ $dataRequest->nama_data }}</p>
                </div>
            </div>
            <span class="px-4 py-2 text-sm font-medium rounded-full {{ $dataRequest->getStatusColorAttribute() }}">
                {{ $dataRequest->getStatusLabelAttribute() }}
            </span>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Detail Permintaan</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm text-gray-500">Nama Data</dt>
                        <dd class="text-gray-900 font-medium">{{ $dataRequest->nama_data }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Tujuan Penggunaan</dt>
                        <dd class="text-gray-900 whitespace-pre-wrap">{{ $dataRequest->tujuan_penggunaan }}</dd>
                    </div>
                    @if($dataRequest->deskripsi)
                    <div>
                        <dt class="text-sm text-gray-500">Deskripsi</dt>
                        <dd class="text-gray-900 whitespace-pre-wrap">{{ $dataRequest->deskripsi }}</dd>
                    </div>
                    @endif
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm text-gray-500">OPD Sumber</dt>
                            <dd class="text-gray-900">{{ $dataRequest->opd->nama ?? $dataRequest->sumber_data ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Periode</dt>
                            <dd class="text-gray-900">{{ $dataRequest->tahun_periode ?? '-' }}</dd>
                        </div>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Format Data</dt>
                        <dd class="flex gap-1 mt-1">
                            @foreach($dataRequest->format_data ?? [] as $format)
                            <span class="px-2 py-0.5 text-xs bg-blue-100 text-blue-800 rounded">{{ strtoupper($format) }}</span>
                            @endforeach
                        </dd>
                    </div>
                    @if($dataRequest->tanggal_dibutuhkan)
                    <div>
                        <dt class="text-sm text-gray-500">Tanggal Dibutuhkan</dt>
                        <dd class="text-gray-900">{{ $dataRequest->tanggal_dibutuhkan->format('d M Y') }}</dd>
                    </div>
                    @endif
                </dl>
            </div>

            <!-- Current File (if available) -->
            @if($dataRequest->file_path)
            <div class="bg-green-50 border border-green-200 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-green-800 mb-3">Data Sudah Diupload</h3>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-700 font-medium">{{ $dataRequest->file_name }}</p>
                        <p class="text-sm text-green-600">{{ $dataRequest->getFileSizeFormatted() }} • Berlaku sampai {{ $dataRequest->expired_at?->format('d M Y') }}</p>
                    </div>
                    <a href="{{ Storage::url($dataRequest->file_path) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700">Download</a>
                </div>
            </div>
            @endif

            <!-- History -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Riwayat</h3>
                <div class="space-y-4">
                    @foreach($dataRequest->histories as $history)
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 text-sm font-medium">
                            {{ substr($history->user->name ?? 'S', 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm text-gray-900">{{ $history->keterangan }}</p>
                            <p class="text-xs text-gray-500">{{ $history->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Update Status -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-sm font-medium text-gray-700 mb-4">Update Status</h3>
                <form action="{{ route('admin.data-requests.update-status', $dataRequest) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="space-y-4">
                        <select name="status" class="w-full rounded-lg border-gray-300 text-sm">
                            <option value="diajukan" {{ $dataRequest->status == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                            <option value="diproses" {{ $dataRequest->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="tersedia" {{ $dataRequest->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="ditolak" {{ $dataRequest->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        <textarea name="catatan" rows="2" class="w-full rounded-lg border-gray-300 text-sm" placeholder="Catatan..."></textarea>
                        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg text-sm hover:bg-blue-700">Update Status</button>
                    </div>
                </form>
            </div>

            <!-- Upload Data -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-sm font-medium text-gray-700 mb-4">Upload Data</h3>
                <form action="{{ route('admin.data-requests.upload', $dataRequest) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4">
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                            <input type="file" name="data_file" id="data_file" class="hidden" accept=".xlsx,.xls,.csv,.pdf,.json,.zip">
                            <label for="data_file" class="cursor-pointer">
                                <svg class="w-8 h-8 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="text-sm text-gray-500">Klik untuk upload file</p>
                                <p class="text-xs text-gray-400">Excel, CSV, PDF, JSON, ZIP (Max 50MB)</p>
                            </label>
                        </div>
                        <div id="selected-file" class="text-sm text-gray-600 hidden"></div>
                        <textarea name="catatan" rows="2" class="w-full rounded-lg border-gray-300 text-sm" placeholder="Catatan untuk pemohon..."></textarea>
                        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg text-sm hover:bg-green-700">Upload & Selesaikan</button>
                    </div>
                </form>
            </div>

            <!-- Pemohon Info -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-sm font-medium text-gray-700 mb-4">Informasi Pemohon</h3>
                <dl class="space-y-3 text-sm">
                    <div>
                        <dt class="text-gray-500">Nama</dt>
                        <dd class="text-gray-900 font-medium">{{ $dataRequest->user->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Email</dt>
                        <dd class="text-gray-900">{{ $dataRequest->user->email ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Telepon</dt>
                        <dd class="text-gray-900">{{ $dataRequest->user->phone ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Jabatan</dt>
                        <dd class="text-gray-900">{{ $dataRequest->user->jabatan ?? '-' }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('data_file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                document.getElementById('selected-file').classList.remove('hidden');
                document.getElementById('selected-file').textContent = 'File: ' + file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
            }
        });
    </script>
</x-admin-layout>

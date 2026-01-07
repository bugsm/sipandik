<x-user-layout>
    <x-slot name="title">Buat Laporan Bug</x-slot>
    
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('user.bug-reports.index') }}" class="mr-4 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Buat Laporan Bug Baru
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Laporkan kerentanan atau bug pada sistem/aplikasi</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('user.bug-reports.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Application & Vulnerability Info -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Aplikasi & Kerentanan</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Application -->
                        <div>
                            <label for="application_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Aplikasi yang Dilaporkan <span class="text-red-500">*</span>
                            </label>
                            <select id="application_id" name="application_id" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Aplikasi</option>
                                @foreach($applications as $app)
                                    <option value="{{ $app->id }}" {{ old('application_id') == $app->id ? 'selected' : '' }}>
                                        {{ $app->nama }} ({{ $app->opd->singkatan ?? $app->opd->nama }})
                                    </option>
                                @endforeach
                            </select>
                            @error('application_id')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Vulnerability Type -->
                        <div>
                            <label for="vulnerability_type_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Jenis Kerentanan <span class="text-red-500">*</span>
                            </label>
                            <select id="vulnerability_type_id" name="vulnerability_type_id" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Jenis Kerentanan</option>
                                @foreach($vulnerabilityTypes as $type)
                                    <option value="{{ $type->id }}" {{ old('vulnerability_type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->nama }} ({{ ucfirst($type->severity) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('vulnerability_type_id')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Report Details -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Detail Laporan</h3>
                    
                    <div class="space-y-6">
                        <!-- Title -->
                        <div>
                            <label for="judul" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Judul Laporan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required maxlength="255" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: SQL Injection pada halaman login">
                            @error('judul')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Deskripsi Masalah <span class="text-red-500">*</span>
                            </label>
                            <textarea id="deskripsi" name="deskripsi" rows="4" required minlength="20" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-blue-500 focus:border-blue-500" placeholder="Jelaskan secara detail tentang masalah yang ditemukan...">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Steps to Reproduce -->
                        <div>
                            <label for="langkah_reproduksi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Langkah Reproduksi
                            </label>
                            <textarea id="langkah_reproduksi" name="langkah_reproduksi" rows="4" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-blue-500 focus:border-blue-500" placeholder="1. Buka halaman...&#10;2. Masukkan input...&#10;3. Klik tombol...">{{ old('langkah_reproduksi') }}</textarea>
                        </div>

                        <!-- Impact -->
                        <div>
                            <label for="dampak" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Dampak/Impact
                            </label>
                            <textarea id="dampak" name="dampak" rows="2" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-blue-500 focus:border-blue-500" placeholder="Jelaskan dampak dari kerentanan ini...">{{ old('dampak') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- URL -->
                            <div>
                                <label for="url_terkait" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    URL Terkait
                                </label>
                                <input type="url" id="url_terkait" name="url_terkait" value="{{ old('url_terkait') }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-blue-500 focus:border-blue-500" placeholder="https://...">
                                @error('url_terkait')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date -->
                            <div>
                                <label for="tanggal_kejadian" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tanggal Kejadian <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="tanggal_kejadian" name="tanggal_kejadian" value="{{ old('tanggal_kejadian', date('Y-m-d')) }}" required max="{{ date('Y-m-d') }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-blue-500 focus:border-blue-500">
                                @error('tanggal_kejadian')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attachments -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Lampiran</h3>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Upload Bukti (Screenshot, Log, dll)
                        </label>
                        <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center">
                            <input type="file" id="attachments" name="attachments[]" multiple accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.txt,.log,.zip" class="hidden">
                            <label for="attachments" class="cursor-pointer">
                                <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    <span class="text-blue-600 hover:text-blue-800 font-medium">Klik untuk upload</span> atau drag & drop
                                </p>
                                <p class="text-xs text-gray-400 mt-1">JPG, PNG, PDF, DOC, TXT, LOG, ZIP (Max 10MB per file, Max 5 files)</p>
                            </label>
                        </div>
                        <div id="file-list" class="mt-3 space-y-2"></div>
                        @error('attachments')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        @error('attachments.*')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('user.bug-reports.index') }}" class="px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Kirim Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // File upload preview
        document.getElementById('attachments').addEventListener('change', function(e) {
            const fileList = document.getElementById('file-list');
            fileList.innerHTML = '';
            
            Array.from(e.target.files).forEach((file, index) => {
                const div = document.createElement('div');
                div.className = 'flex items-center justify-between bg-gray-50 dark:bg-gray-700 rounded-lg p-3';
                div.innerHTML = `
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">${file.name}</span>
                        <span class="text-xs text-gray-400 ml-2">(${(file.size / 1024 / 1024).toFixed(2)} MB)</span>
                    </div>
                `;
                fileList.appendChild(div);
            });
        });
    </script>
</x-user-layout>

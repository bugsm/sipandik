<x-user-layout>
    <x-slot name="title">Ajukan Permintaan Data</x-slot>
    
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('user.data-requests.index') }}" class="mr-4 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Ajukan Permintaan Data Baru
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Minta data statistik dari OPD Provinsi Lampung</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('user.data-requests.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Data Information -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Data yang Diminta</h3>
                    
                    <div class="space-y-6">
                        <!-- Data Name -->
                        <div>
                            <label for="nama_data" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nama Data yang Diminta <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="nama_data" name="nama_data" value="{{ old('nama_data') }}" required maxlength="255" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: Data Statistik Penduduk Provinsi Lampung">
                            @error('nama_data')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- OPD Source -->
                            <div>
                                <label for="opd_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    OPD Sumber Data
                                </label>
                                <select id="opd_id" name="opd_id" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih OPD (Opsional)</option>
                                    @foreach($opdList as $opd)
                                        <option value="{{ $opd->id }}" {{ old('opd_id') == $opd->id ? 'selected' : '' }}>
                                            {{ $opd->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('opd_id')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Alternative Source -->
                            <div>
                                <label for="sumber_data" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Sumber Data Lainnya
                                </label>
                                <input type="text" id="sumber_data" name="sumber_data" value="{{ old('sumber_data') }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-blue-500 focus:border-blue-500" placeholder="Jika sumber bukan dari OPD">
                            </div>
                        </div>

                        <!-- Year/Period -->
                        <div>
                            <label for="tahun_periode" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tahun/Periode Data
                            </label>
                            <input type="text" id="tahun_periode" name="tahun_periode" value="{{ old('tahun_periode') }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: 2024, 2020-2024, Semester 1 2024">
                        </div>

                        <!-- Purpose -->
                        <div>
                            <label for="tujuan_penggunaan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tujuan Penggunaan Data <span class="text-red-500">*</span>
                            </label>
                            <textarea id="tujuan_penggunaan" name="tujuan_penggunaan" rows="3" required minlength="20" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-blue-500 focus:border-blue-500" placeholder="Jelaskan untuk apa data ini akan digunakan...">{{ old('tujuan_penggunaan') }}</textarea>
                            @error('tujuan_penggunaan')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Deskripsi Tambahan
                            </label>
                            <textarea id="deskripsi" name="deskripsi" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-blue-500 focus:border-blue-500" placeholder="Detail tambahan tentang data yang diminta...">{{ old('deskripsi') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Format & Deadline -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Format & Tenggat Waktu</h3>
                    
                    <div class="space-y-6">
                        <!-- Data Format -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Format Data yang Diinginkan <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach($formatOptions as $value => $label)
                                    <label class="relative flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                        <input type="checkbox" name="format_data[]" value="{{ $value }}" class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500" {{ in_array($value, old('format_data', [])) ? 'checked' : '' }}>
                                        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-white">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('format_data')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deadline -->
                        <div>
                            <label for="tanggal_dibutuhkan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tanggal Dibutuhkan
                            </label>
                            <input type="date" id="tanggal_dibutuhkan" name="tanggal_dibutuhkan" value="{{ old('tanggal_dibutuhkan') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-blue-500 focus:border-blue-500">
                            <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ada tenggat waktu khusus</p>
                            @error('tanggal_dibutuhkan')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="text-sm text-blue-700 dark:text-blue-300">
                            <p class="font-medium mb-1">Informasi Penting:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Permintaan data akan diverifikasi oleh admin</li>
                                <li>Waktu pemrosesan sekitar 3-7 hari kerja</li>
                                <li>Data yang tersedia akan dapat diunduh melalui dashboard</li>
                                <li>Link download berlaku selama 30 hari</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('user.data-requests.index') }}" class="px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Ajukan Permintaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-user-layout>

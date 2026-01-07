<x-admin-layout>
    <x-slot name="title">Tambah Aplikasi</x-slot>
    
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('admin.applications.index') }}" class="mr-4 p-2 rounded-lg hover:bg-gray-100">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Aplikasi Baru</h2>
        </div>
    </x-slot>

    <div class="max-w-3xl">
        <form action="{{ route('admin.applications.store') }}" method="POST" class="bg-white rounded-xl shadow p-6 space-y-6">
            @csrf
            
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Aplikasi <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required class="w-full rounded-lg border-gray-300 text-sm">
                    @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">OPD Pengelola <span class="text-red-500">*</span></label>
                    <select name="opd_id" required class="w-full rounded-lg border-gray-300 text-sm">
                        <option value="">Pilih OPD</option>
                        @foreach($opdList as $opd)
                        <option value="{{ $opd->id }}" {{ old('opd_id') == $opd->id ? 'selected' : '' }}>{{ $opd->nama }}</option>
                        @endforeach
                    </select>
                    @error('opd_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Platform <span class="text-red-500">*</span></label>
                    <select name="platform" required class="w-full rounded-lg border-gray-300 text-sm">
                        <option value="web" {{ old('platform') == 'web' ? 'selected' : '' }}>Web</option>
                        <option value="mobile" {{ old('platform') == 'mobile' ? 'selected' : '' }}>Mobile</option>
                        <option value="desktop" {{ old('platform') == 'desktop' ? 'selected' : '' }}>Desktop</option>
                        <option value="api" {{ old('platform') == 'api' ? 'selected' : '' }}>API</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Versi</label>
                    <input type="text" name="versi" value="{{ old('versi') }}" maxlength="20" class="w-full rounded-lg border-gray-300 text-sm" placeholder="1.0.0">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">URL</label>
                <input type="url" name="url" value="{{ old('url') }}" class="w-full rounded-lg border-gray-300 text-sm" placeholder="https://...">
                @error('url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="w-full rounded-lg border-gray-300 text-sm">{{ old('deskripsi') }}</textarea>
            </div>
            
            <div class="border-t pt-6">
                <h4 class="text-sm font-medium text-gray-700 mb-4">Contact Person</h4>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Nama PIC</label>
                        <input type="text" name="pic_nama" value="{{ old('pic_nama') }}" class="w-full rounded-lg border-gray-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Telepon PIC</label>
                        <input type="text" name="pic_telepon" value="{{ old('pic_telepon') }}" class="w-full rounded-lg border-gray-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Email PIC</label>
                        <input type="email" name="pic_email" value="{{ old('pic_email') }}" class="w-full rounded-lg border-gray-300 text-sm">
                    </div>
                </div>
            </div>
            
            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-blue-600" {{ old('is_active', true) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700">Aktif</span>
                </label>
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.applications.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</x-admin-layout>

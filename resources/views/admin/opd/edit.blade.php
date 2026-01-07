<x-admin-layout>
    <x-slot name="title">Edit OPD</x-slot>
    
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('admin.opd.index') }}" class="mr-4 p-2 rounded-lg hover:bg-gray-100">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit OPD: {{ $opd->nama }}</h2>
        </div>
    </x-slot>

    <div class="max-w-3xl">
        <form action="{{ route('admin.opd.update', $opd) }}" method="POST" class="bg-white rounded-xl shadow p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode OPD <span class="text-red-500">*</span></label>
                    <input type="text" name="kode" value="{{ old('kode', $opd->kode) }}" required maxlength="10" class="w-full rounded-lg border-gray-300 text-sm">
                    @error('kode') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Singkatan</label>
                    <input type="text" name="singkatan" value="{{ old('singkatan', $opd->singkatan) }}" maxlength="50" class="w-full rounded-lg border-gray-300 text-sm">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama OPD <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $opd->nama) }}" required maxlength="255" class="w-full rounded-lg border-gray-300 text-sm">
                @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <input type="text" name="alamat" value="{{ old('alamat', $opd->alamat) }}" class="w-full rounded-lg border-gray-300 text-sm">
            </div>
            
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                    <input type="text" name="telepon" value="{{ old('telepon', $opd->telepon) }}" class="w-full rounded-lg border-gray-300 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $opd->email) }}" class="w-full rounded-lg border-gray-300 text-sm">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                <input type="url" name="website" value="{{ old('website', $opd->website) }}" class="w-full rounded-lg border-gray-300 text-sm">
                @error('website') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="w-full rounded-lg border-gray-300 text-sm">{{ old('deskripsi', $opd->deskripsi) }}</textarea>
            </div>
            
            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-blue-600" {{ old('is_active', $opd->is_active) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700">Aktif</span>
                </label>
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.opd.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">Update</button>
            </div>
        </form>
    </div>
</x-admin-layout>

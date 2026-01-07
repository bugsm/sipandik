<x-admin-layout>
    <x-slot name="title">Kelola Aplikasi</x-slot>
    
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Aplikasi</h2>
                <p class="text-sm text-gray-500 mt-1">Daftar aplikasi yang dapat dilaporkan</p>
            </div>
            <a href="{{ route('admin.applications.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Aplikasi
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow mb-6 p-4">
        <form method="GET" class="flex gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari aplikasi..." class="flex-1 rounded-lg border-gray-300 text-sm">
            <select name="platform" class="rounded-lg border-gray-300 text-sm" onchange="this.form.submit()">
                <option value="">Semua Platform</option>
                <option value="web" {{ request('platform') == 'web' ? 'selected' : '' }}>Web</option>
                <option value="mobile" {{ request('platform') == 'mobile' ? 'selected' : '' }}>Mobile</option>
                <option value="desktop" {{ request('platform') == 'desktop' ? 'selected' : '' }}>Desktop</option>
                <option value="api" {{ request('platform') == 'api' ? 'selected' : '' }}>API</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-100 rounded-lg text-sm hover:bg-gray-200">Cari</button>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">OPD</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Platform</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">URL</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($applications as $app)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm text-gray-900">{{ $app->nama }}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">{{ $app->opd->singkatan ?? '-' }}</td>
                    <td class="px-4 py-3"><span class="px-2 py-0.5 bg-blue-100 text-blue-800 rounded text-xs">{{ $app->getPlatformLabelAttribute() }}</span></td>
                    <td class="px-4 py-3 text-sm text-blue-600 truncate max-w-xs">
                        @if($app->url)
                        <a href="{{ $app->url }}" target="_blank">{{ Str::limit($app->url, 30) }}</a>
                        @else
                        -
                        @endif
                    </td>
                    <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded-full {{ $app->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">{{ $app->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                    <td class="px-4 py-3">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.applications.edit', $app) }}" class="text-blue-600 hover:text-blue-800 text-sm">Edit</a>
                            <form action="{{ route('admin.applications.destroy', $app) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus aplikasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">Belum ada aplikasi</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t">{{ $applications->links() }}</div>
    </div>
</x-admin-layout>

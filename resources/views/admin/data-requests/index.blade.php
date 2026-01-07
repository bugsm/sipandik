<x-admin-layout>
    <x-slot name="title">Permintaan Data</x-slot>
    
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Kelola Permintaan Data
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Daftar semua permintaan data dari pengguna</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.data-requests.export', ['format' => 'xlsx']) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Excel
                </a>
                <a href="{{ route('admin.data-requests.export', ['format' => 'pdf']) }}" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    PDF
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow">
            <p class="text-sm text-gray-500">Total</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ \App\Models\DataRequest::count() }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow">
            <p class="text-sm text-gray-500">Diajukan</p>
            <p class="text-2xl font-bold text-yellow-500">{{ \App\Models\DataRequest::where('status', 'diajukan')->count() }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow">
            <p class="text-sm text-gray-500">Diproses</p>
            <p class="text-2xl font-bold text-blue-500">{{ \App\Models\DataRequest::where('status', 'diproses')->count() }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow">
            <p class="text-sm text-gray-500">Tersedia</p>
            <p class="text-2xl font-bold text-green-500">{{ \App\Models\DataRequest::where('status', 'tersedia')->count() }}</p>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Pemohon</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Data</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">OPD/Sumber</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Format</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($dataRequests as $request)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $request->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $request->user->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ Str::limit($request->nama_data, 30) }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $request->opd->singkatan ?? $request->sumber_data ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-1">
                                @foreach($request->format_data ?? [] as $format)
                                <span class="px-1.5 py-0.5 text-xs bg-gray-100 dark:bg-gray-700 rounded">{{ strtoupper($format) }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $request->getStatusColorAttribute() }}">
                                {{ $request->getStatusLabelAttribute() }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.data-requests.show', $request) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">Belum ada permintaan data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
            {{ $dataRequests->links() }}
        </div>
    </div>
</x-admin-layout>

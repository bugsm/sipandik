<!-- Logo -->
<div class="flex items-center justify-between h-16 px-4 bg-gray-800">
    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
        <div class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
        </div>
        <div>
            <span class="text-lg font-bold text-white">SIPANDIK</span>
            <span class="block text-xs text-gray-400">Admin Panel</span>
        </div>
    </a>
    <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>

<!-- Navigation -->
<nav class="mt-4 px-3">
    <div class="space-y-1">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
        </a>
    </div>

    <!-- Laporan Section -->
    <div class="mt-6">
        <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Laporan</p>
        <div class="mt-2 space-y-1">
            <a href="{{ route('admin.bug-reports.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition {{ request()->routeIs('admin.bug-reports.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                Laporan Bug
                @php $pendingBugs = \App\Models\BugReport::where('status', 'diajukan')->count(); @endphp
                @if($pendingBugs > 0)
                    <span class="ml-auto bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $pendingBugs }}</span>
                @endif
            </a>

            <a href="{{ route('admin.data-requests.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition {{ request()->routeIs('admin.data-requests.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Permintaan Data
                @php $pendingData = \App\Models\DataRequest::where('status', 'diajukan')->count(); @endphp
                @if($pendingData > 0)
                    <span class="ml-auto bg-yellow-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $pendingData }}</span>
                @endif
            </a>
        </div>
    </div>

    <!-- Master Data Section -->
    <div class="mt-6">
        <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Master Data</p>
        <div class="mt-2 space-y-1">
            <a href="{{ route('admin.opd.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition {{ request()->routeIs('admin.opd.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                OPD
            </a>

            <a href="{{ route('admin.applications.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition {{ request()->routeIs('admin.applications.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Aplikasi
            </a>

            <a href="{{ route('admin.vulnerability-types.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition {{ request()->routeIs('admin.vulnerability-types.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                Jenis Kerentanan
            </a>
        </div>
    </div>

    <!-- Back to User -->
    <div class="mt-6 pt-6 border-t border-gray-700">
        <a href="{{ route('user.dashboard') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke User
        </a>
    </div>
</nav>

<!-- User Info -->
<div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-700">
    <div class="flex items-center">
        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
            <span class="text-sm font-medium text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
        </div>
        <div class="ml-3">
            <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
            <p class="text-xs text-gray-400">Administrator</p>
        </div>
    </div>
</div>

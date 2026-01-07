<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIPANDIK - Sistem Pelaporan Instansi Sandi dan Statistik</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-indigo-900">
        <!-- Navigation -->
        <nav class="fixed w-full z-50 bg-white/10 backdrop-blur-lg border-b border-white/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <span class="text-xl font-bold text-white">SIPANDIK</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-white hover:text-blue-200 font-medium transition">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-white hover:text-blue-200 font-medium transition">Masuk</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">Daftar</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative pt-32 pb-20 overflow-hidden">
            <!-- Background decoration -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-500/20 rounded-full blur-3xl"></div>
                <div class="absolute top-40 -left-40 w-80 h-80 bg-indigo-500/20 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-1/2 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl transform -translate-x-1/2"></div>
            </div>
            
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <div class="inline-flex items-center px-4 py-2 bg-blue-500/20 rounded-full text-blue-200 text-sm font-medium mb-6 backdrop-blur-sm border border-blue-400/20">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        Bidang Sandi dan Statistik
                    </div>
                    
                    <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 tracking-tight">
                        <span class="bg-gradient-to-r from-blue-400 via-cyan-400 to-indigo-400 text-transparent bg-clip-text">SIPANDIK</span>
                    </h1>
                    <p class="text-xl md:text-2xl text-blue-100 mb-4">
                        Sistem Pelaporan Instansi Sandi dan Statistik
                    </p>
                    <p class="text-lg text-blue-200/80 max-w-2xl mx-auto mb-10">
                        Platform pelaporan bug sistem dan pengambilan data statistik terpusat untuk Dinas Komunikasi dan Informatika Provinsi Lampung
                    </p>
                    
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl font-semibold text-lg hover:from-blue-600 hover:to-indigo-700 transition shadow-lg shadow-blue-500/30 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Mulai Melaporkan
                        </a>
                        <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-white/10 backdrop-blur-sm text-white rounded-xl font-semibold text-lg hover:bg-white/20 transition border border-white/20 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Masuk Akun
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-20 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Fitur Utama</h2>
                    <p class="text-blue-200/80 max-w-2xl mx-auto">Platform terintegrasi untuk pelaporan dan pengelolaan data</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-white/5 backdrop-blur-lg rounded-2xl p-8 border border-white/10 hover:bg-white/10 transition group">
                        <div class="w-14 h-14 bg-red-500/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                            <svg class="w-7 h-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-3">Pelaporan Bug</h3>
                        <p class="text-blue-200/70">Laporkan kerentanan dan bug pada sistem/aplikasi pemerintah dengan mudah dan terstruktur</p>
                    </div>
                    
                    <!-- Feature 2 -->
                    <div class="bg-white/5 backdrop-blur-lg rounded-2xl p-8 border border-white/10 hover:bg-white/10 transition group">
                        <div class="w-14 h-14 bg-green-500/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                            <svg class="w-7 h-7 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-3">Open Data</h3>
                        <p class="text-blue-200/70">Akses dan ajukan permintaan data statistik dalam berbagai format (Excel, CSV, PDF)</p>
                    </div>
                    
                    <!-- Feature 3 -->
                    <div class="bg-white/5 backdrop-blur-lg rounded-2xl p-8 border border-white/10 hover:bg-white/10 transition group">
                        <div class="w-14 h-14 bg-blue-500/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                            <svg class="w-7 h-7 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-3">Tracking Status</h3>
                        <p class="text-blue-200/70">Pantau status laporan Anda secara real-time dengan notifikasi email otomatis</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- How It Works -->
        <div class="py-20 bg-gradient-to-b from-transparent to-slate-900/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Cara Kerja</h2>
                    <p class="text-blue-200/80 max-w-2xl mx-auto">Proses pelaporan yang mudah dan transparan</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-white text-2xl font-bold shadow-lg shadow-blue-500/30">1</div>
                        <h4 class="text-lg font-semibold text-white mb-2">Daftar Akun</h4>
                        <p class="text-blue-200/70 text-sm">Buat akun dengan data diri Anda</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-white text-2xl font-bold shadow-lg shadow-blue-500/30">2</div>
                        <h4 class="text-lg font-semibold text-white mb-2">Buat Laporan</h4>
                        <p class="text-blue-200/70 text-sm">Isi form pelaporan dengan lengkap</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-white text-2xl font-bold shadow-lg shadow-blue-500/30">3</div>
                        <h4 class="text-lg font-semibold text-white mb-2">Verifikasi</h4>
                        <p class="text-blue-200/70 text-sm">Tim kami memverifikasi laporan</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-white text-2xl font-bold shadow-lg shadow-blue-500/30">4</div>
                        <h4 class="text-lg font-semibold text-white mb-2">Tindak Lanjut</h4>
                        <p class="text-blue-200/70 text-sm">Laporan ditindaklanjuti & diselesaikan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="py-12 border-t border-white/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex items-center space-x-3 mb-4 md:mb-0">
                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-semibold">SIPANDIK</p>
                            <p class="text-blue-200/60 text-sm">Bidang Sandi dan Statistik</p>
                        </div>
                    </div>
                    <div class="text-center md:text-right">
                        <p class="text-blue-200/60 text-sm">© {{ date('Y') }} Dinas Komunikasi dan Informatika</p>
                        <p class="text-blue-200/60 text-sm">Provinsi Lampung</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>

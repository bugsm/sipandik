<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIPANDIK') }} - Sistem Pelaporan</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800">
            <!-- Logo & Title -->
            <div class="text-center mb-6">
                <a href="/" class="inline-block">
                    <div class="flex items-center justify-center space-x-3">
                        <div class="w-14 h-14 bg-white rounded-xl shadow-lg flex items-center justify-center">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div class="text-left">
                            <h1 class="text-2xl font-bold text-white">SIPANDIK</h1>
                            <p class="text-blue-200 text-sm">Diskominfo Lampung</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Card -->
            <div class="w-full sm:max-w-md px-6 py-6 bg-white dark:bg-gray-800 shadow-2xl overflow-hidden rounded-2xl">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <div class="mt-6 text-center text-blue-200 text-sm">
                <p>&copy; {{ date('Y') }} Bidang Sandi dan Statistik</p>
                <p>Dinas Komunikasi dan Informatika Provinsi Lampung</p>
            </div>
        </div>
    </body>
</html>

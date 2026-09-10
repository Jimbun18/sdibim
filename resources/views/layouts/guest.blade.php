<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-950">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIM-SDI') }} - Masuk Portal</title>

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }
        </style>
    </head>
    <body class="h-full text-slate-100 antialiased bg-slate-950 relative selection:bg-emerald-500 selection:text-white flex flex-col justify-center py-12 sm:px-6 lg:px-8">

        <!-- Background Glow Orbs -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
            <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[600px] h-[400px] bg-gradient-to-br from-emerald-600/25 to-teal-500/10 blur-[110px] rounded-full"></div>
            <div class="absolute bottom-0 right-10 w-[400px] h-[300px] bg-emerald-700/10 blur-[90px] rounded-full"></div>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10 text-center">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="inline-flex flex-col items-center group">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-700 flex items-center justify-center text-white shadow-xl shadow-emerald-900/50 ring-2 ring-emerald-400/40 group-hover:scale-105 transition-transform mb-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h1 class="text-xl font-extrabold text-white tracking-tight">SD Islam Bina Insan Mandiri</h1>
                <p class="text-xs text-slate-400 font-medium mt-0.5">Portal SIM-SDI (Sistem Informasi Manajemen Sekolah)</p>
            </a>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md relative z-10 px-4 sm:px-0">
            <div class="bg-slate-900/90 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl backdrop-blur-xl">
                {{ $slot }}
            </div>

            <!-- Back to Landing Page Link -->
            <div class="text-center mt-6">
                <a href="{{ url('/') }}" class="inline-flex items-center text-xs font-semibold text-slate-400 hover:text-emerald-400 transition-colors">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Halaman Utama Sekolah
                </a>
            </div>
        </div>

        @stack('scripts')
    </body>
</html>

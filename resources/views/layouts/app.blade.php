<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - SIM-SDI (Sistem Informasi Manajemen SD Islam)</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="h-full antialiased text-slate-800 bg-slate-50 flex flex-col min-h-screen">
    <div class="flex h-screen overflow-hidden bg-slate-50" x-data="{ sidebarOpen: false }">

        <!-- Mobile Sidebar Backdrop -->
        <div id="sidebar-backdrop" class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-xs lg:hidden hidden" onclick="toggleSidebar()"></div>

        <!-- Sidebar -->
        <aside id="main-sidebar" class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900 text-slate-300 flex flex-col transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0 lg:static lg:inset-auto border-r border-slate-800 shadow-2xl">
            <!-- Brand Logo & Header -->
            <div class="h-20 flex items-center justify-between px-6 bg-slate-950 border-b border-slate-800/80">
                <a href="{{ url('/') }}" class="flex items-center space-x-3.5 group">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-700 flex items-center justify-center text-white shadow-lg shadow-emerald-900/40 ring-2 ring-emerald-400/30 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-base font-bold text-white tracking-wide leading-tight flex items-center gap-1.5">
                            SIM-SDI
                            <span class="text-[10px] bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 px-1.5 py-0.5 rounded font-mono font-medium">v1.0</span>
                        </h1>
                        <p class="text-xs text-slate-400">SD Islam Bina Insan Mandiri</p>
                    </div>
                </a>
                <!-- Close Mobile Sidebar Button -->
                <button type="button" class="lg:hidden text-slate-400 hover:text-white p-1" onclick="toggleSidebar()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- School Status Badge -->
            <div class="px-5 py-3.5 bg-slate-900/80 border-b border-slate-800">
                <div class="flex items-center justify-between text-xs">
                    <span class="text-slate-400">Tahun Ajaran</span>
                    <span class="font-semibold text-emerald-400 bg-emerald-950/70 border border-emerald-700/40 px-2 py-0.5 rounded-full">2026/2027 Ganjil</span>
                </div>
            </div>

            <!-- Navigation Links (8 Modul) -->
            <nav class="flex-1 px-4 py-5 space-y-1.5 overflow-y-auto custom-scrollbar">
                <div class="px-3 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">Menu Utama</div>

                <!-- 1. Modul Dashboard -->
                <a href="{{ route('dashboard') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all group {{ request()->routeIs('dashboard') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/30 font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-emerald-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>1. Dashboard</span>
                </a>

                <div class="pt-4 px-3 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">Master Data</div>

                <!-- 2. Modul Guru -->
                <a href="{{ route('guru.index') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all group {{ request()->routeIs('guru.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/30 font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('guru.*') ? 'text-white' : 'text-slate-400 group-hover:text-emerald-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span>2. Data Guru</span>
                </a>

                <!-- 3. Modul Kelas -->
                <a href="{{ route('kelas.index') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all group {{ request()->routeIs('kelas.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/30 font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('kelas.*') ? 'text-white' : 'text-slate-400 group-hover:text-emerald-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span>3. Data Kelas</span>
                </a>

                <!-- 4. Modul Siswa (Inti) -->
                <a href="{{ route('siswa.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all group {{ request()->routeIs('siswa.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/30 font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('siswa.*') ? 'text-white' : 'text-slate-400 group-hover:text-emerald-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span>4. Data Siswa</span>
                    </div>
                    <span class="text-[11px] px-2 py-0.5 rounded-full font-bold {{ request()->routeIs('siswa.*') ? 'bg-emerald-700 text-white' : 'bg-slate-800 text-slate-400' }}">Master</span>
                </a>

                <div class="pt-4 px-3 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">Operasional & Akademik</div>

                <!-- 5. Modul Keuangan SPP -->
                <a href="{{ route('keuangan.spp.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all group {{ request()->routeIs('keuangan.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/30 font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('keuangan.*') ? 'text-white' : 'text-slate-400 group-hover:text-emerald-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span>5. Keuangan SPP</span>
                    </div>
                    <span class="text-[10px] bg-amber-500/20 text-amber-300 px-1.5 py-0.5 rounded font-mono">Kasir</span>
                </a>

                <!-- 6. Modul Absensi Presensi -->
                <a href="{{ route('absensi.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all group {{ request()->routeIs('absensi.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/30 font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('absensi.*') ? 'text-white' : 'text-slate-400 group-hover:text-emerald-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        <span>6. Absensi Siswa</span>
                    </div>
                    <span class="text-[10px] bg-blue-500/20 text-blue-300 px-1.5 py-0.5 rounded font-mono">Grid</span>
                </a>

                <!-- 7. Modul Nilai Akademik -->
                <a href="{{ route('akademik.index') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all group {{ request()->routeIs('akademik.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/30 font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('akademik.*') ? 'text-white' : 'text-slate-400 group-hover:text-emerald-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>7. Nilai Akademik</span>
                </a>

                <!-- 8. Modul Mata Pelajaran -->
                <a href="{{ route('mapel.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all group {{ request()->routeIs('mapel.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/30 font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('mapel.*') ? 'text-white' : 'text-slate-400 group-hover:text-emerald-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span>8. Mata Pelajaran</span>
                    </div>
                    <span class="text-[10px] bg-purple-500/20 text-purple-300 px-1.5 py-0.5 rounded font-mono">KKM</span>
                </a>

                <div class="pt-4 px-3 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">Portal Eksternal</div>

                <!-- Tautan Portal Publik Sekolah -->
                <a href="{{ url('/') }}" target="_blank" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white transition-all group">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        <span>Lihat Website Sekolah</span>
                    </div>
                    <span class="text-[10px] bg-slate-800 text-slate-400 px-1.5 py-0.5 rounded">Publik</span>
                </a>
            </nav>

            <!-- User Footer Profile & Logout -->
            <div class="p-4 bg-slate-950 border-t border-slate-800/80">
                @auth
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3 min-w-0">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-teal-700 border border-emerald-400/40 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-xs">
                                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                                <p class="text-[11px] text-slate-400 truncate">{{ Auth::user()->email }}</p>
                                <span class="inline-flex items-center mt-0.5 px-1.5 py-0.2 rounded text-[9px] font-bold uppercase tracking-wider {{ Auth::user()->role === 'admin' ? 'bg-purple-500/20 text-purple-300 border border-purple-500/30' : (Auth::user()->role === 'guru' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-blue-500/20 text-blue-300 border border-blue-500/30') }}">
                                    {{ Auth::user()->role ?? 'User' }}
                                </span>
                            </div>
                        </div>

                        <!-- Tombol Logout -->
                        <form method="POST" action="{{ route('logout') }}" class="shrink-0 ml-2">
                            @csrf
                            <button type="submit" class="p-2 rounded-xl text-slate-400 hover:text-rose-400 hover:bg-rose-500/10 transition-colors" title="Keluar dari Sistem">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="w-2.5 h-2.5 rounded-full bg-slate-500"></div>
                            <span class="text-xs text-slate-400">Mode Tamu</span>
                        </div>
                        <a href="{{ route('login') }}" class="px-3 py-1.5 text-xs font-semibold bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors">
                            Masuk
                        </a>
                    </div>
                @endauth
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Topbar Header -->
            <header class="h-18 bg-white border-b border-slate-200/80 shadow-xs flex items-center justify-between px-4 sm:px-6 lg:px-8 z-20">
                <div class="flex items-center space-x-4">
                    <button type="button" class="lg:hidden p-2 rounded-lg text-slate-500 hover:text-slate-700 hover:bg-slate-100 focus:outline-hidden" onclick="toggleSidebar()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div>
                        <div class="flex items-center gap-2 text-xs font-medium text-slate-400">
                            <span>Sistem Informasi Manajemen Sekolah</span>
                            <span>&bull;</span>
                            <span class="text-emerald-700 font-semibold">SD Islam Bina Insan Mandiri</span>
                        </div>
                        <h2 class="text-lg font-extrabold text-slate-900 tracking-tight">@yield('page_title', 'Sistem Akademik & Keuangan')</h2>
                    </div>
                </div>

                <!-- Topbar Right Badges & Action -->
                <div class="flex items-center space-x-3">
                    <span class="hidden sm:inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span>
                        Sistem Aktif
                    </span>

                    @auth
                        <div class="hidden md:flex items-center space-x-2 text-xs text-slate-600 pl-3 border-l border-slate-200">
                            <span>Login sebagai: <strong>{{ Auth::user()->name }}</strong> ({{ strtoupper(Auth::user()->role) }})</span>
                        </div>
                    @endauth
                </div>
            </header>

            <!-- Main Body Scrollable Area -->
            <main class="flex-1 overflow-y-auto bg-slate-50/70 p-4 sm:p-6 lg:p-8">
                <div class="max-w-7xl mx-auto space-y-6">

                    <!-- Flash Message Notification -->
                    @if (session('success'))
                        <div class="rounded-xl bg-emerald-50 border border-emerald-200/90 p-4 shadow-xs flex items-start justify-between text-emerald-800 transition-all duration-300" id="alert-success">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0 text-emerald-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-emerald-900">Operasi Berhasil</p>
                                    <p class="text-sm text-emerald-700">{{ session('success') }}</p>
                                </div>
                            </div>
                            <button onclick="document.getElementById('alert-success').remove()" class="text-emerald-500 hover:text-emerald-700 p-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="rounded-xl bg-rose-50 border border-rose-200/90 p-4 shadow-xs flex items-start justify-between text-rose-800" id="alert-error">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-lg bg-rose-100 flex items-center justify-center shrink-0 text-rose-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-rose-900">Perhatian</p>
                                    <p class="text-sm text-rose-700">{{ session('error') }}</p>
                                </div>
                            </div>
                            <button onclick="document.getElementById('alert-error').remove()" class="text-rose-500 hover:text-rose-700 p-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    @endif

                    <!-- Content Injected from Child Views -->
                    @yield('content')

                    @if (isset($slot))
                        {{ $slot }}
                    @endif

                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-slate-200/80 px-6 py-3 text-center text-xs text-slate-500">
                &copy; {{ date('Y') }} SIM-SDI &bull; Sistem Informasi Manajemen Sekolah Terintegrasi SD Islam Bina Insan Mandiri
            </footer>
        </div>
    </div>

    <!-- Interactive Sidebar Toggle Script -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('main-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }
    </script>
    @stack('scripts')
</body>
</html>

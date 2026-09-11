@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Utama SIM-SDI')

@section('content')
<div class="space-y-6">

    <!-- Welcome Hero Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-950 p-6 sm:p-8 text-white border border-slate-700/60 shadow-xl">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Tahun Ajaran 2026/2027 &bull; Semester Ganjil
                </div>
                <h3 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                    Assalamu'alaikum, {{ Auth::user()->name ?? 'Administrator' }}! 👋
                </h3>
                <p class="text-sm text-slate-300 leading-relaxed">
                    Selamat datang di Sistem Informasi Manajemen SD Islam Bina Insan Mandiri. Pantau data kesiswaan, kepegawaian guru, kasir SPP, dan pencatatan akademik dalam satu kendali terpusat.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <a href="{{ route('keuangan.spp.index') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-500 shadow-lg shadow-emerald-900/40 transition-all transform active:scale-95">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Buka Kasir SPP
                </a>
                <a href="{{ route('siswa.create') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-200 bg-slate-800/80 hover:bg-slate-700 hover:text-white border border-slate-700 transition-all transform active:scale-95">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Siswa Baru
                </a>
            </div>
        </div>

        <!-- Decorative background glow -->
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- 4 Primary KPI Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- 1. Total Siswa -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Siswa</p>
                    <h4 class="text-3xl font-extrabold text-slate-900 mt-1">{{ number_format($totalSiswa) }}</h4>
                    <p class="text-xs text-emerald-600 font-semibold mt-1">
                        {{ $siswaAktif }} siswa berstatus aktif
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>L: <strong class="text-sky-600">{{ $siswaLaki }}</strong></span>
                <span class="text-slate-300">&bull;</span>
                <span>P: <strong class="text-rose-500">{{ $siswaPerempuan }}</strong></span>
                <a href="{{ route('siswa.index') }}" class="text-emerald-600 hover:text-emerald-700 font-medium ml-auto">Kelola &rarr;</a>
            </div>
        </div>

        <!-- 2. Total Guru -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Guru & Pendidik</p>
                    <h4 class="text-3xl font-extrabold text-slate-900 mt-1">{{ number_format($totalGuru) }}</h4>
                    <p class="text-xs text-slate-500 mt-1">Tenaga Pengajar & Ustadz</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 border border-teal-100 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>SD Islam Bina Insan Mandiri</span>
                <a href="{{ route('guru.index') }}" class="text-teal-600 hover:text-teal-700 font-medium ml-auto">Kelola &rarr;</a>
            </div>
        </div>

        <!-- 3. Total Kelas -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Rombel / Kelas</p>
                    <h4 class="text-3xl font-extrabold text-slate-900 mt-1">{{ number_format($totalKelas) }}</h4>
                    <p class="text-xs text-slate-500 mt-1">Jenjang Kelas 1 s/d 6</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 border border-sky-100 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Rombongan Belajar Aktif</span>
                <a href="{{ route('kelas.index') }}" class="text-sky-600 hover:text-sky-700 font-medium ml-auto">Kelola &rarr;</a>
            </div>
        </div>

        <!-- 4. Total Mata Pelajaran -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Mata Pelajaran</p>
                    <h4 class="text-3xl font-extrabold text-slate-900 mt-1">{{ number_format($totalMapel) }}</h4>
                    <p class="text-xs text-slate-500 mt-1">Kurikulum SDI Terpadu</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 border border-purple-100 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>e-Rapor & Akademik</span>
                <a href="{{ route('mapel.index') }}" class="text-purple-600 hover:text-purple-700 font-medium ml-auto">Kelola &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Two Operational Cards: Keuangan SPP & Presensi Hari Ini -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Card: Status Keuangan SPP Bulan Berjalan -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 border border-amber-100 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-base font-bold text-slate-900">Keuangan SPP Bulan {{ $bulanSekarang }} {{ $tahunSekarang }}</h4>
                            <p class="text-xs text-slate-500">Penerimaan & Tunggakan SPP Siswa</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold px-2.5 py-1 rounded-full {{ $sppPersen >= 80 ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                        {{ $sppPersen }}% Lunas
                    </span>
                </div>

                <!-- Progress Bar -->
                <div class="w-full bg-slate-100 rounded-full h-3 mb-5 overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 h-3 rounded-full transition-all duration-500" style="width: {{ min(100, $sppPersen) }}%"></div>
                </div>

                <!-- Metrics Grid -->
                <div class="grid grid-cols-3 gap-3 text-center mb-5">
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <p class="text-[11px] font-semibold text-slate-500">Total Tagihan</p>
                        <p class="text-sm font-bold text-slate-900 mt-0.5">Rp {{ number_format($totalTagihanSpp, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-emerald-50/70 border border-emerald-100">
                        <p class="text-[11px] font-semibold text-emerald-700">Telah Lunas</p>
                        <p class="text-sm font-bold text-emerald-700 mt-0.5">Rp {{ number_format($sppLunasNominal, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-rose-50/70 border border-rose-100">
                        <p class="text-[11px] font-semibold text-rose-700">Tunggakan</p>
                        <p class="text-sm font-bold text-rose-700 mt-0.5">Rp {{ number_format($sppBelumLunasNominal, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-500">
                    <strong>{{ $sppLunasCount }}</strong> dari <strong>{{ $sppTotalCount }}</strong> siswa telah melunasi
                </span>
                <a href="{{ route('keuangan.spp.index') }}" class="inline-flex items-center text-xs font-bold text-emerald-600 hover:text-emerald-700">
                    Buka Kasir SPP
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>

        <!-- Card: Presensi Kehadiran Siswa Hari Ini -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-base font-bold text-slate-900">Presensi Siswa Hari Ini</h4>
                            <p class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($today)->translatedFormat('l, d F Y') }}</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-blue-100 text-blue-700">
                        {{ $presensiHadirPersen }}% Hadir
                    </span>
                </div>

                <!-- Progress Bar Presensi -->
                <div class="w-full bg-slate-100 rounded-full h-3 mb-5 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-teal-500 h-3 rounded-full transition-all duration-500" style="width: {{ min(100, $presensiHadirPersen) }}%"></div>
                </div>

                <!-- Status Kehadiran 4 Grid -->
                <div class="grid grid-cols-4 gap-2.5 text-center mb-5">
                    <div class="p-3 rounded-xl bg-emerald-50 border border-emerald-100">
                        <p class="text-xs font-bold text-emerald-700">Hadir</p>
                        <p class="text-lg font-extrabold text-emerald-800 mt-0.5">{{ $presensiHadir }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-blue-50 border border-blue-100">
                        <p class="text-xs font-bold text-blue-700">Izin</p>
                        <p class="text-lg font-extrabold text-blue-800 mt-0.5">{{ $presensiIzin }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-amber-50 border border-amber-100">
                        <p class="text-xs font-bold text-amber-700">Sakit</p>
                        <p class="text-lg font-extrabold text-amber-800 mt-0.5">{{ $presensiSakit }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-rose-50 border border-rose-100">
                        <p class="text-xs font-bold text-rose-700">Alpa</p>
                        <p class="text-lg font-extrabold text-rose-800 mt-0.5">{{ $presensiAlpa }}</p>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-500">
                    Total tercatat hari ini: <strong>{{ $presensiTotal }}</strong> siswa
                </span>
                <a href="{{ route('absensi.index') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-700">
                    Input Presensi Harian
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Actions Hub (Pintasan 8 Modul Cepat) -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h4 class="text-base font-bold text-slate-900">Akses Cepat Modul SIM-SDI</h4>
                <p class="text-xs text-slate-500">Pintasan praktis untuk mengelola data sekolah dalam satu klik</p>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-3">
            <a href="{{ route('siswa.index') }}" class="p-3.5 rounded-xl bg-slate-50 hover:bg-emerald-50 hover:border-emerald-200 border border-slate-200/80 flex flex-col items-center text-center transition-all group">
                <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 group-hover:scale-110 flex items-center justify-center transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <span class="text-xs font-bold text-slate-700 group-hover:text-emerald-700 mt-2">Data Siswa</span>
                <span class="text-[10px] text-slate-400">Induk Siswa</span>
            </a>

            <a href="{{ route('guru.index') }}" class="p-3.5 rounded-xl bg-slate-50 hover:bg-teal-50 hover:border-teal-200 border border-slate-200/80 flex flex-col items-center text-center transition-all group">
                <div class="w-10 h-10 rounded-lg bg-teal-100 text-teal-700 group-hover:scale-110 flex items-center justify-center transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <span class="text-xs font-bold text-slate-700 group-hover:text-teal-700 mt-2">Data Guru</span>
                <span class="text-[10px] text-slate-400">Pendidik</span>
            </a>

            <a href="{{ route('kelas.index') }}" class="p-3.5 rounded-xl bg-slate-50 hover:bg-sky-50 hover:border-sky-200 border border-slate-200/80 flex flex-col items-center text-center transition-all group">
                <div class="w-10 h-10 rounded-lg bg-sky-100 text-sky-700 group-hover:scale-110 flex items-center justify-center transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <span class="text-xs font-bold text-slate-700 group-hover:text-sky-700 mt-2">Data Kelas</span>
                <span class="text-[10px] text-slate-400">Wali & Rombel</span>
            </a>

            <a href="{{ route('mapel.index') }}" class="p-3.5 rounded-xl bg-slate-50 hover:bg-purple-50 hover:border-purple-200 border border-slate-200/80 flex flex-col items-center text-center transition-all group">
                <div class="w-10 h-10 rounded-lg bg-purple-100 text-purple-700 group-hover:scale-110 flex items-center justify-center transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <span class="text-xs font-bold text-slate-700 group-hover:text-purple-700 mt-2">Mata Pelajaran</span>
                <span class="text-[10px] text-slate-400">KKM & Pengampu</span>
            </a>

            <a href="{{ route('keuangan.spp.index') }}" class="p-3.5 rounded-xl bg-slate-50 hover:bg-amber-50 hover:border-amber-200 border border-slate-200/80 flex flex-col items-center text-center transition-all group">
                <div class="w-10 h-10 rounded-lg bg-amber-100 text-amber-700 group-hover:scale-110 flex items-center justify-center transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <span class="text-xs font-bold text-slate-700 group-hover:text-amber-700 mt-2">Kasir SPP</span>
                <span class="text-[10px] text-slate-400">Bayar & Kuitansi</span>
            </a>

            <a href="{{ route('absensi.index') }}" class="p-3.5 rounded-xl bg-slate-50 hover:bg-blue-50 hover:border-blue-200 border border-slate-200/80 flex flex-col items-center text-center transition-all group">
                <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-700 group-hover:scale-110 flex items-center justify-center transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
                <span class="text-xs font-bold text-slate-700 group-hover:text-blue-700 mt-2">Presensi Harian</span>
                <span class="text-[10px] text-slate-400">Rekap Kelas</span>
            </a>

            <a href="{{ route('akademik.index') }}" class="p-3.5 rounded-xl bg-slate-50 hover:bg-emerald-50 hover:border-emerald-200 border border-slate-200/80 flex flex-col items-center text-center transition-all group">
                <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 group-hover:scale-110 flex items-center justify-center transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <span class="text-xs font-bold text-slate-700 group-hover:text-emerald-700 mt-2">Nilai e-Rapor</span>
                <span class="text-[10px] text-slate-400">Tugas, UTS, UAS</span>
            </a>
        </div>
    </div>

    <!-- Bottom Tables Grid: Rombel Kelas & Riwayat Transaksi -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Table 1: Rombongan Belajar & Wali Kelas -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h4 class="text-base font-bold text-slate-900">Rombongan Belajar & Wali Kelas</h4>
                    <p class="text-xs text-slate-500">Distribusi jumlah murid pada setiap kelas</p>
                </div>
                <a href="{{ route('kelas.index') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">Lihat Semua &rarr;</a>
            </div>
            <div class="divide-y divide-slate-100 max-h-96 overflow-y-auto">
                @forelse ($kelasList as $k)
                    <div class="p-4 flex items-center justify-between hover:bg-slate-50/80 transition-colors">
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-100 flex items-center justify-center font-extrabold text-xs">
                                {{ $k->nama_kelas }}
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-900">Kelas {{ $k->nama_kelas }} (Tingkat {{ $k->tingkat }})</p>
                                <p class="text-[11px] text-slate-500">
                                    Wali: <span class="text-slate-700 font-medium">{{ $k->waliKelas?->nama_guru ?? 'Belum Ditentukan' }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                                {{ $k->siswas_count }} Siswa
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-slate-400 text-xs">Belum ada data kelas yang terdaftar.</div>
                @endforelse
            </div>
        </div>

        <!-- Table 2: Pembayaran SPP Terakhir -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h4 class="text-base font-bold text-slate-900">Pembayaran SPP Terakhir</h4>
                    <p class="text-xs text-slate-500">Riwayat transaksi pelunasan kasir terkini</p>
                </div>
                <a href="{{ route('keuangan.spp.index') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">Kasir SPP &rarr;</a>
            </div>
            <div class="divide-y divide-slate-100 max-h-96 overflow-y-auto">
                @forelse ($transaksiTerbaru as $trx)
                    <div class="p-4 flex items-center justify-between hover:bg-slate-50/80 transition-colors">
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-900">{{ $trx->siswa?->nama_siswa ?? 'Siswa' }}</p>
                                <p class="text-[11px] text-slate-500">
                                    SPP {{ $trx->bulan }} {{ $trx->tahun }} &bull; {{ $trx->siswa?->kelas?->nama_kelas ?? '-' }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-bold text-emerald-700">Rp {{ number_format($trx->nominal, 0, ',', '.') }}</p>
                            <span class="text-[10px] text-slate-400 font-mono">{{ $trx->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-slate-400 text-xs">Belum ada transaksi pembayaran SPP bulan ini.</div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection

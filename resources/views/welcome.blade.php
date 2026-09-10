<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SD Islam Bina Insan Mandiri - Berkarakter Qur'ani & Berprestasi</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-900 text-slate-100 antialiased selection:bg-emerald-500 selection:text-white">

    <!-- Top Glow Background Gradient -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[1000px] h-[600px] bg-gradient-to-tr from-emerald-600/20 via-teal-500/15 to-emerald-950/0 blur-[130px] rounded-full"></div>
        <div class="absolute top-[600px] -right-40 w-[600px] h-[500px] bg-teal-600/10 blur-[120px] rounded-full"></div>
        <div class="absolute top-[1200px] -left-40 w-[600px] h-[500px] bg-emerald-700/10 blur-[140px] rounded-full"></div>
    </div>

    <!-- Sticky Navigation Bar -->
    <header class="sticky top-0 z-50 backdrop-blur-md bg-slate-950/80 border-b border-slate-800/80 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand Logo -->
                <a href="{{ url('/') }}" class="flex items-center space-x-3.5 group">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-700 flex items-center justify-center text-white shadow-lg shadow-emerald-900/40 ring-2 ring-emerald-400/30 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-base font-extrabold text-white tracking-wide">SDI Bina Insan Mandiri</span>
                            <span class="text-[10px] bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 px-1.5 py-0.5 rounded-full font-semibold">Akreditasi A</span>
                        </div>
                        <p class="text-xs text-slate-400">Islamic Integrated School &bull; SIM-SDI Portal</p>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center space-x-8 text-sm font-semibold text-slate-300">
                    <a href="#profil" class="hover:text-emerald-400 transition-colors">Profil</a>
                    <a href="#program" class="hover:text-emerald-400 transition-colors">Program Unggulan</a>
                    <a href="#sim-sdi" class="hover:text-emerald-400 transition-colors">Fitur SIM-SDI</a>
                    <a href="#keunggulan" class="hover:text-emerald-400 transition-colors">Keunggulan</a>
                    <a href="#kontak" class="hover:text-emerald-400 transition-colors">Kontak</a>
                </nav>

                <!-- Auth / Portal Action Button -->
                <div class="flex items-center space-x-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 shadow-lg shadow-emerald-900/40 border border-emerald-400/30 transition-all hover:scale-105">
                            <span>Masuk ke SIM-SDI</span>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 shadow-lg shadow-emerald-900/40 border border-emerald-400/30 transition-all hover:scale-105">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            <span>Login Guru & Staf</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative pt-20 pb-28 sm:pt-28 sm:pb-36 z-10 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto space-y-6">
                <!-- Announcement Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-300 border border-emerald-500/30 shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Tahun Ajaran 2026/2027 &bull; Penerimaan Peserta Didik Baru & Portal Terintegrasi</span>
                </div>

                <!-- Main Hero Heading -->
                <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black tracking-tight text-white leading-tight">
                    Membentuk Generasi <span class="bg-gradient-to-r from-emerald-400 via-teal-300 to-cyan-400 bg-clip-text text-transparent">Qur'ani</span>, Beradab, & Berprestasi Global
                </h1>

                <!-- Subtitle -->
                <p class="text-base sm:text-xl text-slate-300 max-w-2xl mx-auto leading-relaxed font-normal">
                    SD Islam Bina Insan Mandiri mengintegrasikan pembiasaan ibadah harian, program tahfidz bersanad, kurikulum nasional terkini, dan manajemen sekolah digital modern (SIM-SDI).
                </p>

                <!-- Hero Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl text-base font-extrabold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 shadow-xl shadow-emerald-900/50 border border-emerald-400/30 transition-all hover:scale-105 flex items-center justify-center gap-2">
                            <span>Buka Portal Dashboard SIM-SDI</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl text-base font-extrabold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 shadow-xl shadow-emerald-900/50 border border-emerald-400/30 transition-all hover:scale-105 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            <span>Masuk ke Portal SIM-SDI</span>
                        </a>
                    @endauth

                    <a href="#sim-sdi" class="w-full sm:w-auto px-8 py-4 rounded-2xl text-base font-bold text-slate-300 bg-slate-800/80 hover:bg-slate-800 hover:text-white border border-slate-700/80 transition-all flex items-center justify-center gap-2">
                        <span>Jelajahi Ekosistem SIM-SDI</span>
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                </div>

                <!-- Trust Badges -->
                <div class="pt-8 flex flex-wrap items-center justify-center gap-6 sm:gap-10 text-xs font-semibold text-slate-400">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>Kurikulum Merdeka Terintegrasi</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>Target Hafalan Juz 30 & 29</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>e-Rapor & Presensi Digital</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Key Metrics / Statistics Counter Section -->
    <section class="relative z-10 -mt-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-slate-950/80 border border-slate-800 rounded-3xl p-6 sm:p-8 backdrop-blur-xl shadow-2xl">
            <div class="text-center p-4 border-r border-slate-800/80">
                <p class="text-3xl sm:text-4xl font-black text-emerald-400 tracking-tight">450+</p>
                <p class="text-xs sm:text-sm font-semibold text-slate-400 mt-1">Siswa & Siswi Aktif</p>
            </div>
            <div class="text-center p-4 md:border-r border-slate-800/80">
                <p class="text-3xl sm:text-4xl font-black text-teal-400 tracking-tight">32</p>
                <p class="text-xs sm:text-sm font-semibold text-slate-400 mt-1">Guru & Asatidz Bersertifikasi</p>
            </div>
            <div class="text-center p-4 border-r border-slate-800/80">
                <p class="text-3xl sm:text-4xl font-black text-cyan-400 tracking-tight">100%</p>
                <p class="text-xs sm:text-sm font-semibold text-slate-400 mt-1">Kelulusan Ujian & Tuntas KKM</p>
            </div>
            <div class="text-center p-4">
                <p class="text-3xl sm:text-4xl font-black text-amber-400 tracking-tight">18+</p>
                <p class="text-xs sm:text-sm font-semibold text-slate-400 mt-1">Prestasi Sains & Tahfidz</p>
            </div>
        </div>
    </section>

    <!-- Program Unggulan Section -->
    <section id="program" class="relative py-24 sm:py-32 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-bold uppercase tracking-widest text-emerald-400">Pendidikan Berkelanjutan</span>
                <h2 class="text-3xl sm:text-4xl font-black text-white mt-2 tracking-tight">Program Unggulan Sekolah</h2>
                <p class="text-slate-400 text-sm sm:text-base mt-3">Kurikulum yang seimbang antara bekal ukhrawi dan kesiapan kompetensi ilmiah era modern.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1: Tahfidz -->
                <div class="bg-slate-950/60 border border-slate-800 hover:border-emerald-500/50 rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1.5 group">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center mb-5 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white group-hover:text-emerald-300 transition-colors">Tahfidzul Qur'an Bersanad</h3>
                    <p class="text-xs sm:text-sm text-slate-400 mt-2 leading-relaxed">
                        Target hafalan minimal 2 Juz (Juz 30 & 29) dengan metode talaqqi bersanad, tahsin makharijul huruf, dan munaqasyah tahunan.
                    </p>
                </div>

                <!-- Card 2: Bilingual -->
                <div class="bg-slate-950/60 border border-slate-800 hover:border-teal-500/50 rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1.5 group">
                    <div class="w-12 h-12 rounded-xl bg-teal-500/10 border border-teal-500/20 text-teal-400 flex items-center justify-center mb-5 group-hover:bg-teal-500 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white group-hover:text-teal-300 transition-colors">Bilingual Arabic & English</h3>
                    <p class="text-xs sm:text-sm text-slate-400 mt-2 leading-relaxed">
                        Pembiasaan kosa kata (mufradat) harian bahasa Arab dan dialog bahasa Inggris terstruktur untuk memperluas wawasan internasional siswa.
                    </p>
                </div>

                <!-- Card 3: Adab & Karakter -->
                <div class="bg-slate-950/60 border border-slate-800 hover:border-cyan-500/50 rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1.5 group">
                    <div class="w-12 h-12 rounded-xl bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 flex items-center justify-center mb-5 group-hover:bg-cyan-500 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white group-hover:text-cyan-300 transition-colors">Adab & Karakter Islami</h3>
                    <p class="text-xs sm:text-sm text-slate-400 mt-2 leading-relaxed">
                        Mendahulukan adab sebelum ilmu: pembiasaan shalat dhuha & dzuhur berjamaah, doa harian, akhlaqul karimah, dan filantropi infak Jumat.
                    </p>
                </div>

                <!-- Card 4: Sains & Ekskul -->
                <div class="bg-slate-950/60 border border-slate-800 hover:border-amber-500/50 rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1.5 group">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center mb-5 group-hover:bg-amber-500 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white group-hover:text-amber-300 transition-colors">Sains, Robotik & Sunnah</h3>
                    <p class="text-xs sm:text-sm text-slate-400 mt-2 leading-relaxed">
                        Eksplorasi bakat anak melalui ekstrakurikuler Robotik, Panahan Sunnah, Taekwondo, Sains Club, dan Kaligrafi Islam.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Fitur Terintegrasi SIM-SDI Showcase -->
    <section id="sim-sdi" class="relative py-24 sm:py-32 bg-slate-950/70 border-y border-slate-800/80 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-12">
                <!-- Left Details -->
                <div class="max-w-xl space-y-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-lg text-xs font-semibold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                        <span>ECOSYSTEM PORTAL</span>
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">
                        Didukung Sistem Informasi Manajemen <span class="bg-gradient-to-r from-emerald-400 to-teal-400 bg-clip-text text-transparent">SIM-SDI</span>
                    </h2>
                    <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                        Portal digital sekolah yang dirancang khusus untuk mempercepat kinerja guru, tata usaha, dan manajemen sekolah tanpa hambatan administrasi manual.
                    </p>

                    <div class="space-y-4 pt-2">
                        <!-- Feature 1 -->
                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-lg bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400 shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-white">e-Rapor & Kalkulasi Nilai Otomatis</h4>
                                <p class="text-xs text-slate-400 mt-0.5">Grid spreadsheet interaktif (30% Tugas + 30% UTS + 40% UAS) dengan kalkulasi predikat dan KKM seketika.</p>
                            </div>
                        </div>

                        <!-- Feature 2 -->
                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-lg bg-teal-500/20 border border-teal-500/30 flex items-center justify-center text-teal-400 shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-white">Presensi Harian Berbasis Grid Rombel</h4>
                                <p class="text-xs text-slate-400 mt-0.5">Guru wali kelas mengisi kehadiran sekelas secara serentak (H/I/S/A) dengan rekapitulasi bulanan otomatis.</p>
                            </div>
                        </div>

                        <!-- Feature 3 -->
                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-lg bg-cyan-500/20 border border-cyan-500/30 flex items-center justify-center text-cyan-400 shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-white">Kasir Keuangan SPP & Kuitansi Resmi</h4>
                                <p class="text-xs text-slate-400 mt-0.5">Generate tagihan massal per tahun ajaran, pencatatan transaksi kasir, dan cetak kuitansi siap pakai untuk wali murid.</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 rounded-xl text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-500 shadow-md shadow-emerald-900/30 transition-all">
                            <span>Akses SIM-SDI Sekarang</span>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>

                <!-- Right Visual Mockup Card -->
                <div class="w-full lg:max-w-lg bg-slate-900/90 border border-slate-800 rounded-3xl p-6 shadow-2xl backdrop-blur-md relative overflow-hidden">
                    <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-800">
                        <div class="flex items-center space-x-2">
                            <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                            <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                            <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                        </div>
                        <span class="text-xs font-mono text-slate-400">sim-sdi.sch.id/dashboard</span>
                    </div>

                    <!-- Mini Mockup Items -->
                    <div class="space-y-3">
                        <div class="bg-slate-950/80 p-3.5 rounded-xl border border-slate-800 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-xs">ER</div>
                                <div>
                                    <p class="text-xs font-bold text-white">e-Rapor PAI & Tahfidz</p>
                                    <p class="text-[10px] text-slate-400">Kelas 1-A &bull; Rata-rata 90.20 (Tuntas)</p>
                                </div>
                            </div>
                            <span class="text-[10px] bg-emerald-500/20 text-emerald-300 px-2 py-0.5 rounded font-mono font-bold">A</span>
                        </div>

                        <div class="bg-slate-950/80 p-3.5 rounded-xl border border-slate-800 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-500/20 text-blue-400 flex items-center justify-center font-bold text-xs">PR</div>
                                <div>
                                    <p class="text-xs font-bold text-white">Presensi Harian Siswa</p>
                                    <p class="text-[10px] text-slate-400">Hari ini: 98.5% Tingkat Hadir</p>
                                </div>
                            </div>
                            <span class="text-[10px] bg-blue-500/20 text-blue-300 px-2 py-0.5 rounded font-mono font-bold">Hadir</span>
                        </div>

                        <div class="bg-slate-950/80 p-3.5 rounded-xl border border-slate-800 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold text-xs">SP</div>
                                <div>
                                    <p class="text-xs font-bold text-white">Kasir Keuangan SPP</p>
                                    <p class="text-[10px] text-slate-400">Kuitansi Resmi Cetak Terbit</p>
                                </div>
                            </div>
                            <span class="text-[10px] bg-emerald-500/20 text-emerald-300 px-2 py-0.5 rounded font-mono font-bold">Lunas</span>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-slate-800/80 flex items-center justify-between text-xs text-slate-400">
                        <span>Role: Administrator, Guru, TU</span>
                        <span class="text-emerald-400 font-semibold">Aktif & Aman</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Banner -->
    <section class="relative py-20 z-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-emerald-800 via-teal-900 to-slate-900 border border-emerald-500/30 rounded-3xl p-8 sm:p-12 text-center relative overflow-hidden shadow-2xl">
                <div class="max-w-2xl mx-auto space-y-4">
                    <h3 class="text-2xl sm:text-4xl font-black text-white tracking-tight">
                        Siap Memulai Aktivitas Pembelajaran & Administrasi?
                    </h3>
                    <p class="text-emerald-100/80 text-sm sm:text-base">
                        Silakan login menggunakan akun staf atau guru yang telah terdaftar di sistem untuk mengakses modul e-Rapor, presensi, dan keuangan.
                    </p>
                    <div class="pt-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-8 py-3.5 rounded-2xl text-base font-extrabold text-slate-950 bg-white hover:bg-emerald-50 shadow-xl transition-all hover:scale-105">
                                <span>Buka Dashboard Utama</span>
                                <svg class="w-5 h-5 ml-2 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-3.5 rounded-2xl text-base font-extrabold text-slate-950 bg-white hover:bg-emerald-50 shadow-xl transition-all hover:scale-105">
                                <span>Masuk ke Portal Guru & Staf</span>
                                <svg class="w-5 h-5 ml-2 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak" class="relative bg-slate-950 border-t border-slate-800 text-slate-400 py-12 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Col 1 -->
                <div class="space-y-3 md:col-span-2">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-xl bg-emerald-600 flex items-center justify-center text-white font-black text-sm">
                            SDI
                        </div>
                        <span class="text-base font-bold text-white">SD Islam Bina Insan Mandiri</span>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-400 max-w-sm leading-relaxed">
                        Mewujudkan generasi shaleh, cerdas, berprestasi, dan berakhlak mulia dengan landasan Al-Qur'an dan As-Sunnah.
                    </p>
                </div>

                <!-- Col 2 -->
                <div class="space-y-2">
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider">Akses Portal</h4>
                    <ul class="space-y-1 text-xs">
                        <li><a href="{{ route('login') }}" class="hover:text-emerald-400 transition-colors">Login Guru & Admin</a></li>
                        <li><a href="{{ route('dashboard') }}" class="hover:text-emerald-400 transition-colors">Dashboard SIM-SDI</a></li>
                        <li><a href="#sim-sdi" class="hover:text-emerald-400 transition-colors">Modul e-Rapor Siswa</a></li>
                        <li><a href="#sim-sdi" class="hover:text-emerald-400 transition-colors">Presensi & Keuangan SPP</a></li>
                    </ul>
                </div>

                <!-- Col 3 -->
                <div class="space-y-2">
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider">Kontak Sekolah</h4>
                    <p class="text-xs leading-relaxed">
                        Komplek Pendidikan Bina Insan Mandiri<br>
                        Telp / WA: (021) 7890-1234 / 0812-3456-7890<br>
                        Email: info@sdi-bim.sch.id
                    </p>
                </div>
            </div>

            <div class="border-t border-slate-800/80 pt-6 text-center text-xs text-slate-500">
                &copy; {{ date('Y') }} SD Islam Bina Insan Mandiri &bull; Didukung oleh SIM-SDI (Sistem Informasi Manajemen Sekolah Terpadu).
            </div>
        </div>
    </footer>

</body>
</html>

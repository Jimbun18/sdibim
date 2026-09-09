<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kuitansi Pembayaran SPP - {{ $spp->siswa->nama_siswa }} ({{ $spp->bulan }} {{ $spp->tahun }})</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Mono:wght@700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white !important;
                padding: 0 !important;
            }
            .kuitansi-box {
                box-shadow: none !important;
                border: 1px solid #cbd5e1 !important;
                width: 100% !important;
            }
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen p-4 sm:p-8 flex flex-col items-center">

    <!-- Action Bar (No Print) -->
    <div class="no-print max-w-2xl w-full flex items-center justify-between mb-4">
        <a href="{{ route('keuangan.spp.index') }}" class="inline-flex items-center text-xs font-semibold text-slate-600 bg-white border border-slate-300 px-3.5 py-2 rounded-xl hover:bg-slate-50 transition-colors shadow-xs">
            &larr; Kembali ke Kasir SPP
        </a>
        <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-emerald-700 hover:bg-emerald-800 rounded-xl shadow-md transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak Kuitansi Resmi
        </button>
    </div>

    <!-- Official Kuitansi Box -->
    <div class="kuitansi-box bg-white max-w-2xl w-full rounded-2xl border border-slate-300 p-8 shadow-xl relative overflow-hidden">
        <!-- Watermark LUNAS -->
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-5">
            <span class="text-8xl font-black text-emerald-900 rotate-12 uppercase">LUNAS</span>
        </div>

        <!-- School Letterhead Header -->
        <div class="border-b-2 border-slate-900 pb-4 text-center">
            <h2 class="text-lg font-black text-slate-900 tracking-wide uppercase">SD ISLAM BINA INSAN MANDIRI</h2>
            <p class="text-xs text-slate-600 font-medium mt-0.5">Sistem Informasi Manajemen Sekolah Terintegrasi (SIM-SDI)</p>
            <p class="text-[11px] text-slate-500">Jl. Bintang Madani Raya No. 45 &bull; Telp: (021) 88997766 &bull; Email: tu@sdi-bim.sch.id</p>
        </div>

        <!-- Kuitansi Title & Number -->
        <div class="mt-4 flex items-center justify-between text-xs">
            <div>
                <span class="font-bold uppercase tracking-wider text-emerald-800 bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded-md">
                    BUKTI PEMBAYARAN SPP (LUNAS)
                </span>
            </div>
            <div class="text-right font-mono text-slate-600">
                <span>No: <strong class="text-slate-900">KW-SPP/{{ $spp->tahun }}/{{ str_pad($spp->id, 5, '0', STR_PAD_LEFT) }}</strong></span>
            </div>
        </div>

        <!-- Payment Details Table -->
        <div class="mt-6 border border-slate-200 rounded-xl overflow-hidden">
            <table class="w-full text-xs text-left">
                <tr class="border-b border-slate-200 bg-slate-50/70">
                    <td class="py-2.5 px-4 font-semibold text-slate-500 w-44">Telah Diterima Dari</td>
                    <td class="py-2.5 px-4 font-bold text-slate-900 text-sm">{{ $spp->siswa->nama_siswa }}</td>
                </tr>
                <tr class="border-b border-slate-200">
                    <td class="py-2.5 px-4 font-semibold text-slate-500">Nomor Induk Siswa (NIS)</td>
                    <td class="py-2.5 px-4 font-mono font-medium text-slate-800">{{ $spp->siswa->nis }} (NISN: {{ $spp->siswa->nisn ?? '-' }})</td>
                </tr>
                <tr class="border-b border-slate-200 bg-slate-50/70">
                    <td class="py-2.5 px-4 font-semibold text-slate-500">Rombongan Belajar / Kelas</td>
                    <td class="py-2.5 px-4 font-semibold text-slate-800">Kelas {{ $spp->siswa->kelas?->nama_kelas ?? '-' }} (Wali: {{ $spp->siswa->kelas?->waliKelas?->nama_guru ?? '-' }})</td>
                </tr>
                <tr class="border-b border-slate-200">
                    <td class="py-2.5 px-4 font-semibold text-slate-500">Untuk Pembayaran</td>
                    <td class="py-2.5 px-4 font-semibold text-emerald-800">Iuran Sumbangan Pembinaan Pendidikan (SPP) Bulan {{ $spp->bulan }} Tahun {{ $spp->tahun }}</td>
                </tr>
                <tr class="border-b border-slate-200 bg-slate-50/70">
                    <td class="py-2.5 px-4 font-semibold text-slate-500">Metode & Tanggal Bayar</td>
                    <td class="py-2.5 px-4 font-medium text-slate-800">{{ $spp->metode_bayar ?? 'Tunai' }} &bull; {{ $spp->tanggal_bayar?->translatedFormat('d F Y - H:i') ?? '-' }} WIB</td>
                </tr>
                <tr class="bg-emerald-50/60">
                    <td class="py-3 px-4 font-bold text-emerald-900 uppercase">Jumlah Nominal</td>
                    <td class="py-3 px-4 font-mono font-black text-lg text-emerald-800">Rp {{ number_format($spp->nominal, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <!-- Notes -->
        <p class="text-[11px] text-slate-500 italic mt-3">
            * Catatan Kasir: {{ $spp->catatan ?? 'Pembayaran telah divalidasi dan dicatat secara sistem di database SIM-SDI.' }}
        </p>

        <!-- Signatures -->
        <div class="mt-8 pt-4 border-t border-slate-200 grid grid-cols-2 text-center text-xs">
            <div>
                <p class="text-slate-500">Orang Tua / Siswa,</p>
                <div class="h-16"></div>
                <p class="font-bold text-slate-800">({{ $spp->siswa->nama_wali ?? $spp->siswa->nama_siswa }})</p>
            </div>
            <div>
                <p class="text-slate-500">Kasir / Bagian Tata Usaha,</p>
                <div class="h-16 flex items-center justify-center">
                    <span class="text-[10px] font-bold text-emerald-700 uppercase border border-emerald-300 bg-emerald-50 px-2 py-0.5 rounded">TERVERIFIKASI SISTEM</span>
                </div>
                <p class="font-bold text-slate-900">( Petugas Kasir SIM-SDI )</p>
            </div>
        </div>
    </div>

</body>
</html>

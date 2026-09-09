@extends('layouts.app')

@section('title', 'Keuangan SPP & Kasir')
@section('page_title', 'Modul Keuangan SPP & Antarmuka Kasir')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-emerald-700 mb-1">
                <span>KEUANGAN</span>
                <span>/</span>
                <span>TAGIHAN & KASIR SPP</span>
            </div>
            <h3 class="text-xl font-extrabold text-slate-900 tracking-tight">Manajemen Tagihan SPP & Kasir</h3>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Generate tagihan bulanan massal untuk siswa aktif dan kelola pelunasan kasir secara real-time.</p>
        </div>
        <div class="flex items-center gap-3">
            <!-- Button Buka Modal Generate SPP -->
            <button type="button" onclick="openGenerateModal()" class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-700/20 transition-all transform active:scale-95">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                + Generate Tagihan Massal
            </button>
        </div>
    </div>

    <!-- Financial Metric Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Tagihan -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Tagihan</span>
                <span class="w-9 h-9 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-xs">
                    {{ $jumlahLunas + $jumlahBelumLunas }}
                </span>
            </div>
            <h4 class="text-2xl font-black text-slate-900 mt-2 font-mono">Rp {{ number_format($totalTagihanNominal, 0, ',', '.') }}</h4>
            <p class="text-xs text-slate-400 mt-1">Periode {{ $bulan }} {{ $tahun }}</p>
        </div>

        <!-- Total Terbayar (Lunas) -->
        <div class="bg-white p-5 rounded-2xl border border-emerald-100 shadow-xs ring-1 ring-emerald-500/10">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Terbayar (Lunas)</span>
                <span class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xs">
                    {{ $jumlahLunas }}
                </span>
            </div>
            <h4 class="text-2xl font-black text-emerald-600 mt-2 font-mono">Rp {{ number_format($totalLunasNominal, 0, ',', '.') }}</h4>
            <p class="text-xs text-emerald-700/80 mt-1 font-medium">{{ $jumlahLunas }} siswa telah lunas</p>
        </div>

        <!-- Total Tunggakan (Belum Lunas) -->
        <div class="bg-white p-5 rounded-2xl border border-rose-100 shadow-xs ring-1 ring-rose-500/10">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-rose-700 uppercase tracking-wider">Tunggakan (Belum Lunas)</span>
                <span class="w-9 h-9 rounded-xl bg-rose-100 text-rose-800 flex items-center justify-center font-bold text-xs">
                    {{ $jumlahBelumLunas }}
                </span>
            </div>
            <h4 class="text-2xl font-black text-rose-600 mt-2 font-mono">Rp {{ number_format($totalBelumLunasNominal, 0, ',', '.') }}</h4>
            <p class="text-xs text-rose-700/80 mt-1 font-medium">{{ $jumlahBelumLunas }} siswa belum melunasi</p>
        </div>

        <!-- Ketercapaian Kasir -->
        @php
            $persentaseLunas = ($jumlahLunas + $jumlahBelumLunas) > 0 ? round(($jumlahLunas / ($jumlahLunas + $jumlahBelumLunas)) * 100, 1) : 0;
        @endphp
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Ketercapaian Kasir</span>
                <span class="text-xs font-bold text-teal-700 bg-teal-50 border border-teal-200 px-2 py-0.5 rounded-full">{{ $persentaseLunas }}%</span>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-3 mt-4 overflow-hidden">
                <div class="bg-gradient-to-r from-teal-500 to-emerald-600 h-3 rounded-full transition-all duration-500" style="width: {{ $persentaseLunas }}%"></div>
            </div>
            <p class="text-xs text-slate-400 mt-2">Rasio pelunasan tagihan SPP</p>
        </div>
    </div>

    <!-- Filter Toolbar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <form action="{{ route('keuangan.spp.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-center">
            <!-- Filter Bulan -->
            <div class="lg:col-span-2">
                <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Bulan</label>
                <select name="bulan" class="w-full py-2 px-3 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    @foreach ($daftarBulan as $b)
                        <option value="{{ $b }}" {{ $bulan === $b ? 'selected' : '' }}>{{ $b }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Tahun -->
            <div class="lg:col-span-2">
                <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Tahun</label>
                <input type="number" name="tahun" value="{{ $tahun }}" min="2020" max="2035" class="w-full py-2 px-3 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
            </div>

            <!-- Filter Kelas -->
            <div class="lg:col-span-3">
                <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Kelas</label>
                <select name="kelas_id" class="w-full py-2 px-3 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    <option value="">-- Semua Kelas --</option>
                    @foreach ($kelasList as $k)
                        <option value="{{ $k->id }}" {{ (string) $kelasId === (string) $k->id ? 'selected' : '' }}>
                            Kelas {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Status Bayar -->
            <div class="lg:col-span-2">
                <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Status Bayar</label>
                <select name="status_bayar" class="w-full py-2 px-3 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    <option value="">-- Semua Status --</option>
                    <option value="belum_lunas" {{ $statusBayar === 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                    <option value="lunas" {{ $statusBayar === 'lunas' ? 'selected' : '' }}>Lunas</option>
                </select>
            </div>

            <!-- Search Nama/NIS -->
            <div class="lg:col-span-3">
                <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Cari Siswa</label>
                <div class="flex items-center gap-2">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Nama / NIS..." class="flex-1 py-2 px-3 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    <button type="submit" class="p-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl transition-colors shrink-0 shadow-xs" title="Terapkan Filter">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                    @if ($search || $kelasId || $statusBayar)
                        <a href="{{ route('keuangan.spp.index', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="p-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl transition-colors shrink-0" title="Reset Filter">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Data Table Kasir SPP -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50/90 text-slate-600 font-semibold border-b border-slate-200 uppercase text-[11px] tracking-wider">
                    <tr>
                        <th scope="col" class="py-3.5 px-4 text-center w-12">No</th>
                        <th scope="col" class="py-3.5 px-4">Siswa & Kelas</th>
                        <th scope="col" class="py-3.5 px-4">Periode</th>
                        <th scope="col" class="py-3.5 px-4">Nominal Tagihan</th>
                        <th scope="col" class="py-3.5 px-4 text-center">Status Pembayaran</th>
                        <th scope="col" class="py-3.5 px-4">Rincian Pembayaran</th>
                        <th scope="col" class="py-3.5 px-4 text-center w-48">Aksi Kasir</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($tagihanList as $index => $spp)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-4 text-center text-xs text-slate-400 font-mono">
                                {{ $tagihanList->firstItem() + $index }}
                            </td>
                            <!-- Siswa & Kelas -->
                            <td class="py-4 px-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-9 h-9 rounded-full shrink-0 flex items-center justify-center font-bold text-xs border {{ $spp->siswa->jenis_kelamin === 'L' ? 'bg-sky-50 text-sky-700 border-sky-200' : 'bg-rose-50 text-rose-700 border-rose-200' }}">
                                        {{ mb_substr($spp->siswa->nama_siswa, 0, 2) }}
                                    </div>
                                    <div>
                                        <a href="{{ route('siswa.show', $spp->siswa) }}" class="font-bold text-slate-900 hover:text-emerald-600 transition-colors">
                                            {{ $spp->siswa->nama_siswa }}
                                        </a>
                                        <div class="flex items-center gap-2 text-xs text-slate-500 font-mono">
                                            <span>NIS: {{ $spp->siswa->nis }}</span>
                                            <span>&bull;</span>
                                            <span class="font-medium text-emerald-700">Kelas {{ $spp->siswa->kelas?->nama_kelas ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Periode -->
                            <td class="py-4 px-4 font-semibold text-slate-800">
                                {{ $spp->bulan }} {{ $spp->tahun }}
                            </td>

                            <!-- Nominal -->
                            <td class="py-4 px-4 font-mono font-bold text-slate-900">
                                Rp {{ number_format($spp->nominal, 0, ',', '.') }}
                            </td>

                            <!-- Status Bayar -->
                            <td class="py-4 px-4 text-center">
                                @if ($spp->status_bayar === 'lunas')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        LUNAS
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800 border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        BELUM LUNAS
                                    </span>
                                @endif
                            </td>

                            <!-- Rincian -->
                            <td class="py-4 px-4 text-xs text-slate-600">
                                @if ($spp->status_bayar === 'lunas')
                                    <p class="font-semibold text-slate-900">{{ $spp->tanggal_bayar?->format('d/m/Y H:i') ?? '-' }}</p>
                                    <p class="text-slate-500">{{ $spp->metode_bayar ?? 'Tunai' }}</p>
                                @else
                                    <span class="text-slate-400 italic">Menunggu pembayaran</span>
                                @endif
                            </td>

                            <!-- Aksi Kasir -->
                            <td class="py-4 px-4 text-center">
                                <div class="inline-flex items-center gap-2">
                                    @if ($spp->status_bayar === 'belum_lunas')
                                        <!-- Tombol Kasir: Bayar Sekarang -->
                                        <button type="button" onclick="openBayarModal({{ $spp->id }}, '{{ addslashes($spp->siswa->nama_siswa) }}', '{{ $spp->bulan }} {{ $spp->tahun }}', {{ $spp->nominal }})" class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 shadow-xs transition-colors">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            Bayar Kasir
                                        </button>
                                    @else
                                        <!-- Cetak Kuitansi -->
                                        <a href="{{ route('keuangan.spp.kuitansi', $spp) }}" target="_blank" class="p-1.5 text-slate-600 hover:text-emerald-700 hover:bg-slate-100 rounded-lg transition-colors border border-slate-200" title="Cetak Kuitansi Resmi">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                        </a>

                                        <!-- Batal Bayar -->
                                        <form action="{{ route('keuangan.spp.batal', $spp) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan status pembayaran lunas untuk siswa {{ $spp->siswa->nama_siswa }}?');" class="inline">
                                            @csrf
                                            <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Batalkan Pembayaran">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 px-4 text-center">
                                <div class="max-w-sm mx-auto space-y-3">
                                    <div class="w-14 h-14 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center mx-auto">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <h5 class="text-base font-bold text-slate-800">Tidak ada tagihan SPP</h5>
                                    <p class="text-xs text-slate-500">Belum ada data tagihan SPP untuk periode <strong>{{ $bulan }} {{ $tahun }}</strong>. Anda dapat membuat tagihan massal untuk seluruh siswa aktif sekarang.</p>
                                    <button type="button" onclick="openGenerateModal()" class="inline-flex items-center px-4 py-2 text-xs font-semibold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition-colors shadow-xs">
                                        + Generate Tagihan Periode Ini
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($tagihanList->hasPages())
            <div class="px-6 py-4 bg-slate-50/80 border-t border-slate-200">
                {{ $tagihanList->links() }}
            </div>
        @endif
    </div>

</div>

<!-- MODAL 1: Generate Tagihan Massal -->
<div id="modal-generate-spp" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl max-w-lg w-full border border-slate-200 shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-150">
        <div class="p-6 bg-slate-950 text-white flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <div>
                    <h4 class="text-base font-bold text-white leading-tight">Generate Tagihan SPP Massal</h4>
                    <p class="text-xs text-slate-400">Tagihan otomatis untuk seluruh siswa aktif</p>
                </div>
            </div>
            <button type="button" onclick="closeGenerateModal()" class="text-slate-400 hover:text-white p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form action="{{ route('keuangan.spp.generate') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Bulan Tagihan <span class="text-rose-500">*</span></label>
                <select name="bulan" required class="w-full py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    @foreach ($daftarBulan as $b)
                        <option value="{{ $b }}" {{ $bulan === $b ? 'selected' : '' }}>{{ $b }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tahun Tagihan <span class="text-rose-500">*</span></label>
                <input type="number" name="tahun" value="{{ $tahun }}" min="2020" max="2035" required class="w-full py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nominal Tagihan SPP (Rp) <span class="text-rose-500">*</span></label>
                <input type="number" name="nominal" value="350000" min="1000" step="5000" required placeholder="Contoh: 350000" class="w-full py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl text-sm font-mono text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                <p class="text-[11px] text-slate-500 mt-1">Standar SPP bulanan SD Islam Bina Insan Mandiri.</p>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Sasaran Siswa</label>
                <select name="kelas_id" class="w-full py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    <option value="">Semua Siswa Aktif Seluruh Kelas</option>
                    @foreach ($kelasList as $k)
                        <option value="{{ $k->id }}">Hanya Kelas {{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <div class="bg-amber-50 border border-amber-200/80 rounded-xl p-3 text-xs text-amber-800 flex items-start gap-2">
                <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Sistem secara otomatis akan mengabaikan siswa yang sudah memiliki tagihan pada bulan dan tahun yang sama sehingga tidak terjadi tagihan ganda.</span>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeGenerateModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-md shadow-emerald-700/20 transition-all">
                    Proses Generate Tagihan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL 2: Kasir Pembayaran SPP (Pelunasan) -->
<div id="modal-bayar-spp" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl max-w-md w-full border border-slate-200 shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-150">
        <div class="p-5 bg-slate-950 text-white flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-white">Kasir Pelunasan SPP</h4>
                    <p class="text-xs text-slate-400" id="bayar-modal-subtitle">Proses pembayaran tagihan</p>
                </div>
            </div>
            <button type="button" onclick="closeBayarModal()" class="text-slate-400 hover:text-white p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form id="form-bayar-spp" method="POST" class="p-6 space-y-4">
            @csrf

            <div class="bg-slate-50 border border-slate-200 p-4 rounded-xl text-center space-y-1">
                <p class="text-xs text-slate-500 font-medium">Nominal Pembayaran</p>
                <h3 class="text-2xl font-extrabold text-slate-900 font-mono" id="bayar-modal-nominal">Rp 0</h3>
                <p class="text-xs font-semibold text-emerald-700" id="bayar-modal-siswa">Nama Siswa</p>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Metode Pembayaran <span class="text-rose-500">*</span></label>
                <select name="metode_bayar" required class="w-full py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    <option value="Tunai (Kasir TU)">Tunai (Kasir TU)</option>
                    <option value="Transfer Bank BSI">Transfer Bank Syariah Indonesia (BSI)</option>
                    <option value="QRIS / Dompet Digital">QRIS / Dompet Digital</option>
                    <option value="Transfer Bank Muamalat">Transfer Bank Muamalat</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tanggal Pembayaran <span class="text-rose-500">*</span></label>
                <input type="datetime-local" name="tanggal_bayar" id="tanggal_bayar_input" required class="w-full py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Catatan Kasir (Opsional)</label>
                <input type="text" name="catatan" placeholder="Nomor referensi / keterangan..." class="w-full py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeBayarModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-md shadow-emerald-700/20 transition-all">
                    Konfirmasi Pelunasan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openGenerateModal() {
        document.getElementById('modal-generate-spp').classList.remove('hidden');
    }
    function closeGenerateModal() {
        document.getElementById('modal-generate-spp').classList.add('hidden');
    }

    function openBayarModal(id, namaSiswa, periode, nominal) {
        const form = document.getElementById('form-bayar-spp');
        form.action = `/keuangan/spp/${id}/bayar`;

        document.getElementById('bayar-modal-siswa').innerText = namaSiswa;
        document.getElementById('bayar-modal-subtitle').innerText = `Tagihan Periode ${periode}`;
        document.getElementById('bayar-modal-nominal').innerText = `Rp ${Number(nominal).toLocaleString('id-ID')}`;

        // Set tanggal bayar default hari ini sekarang
        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        document.getElementById('tanggal_bayar_input').value = now.toISOString().slice(0, 16);

        document.getElementById('modal-bayar-spp').classList.remove('hidden');
    }
    function closeBayarModal() {
        document.getElementById('modal-bayar-spp').classList.add('hidden');
    }
</script>
@endpush
@endsection

@extends('layouts.app')

@section('title', 'Profil Siswa - ' . $siswa->nama_siswa)
@section('page_title', 'Profil Lengkap Siswa')

@section('content')
<div class="space-y-6">

    <!-- Header Breadcrumb & Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-emerald-700 mb-1">
                <a href="{{ route('siswa.index') }}" class="hover:underline">DATA SISWA</a>
                <span>/</span>
                <span>PROFIL SISWA</span>
            </div>
            <h3 class="text-xl font-extrabold text-slate-900 tracking-tight">{{ $siswa->nama_siswa }}</h3>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">NIS: {{ $siswa->nis }} &bull; Rombel: {{ $siswa->kelas?->nama_kelas ?? 'Belum ada kelas' }}</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('siswa.index') }}" class="px-4 py-2 text-xs font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors shadow-xs">
                &larr; Kembali
            </a>
            <a href="{{ route('siswa.edit', $siswa) }}" class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 transition-colors shadow-xs">
                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Data
            </a>
        </div>
    </div>

    <!-- Main Profile Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Column 1: Info Card -->
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 text-center">
                <div class="w-24 h-24 mx-auto rounded-2xl flex items-center justify-center font-bold text-2xl shadow-inner border-2 {{ $siswa->jenis_kelamin === 'L' ? 'bg-sky-50 text-sky-700 border-sky-200' : 'bg-rose-50 text-rose-700 border-rose-200' }}">
                    {{ mb_substr($siswa->nama_siswa, 0, 2) }}
                </div>
                <h4 class="text-base font-bold text-slate-900 mt-4">{{ $siswa->nama_siswa }}</h4>
                <p class="text-xs text-slate-500 font-mono">NIS: {{ $siswa->nis }}</p>

                <div class="mt-4 flex items-center justify-center gap-2">
                    @if ($siswa->status_aktif)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Aktif Terdaftar
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                            Non-Aktif
                        </span>
                    @endif
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $siswa->jenis_kelamin === 'L' ? 'bg-sky-100 text-sky-800' : 'bg-rose-100 text-rose-800' }}">
                        {{ $siswa->jenis_kelamin === 'L' ? 'Ikhwan' : 'Akhwat' }}
                    </span>
                </div>

                <div class="mt-6 pt-6 border-t border-slate-100 text-left space-y-3 text-xs">
                    <div>
                        <span class="text-slate-400 block uppercase tracking-wider text-[10px] font-bold">Rombongan Belajar</span>
                        <span class="font-semibold text-slate-800 text-sm">Kelas {{ $siswa->kelas?->nama_kelas ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block uppercase tracking-wider text-[10px] font-bold">Wali Kelas</span>
                        <span class="font-semibold text-slate-800">{{ $siswa->kelas?->waliKelas?->nama_guru ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block uppercase tracking-wider text-[10px] font-bold">NISN</span>
                        <span class="font-semibold text-slate-800 font-mono">{{ $siswa->nisn ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block uppercase tracking-wider text-[10px] font-bold">Nama Orang Tua / Wali</span>
                        <span class="font-semibold text-slate-800">{{ $siswa->nama_wali ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block uppercase tracking-wider text-[10px] font-bold">Kontak Wali</span>
                        <span class="font-semibold text-slate-800 font-mono">{{ $siswa->no_hp_wali ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block uppercase tracking-wider text-[10px] font-bold">Alamat</span>
                        <span class="text-slate-700">{{ $siswa->alamat ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Column 2 & 3: Integrasi Data ERP (SPP, Absensi, Nilai) -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Card Tagihan SPP Terintegrasi -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900">Riwayat Tagihan & Pembayaran SPP</h4>
                            <p class="text-xs text-slate-500">Catatan pembayaran SPP siswa terhubung</p>
                        </div>
                    </div>
                </div>

                <div class="mt-4 overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="text-slate-400 uppercase font-semibold text-[10px] border-b border-slate-100">
                            <tr>
                                <th class="py-2">Periode</th>
                                <th class="py-2">Nominal</th>
                                <th class="py-2 text-center">Status</th>
                                <th class="py-2">Tanggal Bayar</th>
                                <th class="py-2">Metode</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 font-medium text-slate-700">
                            @forelse ($siswa->keuanganSpps as $spp)
                                <tr>
                                    <td class="py-3 font-semibold">{{ $spp->bulan }} {{ $spp->tahun }}</td>
                                    <td class="py-3 font-mono">Rp {{ number_format($spp->nominal, 0, ',', '.') }}</td>
                                    <td class="py-3 text-center">
                                        @if ($spp->status_bayar === 'lunas')
                                            <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Lunas</span>
                                        @else
                                            <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">Belum Lunas</span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-slate-500">{{ $spp->tanggal_bayar?->format('d/m/Y') ?? '-' }}</td>
                                    <td class="py-3">{{ $spp->metode_bayar ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-slate-400">Belum ada catatan tagihan SPP untuk siswa ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Card Riwayat Absensi Terkini -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900">Catatan Presensi Terkini</h4>
                            <p class="text-xs text-slate-500">10 riwayat kehadiran harian terakhir</p>
                        </div>
                    </div>
                </div>

                <div class="mt-4 overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="text-slate-400 uppercase font-semibold text-[10px] border-b border-slate-100">
                            <tr>
                                <th class="py-2">Tanggal</th>
                                <th class="py-2 text-center">Status Kehadiran</th>
                                <th class="py-2">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 font-medium text-slate-700">
                            @forelse ($siswa->absensis as $absensi)
                                <tr>
                                    <td class="py-2.5 font-mono">{{ $absensi->tanggal->format('d/m/Y') }}</td>
                                    <td class="py-2.5 text-center">
                                        @if ($absensi->status === 'H')
                                            <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Hadir</span>
                                        @elseif ($absensi->status === 'I')
                                            <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">Izin</span>
                                        @elseif ($absensi->status === 'S')
                                            <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">Sakit</span>
                                        @else
                                            <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">Alpa</span>
                                        @endif
                                    </td>
                                    <td class="py-2.5 text-slate-500">{{ $absensi->keterangan ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-6 text-center text-slate-400">Belum ada riwayat absensi untuk siswa ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection

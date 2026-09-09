@extends('layouts.app')

@section('title', 'Rekap Presensi Bulanan')
@section('page_title', 'Rekapitulasi Kehadiran Siswa')

@section('content')
<div class="space-y-6">

    <!-- Header Breadcrumb & Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-emerald-700 mb-1">
                <a href="{{ route('absensi.index') }}" class="hover:underline">PRESENSI SISWA</a>
                <span>/</span>
                <span>REKAPITULASI BULANAN</span>
            </div>
            <h3 class="text-xl font-extrabold text-slate-900 tracking-tight">Rekapitulasi Kehadiran Kelas</h3>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Persentase dan akumulasi kehadiran siswa per bulan untuk evaluasi kedisiplinan dan laporan wali murid.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('absensi.index', ['kelas_id' => $kelasId]) }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors shadow-xs">
                &larr; Kembali ke Form Grid
            </a>
            <button onclick="window.print()" class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold text-white bg-slate-800 hover:bg-slate-900 transition-colors shadow-xs">
                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Rekap
            </button>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <form action="{{ route('absensi.rekap') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
            <div class="sm:col-span-5">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Pilih Kelas</label>
                <select name="kelas_id" required class="w-full py-2.5 px-3.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    @foreach ($kelasList as $k)
                        <option value="{{ $k->id }}" {{ (string) $kelasId === (string) $k->id ? 'selected' : '' }}>
                            Kelas {{ $k->nama_kelas }} (Wali: {{ $k->waliKelas?->nama_guru ?? '-' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-3">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Bulan</label>
                <select name="bulan" class="w-full py-2.5 px-3.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    @for ($m = 1; $m <= 12; $m++)
                        @php $bulanNama = \Carbon\Carbon::create(null, $m, 1)->translatedFormat('F'); @endphp
                        <option value="{{ $m }}" {{ $bulan === $m ? 'selected' : '' }}>{{ $bulanNama }}</option>
                    @endfor
                </select>
            </div>

            <div class="sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Tahun</label>
                <input type="number" name="tahun" value="{{ $tahun }}" min="2020" max="2035" class="w-full py-2.5 px-3.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
            </div>

            <div class="sm:col-span-2">
                <button type="submit" class="w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-xs">
                    Tampilkan Rekap
                </button>
            </div>
        </form>
    </div>

    <!-- Table Container -->
    @if ($selectedKelas)
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="p-5 bg-slate-50/80 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h4 class="font-bold text-slate-900">
                        Rekapitulasi Presensi: Kelas {{ $selectedKelas->nama_kelas }}
                    </h4>
                    <p class="text-xs text-slate-500">
                        Periode: <strong>{{ \Carbon\Carbon::create(null, $bulan, 1)->translatedFormat('F') }} {{ $tahun }}</strong> &bull; Wali Kelas: <strong>{{ $selectedKelas->waliKelas?->nama_guru ?? '-' }}</strong>
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-700">
                    <thead class="bg-slate-100/70 text-slate-600 font-semibold border-b border-slate-200 uppercase text-[11px] tracking-wider">
                        <tr>
                            <th scope="col" class="py-3 px-4 text-center w-12">No</th>
                            <th scope="col" class="py-3 px-4">Nama Siswa</th>
                            <th scope="col" class="py-3 px-4">NIS</th>
                            <th scope="col" class="py-3 px-4 text-center text-emerald-700 bg-emerald-50/50">Hadir (H)</th>
                            <th scope="col" class="py-3 px-4 text-center text-blue-700 bg-blue-50/50">Izin (I)</th>
                            <th scope="col" class="py-3 px-4 text-center text-amber-700 bg-amber-50/50">Sakit (S)</th>
                            <th scope="col" class="py-3 px-4 text-center text-rose-700 bg-rose-50/50">Alpa (A)</th>
                            <th scope="col" class="py-3 px-4 text-center">Total Hari</th>
                            <th scope="col" class="py-3 px-4 text-center w-36">Kehadiran (%)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-normal">
                        @forelse ($siswas as $idx => $siswa)
                            @php
                                $r = $rekapBulanan[$siswa->id] ?? ['hadir' => 0, 'izin' => 0, 'sakit' => 0, 'alpa' => 0, 'total' => 0, 'persentase' => 0];
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3 px-4 text-center text-xs text-slate-400 font-mono">{{ $idx + 1 }}</td>
                                <td class="py-3 px-4 font-bold text-slate-900">{{ $siswa->nama_siswa }}</td>
                                <td class="py-3 px-4 text-xs font-mono text-slate-500">{{ $siswa->nis }}</td>
                                <td class="py-3 px-4 text-center font-bold text-emerald-600 bg-emerald-50/30">{{ $r['hadir'] }}</td>
                                <td class="py-3 px-4 text-center font-bold text-blue-600 bg-blue-50/30">{{ $r['izin'] }}</td>
                                <td class="py-3 px-4 text-center font-bold text-amber-600 bg-amber-50/30">{{ $r['sakit'] }}</td>
                                <td class="py-3 px-4 text-center font-bold text-rose-600 bg-rose-50/30">{{ $r['alpa'] }}</td>
                                <td class="py-3 px-4 text-center font-bold text-slate-800">{{ $r['total'] }}</td>
                                <td class="py-3 px-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-extrabold {{ $r['persentase'] >= 85 ? 'bg-emerald-100 text-emerald-800' : ($r['persentase'] >= 70 ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800') }}">
                                        {{ $r['persentase'] }}%
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="py-8 text-center text-slate-400">Tidak ada siswa aktif di kelas ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>
@endsection

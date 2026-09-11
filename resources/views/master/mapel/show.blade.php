@extends('layouts.app')

@section('title', 'Detail Mapel - ' . $mapel->nama_mapel)
@section('page_title', 'Rincian Mata Pelajaran & Kurikulum')

@section('content')
<div class="space-y-6">

    <!-- Header Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-emerald-700 mb-1">
                <a href="{{ route('mapel.index') }}" class="hover:underline">MATA PELAJARAN</a>
                <span>/</span>
                <span>DETAIL MAPEL</span>
            </div>
            <h3 class="text-xl font-extrabold text-slate-900 tracking-tight">{{ $mapel->nama_mapel }}</h3>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Kode: <span class="font-mono font-bold">{{ $mapel->kode_mapel }}</span> &bull; Standar Kelulusan KKM: <span class="font-bold text-teal-600">{{ $mapel->kkm }}</span></p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('mapel.index') }}" class="px-4 py-2 text-xs font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors shadow-xs">
                &larr; Kembali
            </a>
            <a href="{{ route('mapel.edit', $mapel) }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 rounded-xl shadow-xs transition-colors">
                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Mapel
            </a>
            <a href="{{ route('akademik.index') }}?mapel_id={{ $mapel->id }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-xs transition-colors">
                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Input Nilai e-Rapor
            </a>
        </div>
    </div>

    <!-- 3 Cards: Info, Guru, Nilai Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <!-- Card 1: Identitas Mapel -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kode & KKM</p>
            <div class="flex items-center justify-between mt-2">
                <span class="text-2xl font-mono font-extrabold text-purple-700">{{ $mapel->kode_mapel }}</span>
                <span class="text-xs font-bold px-3 py-1 bg-teal-50 text-teal-700 border border-teal-200 rounded-full">
                    KKM: {{ $mapel->kkm }}
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-2">{{ $mapel->nama_mapel }}</p>
        </div>

        <!-- Card 2: Guru Pengampu -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Guru Pengampu</p>
            @if ($mapel->guru)
                <h4 class="text-base font-bold text-slate-900 mt-1.5">{{ $mapel->guru->nama_guru }}</h4>
                <p class="text-xs text-slate-500 mt-0.5">NIP: {{ $mapel->guru->nip ?? '-' }}</p>
                <a href="{{ route('guru.show', $mapel->guru) }}" class="inline-block mt-2 text-xs font-semibold text-emerald-600 hover:text-emerald-700">
                    Lihat Profil Guru &rarr;
                </a>
            @else
                <h4 class="text-base font-bold text-slate-400 mt-1.5 italic">Belum Ditentukan</h4>
                <p class="text-xs text-slate-400 mt-0.5">Silakan tetapkan guru pada menu edit.</p>
            @endif
        </div>

        <!-- Card 3: Riwayat Penilaian -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Entri Penilaian</p>
            <h4 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $mapel->akademikNilais->count() }}</h4>
            <p class="text-xs text-slate-500 mt-0.5">Data nilai siswa yang telah diinput</p>
        </div>
    </div>

    <!-- Riwayat Nilai Terakhir Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h4 class="text-base font-bold text-slate-900">Riwayat Penilaian Nilai Siswa</h4>
                <p class="text-xs text-slate-500">Nilai tugas, UTS, UAS, dan capaian kompetensi yang telah diisi</p>
            </div>
            <span class="text-xs font-bold px-3 py-1 bg-slate-100 rounded-full text-slate-700">
                {{ $mapel->akademikNilais->count() }} Entri Nilai
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50/80 border-b border-slate-200 text-xs font-bold text-slate-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Siswa</th>
                        <th class="px-6 py-4">Kelas</th>
                        <th class="px-6 py-4">Tugas</th>
                        <th class="px-6 py-4">UTS</th>
                        <th class="px-6 py-4">UAS</th>
                        <th class="px-6 py-4">Nilai Akhir</th>
                        <th class="px-6 py-4">Capaian</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse ($mapel->akademikNilais as $idx => $nilai)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4 font-mono text-slate-400">{{ $idx + 1 }}</td>
                            <td class="px-6 py-4 font-bold text-slate-900">
                                {{ $nilai->siswa?->nama_siswa ?? 'Siswa' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $nilai->siswa?->kelas?->nama_kelas ?? '-' }}
                            </td>
                            <td class="px-6 py-4">{{ $nilai->nilai_tugas ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $nilai->nilai_uts ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $nilai->nilai_uas ?? '-' }}</td>
                            <td class="px-6 py-4 font-bold {{ $nilai->nilai_akhir >= $mapel->kkm ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $nilai->nilai_akhir ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-slate-500 max-w-xs truncate">
                                {{ $nilai->capaian_kompetensi ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-slate-400">
                                Belum ada nilai yang diinput untuk mata pelajaran ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

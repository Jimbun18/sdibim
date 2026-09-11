@extends('layouts.app')

@section('title', 'Detail Kelas ' . $kelas->nama_kelas)
@section('page_title', 'Rincian Rombongan Belajar (Kelas)')

@section('content')
<div class="space-y-6">

    <!-- Header Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-emerald-700 mb-1">
                <a href="{{ route('kelas.index') }}" class="hover:underline">DATA KELAS</a>
                <span>/</span>
                <span>DETAIL ROMBEL</span>
            </div>
            <h3 class="text-xl font-extrabold text-slate-900 tracking-tight">Rombongan Belajar: Kelas {{ $kelas->nama_kelas }}</h3>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Tingkat {{ $kelas->tingkat }} &bull; Wali Kelas: {{ $kelas->waliKelas?->nama_guru ?? 'Belum Ada' }}</p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('kelas.index') }}" class="px-4 py-2 text-xs font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors shadow-xs">
                &larr; Kembali
            </a>
            <a href="{{ route('kelas.edit', $kelas) }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 rounded-xl shadow-xs transition-colors">
                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Kelas
            </a>
            <a href="{{ route('siswa.create') }}?kelas_id={{ $kelas->id }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-xs transition-colors">
                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Siswa
            </a>
        </div>
    </div>

    <!-- Quick Stat Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <!-- Card 1: Total Siswa -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Siswa</p>
            <h4 class="text-2xl font-bold text-slate-900 mt-1">{{ $kelas->siswas->count() }}</h4>
            <p class="text-xs text-slate-400 mt-0.5">Siswa Terdaftar</p>
        </div>

        <!-- Card 2: Ikhwan -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Ikhwan (L)</p>
            <h4 class="text-2xl font-bold text-sky-600 mt-1">{{ $kelas->siswas->where('jenis_kelamin', 'L')->count() }}</h4>
            <p class="text-xs text-slate-400 mt-0.5">Laki-Laki</p>
        </div>

        <!-- Card 3: Akhwat -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Akhwat (P)</p>
            <h4 class="text-2xl font-bold text-rose-600 mt-1">{{ $kelas->siswas->where('jenis_kelamin', 'P')->count() }}</h4>
            <p class="text-xs text-slate-400 mt-0.5">Perempuan</p>
        </div>

        <!-- Card 4: Siswa Aktif -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Status Aktif</p>
            <h4 class="text-2xl font-bold text-emerald-600 mt-1">{{ $kelas->siswas->where('status_aktif', true)->count() }}</h4>
            <p class="text-xs text-slate-400 mt-0.5">Peserta Aktif</p>
        </div>
    </div>

    <!-- Wali Kelas Banner -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-700 text-white font-extrabold text-base flex items-center justify-center shrink-0 shadow-xs">
                {{ $kelas->waliKelas ? strtoupper(substr($kelas->waliKelas->nama_guru, 0, 2)) : '?' }}
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Wali Kelas Pengampu</p>
                <h4 class="text-base font-bold text-slate-900">
                    {{ $kelas->waliKelas?->nama_guru ?? 'Belum Ditentukan' }}
                </h4>
                <p class="text-xs text-slate-500 font-mono">
                    NIP: {{ $kelas->waliKelas?->nip ?? '-' }} &bull; HP: {{ $kelas->waliKelas?->no_hp ?? '-' }}
                </p>
            </div>
        </div>
        @if ($kelas->waliKelas)
            <a href="{{ route('guru.show', $kelas->waliKelas) }}" class="inline-flex items-center text-xs font-bold text-emerald-600 hover:text-emerald-700">
                Lihat Profil Guru &rarr;
            </a>
        @endif
    </div>

    <!-- Siswa Table in This Kelas -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h4 class="text-base font-bold text-slate-900">Daftar Peserta Didik Kelas {{ $kelas->nama_kelas }}</h4>
                <p class="text-xs text-slate-500">Anggota siswa aktif pada rombongan belajar ini</p>
            </div>
            <span class="text-xs font-bold px-3 py-1 bg-slate-100 rounded-full text-slate-700">
                {{ $kelas->siswas->count() }} Terdaftar
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50/80 border-b border-slate-200 text-xs font-bold text-slate-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">NIS / NISN</th>
                        <th class="px-6 py-4">Nama Lengkap Siswa</th>
                        <th class="px-6 py-4">Jenis Kelamin</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($kelas->siswas as $idx => $siswa)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4 font-mono text-xs text-slate-400">{{ $idx + 1 }}</td>
                            <td class="px-6 py-4 font-mono text-xs">
                                <p class="font-bold text-slate-800">{{ $siswa->nis }}</p>
                                <p class="text-slate-400">NISN: {{ $siswa->nisn ?? '-' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('siswa.show', $siswa) }}" class="font-bold text-slate-900 hover:text-emerald-700 transition-colors">
                                    {{ $siswa->nama_siswa }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $siswa->jenis_kelamin === 'L' ? 'bg-sky-50 text-sky-700' : 'bg-rose-50 text-rose-700' }}">
                                    {{ $siswa->jenis_kelamin === 'L' ? 'Ikhwan (L)' : 'Akhwat (P)' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($siswa->status_aktif)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500">
                                        Non-Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('siswa.show', $siswa) }}" class="p-2 rounded-lg text-slate-500 hover:text-emerald-700 hover:bg-emerald-50 transition-colors" title="Lihat Profil Siswa">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <a href="{{ route('siswa.edit', $siswa) }}" class="p-2 rounded-lg text-slate-500 hover:text-amber-700 hover:bg-amber-50 transition-colors" title="Edit Siswa">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                Belum ada data siswa yang ditempatkan di kelas ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

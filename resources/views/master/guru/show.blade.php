@extends('layouts.app')

@section('title', 'Profil Guru - ' . $guru->nama_guru)
@section('page_title', 'Detail Informasi Guru')

@section('content')
<div class="space-y-6">

    <!-- Header Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-emerald-700 mb-1">
                <a href="{{ route('guru.index') }}" class="hover:underline">DATA GURU</a>
                <span>/</span>
                <span>PROFIL GURU</span>
            </div>
            <h3 class="text-xl font-extrabold text-slate-900 tracking-tight">{{ $guru->nama_guru }}</h3>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Informasi profil pendidik, penugasan wali kelas, dan mata pelajaran yang diampu.</p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('guru.index') }}" class="px-4 py-2 text-xs font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors shadow-xs">
                &larr; Kembali
            </a>
            <a href="{{ route('guru.edit', $guru) }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 rounded-xl shadow-xs transition-colors">
                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Data
            </a>
        </div>
    </div>

    <!-- Main Grid: Profil Guru & Penugasan -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left Column: Identity & Contact Card -->
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 text-center">
                <div class="w-24 h-24 mx-auto rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-700 text-white font-extrabold text-2xl flex items-center justify-center shadow-lg shadow-emerald-900/20 mb-4">
                    {{ strtoupper(substr($guru->nama_guru, 0, 2)) }}
                </div>
                <h4 class="text-lg font-bold text-slate-900">{{ $guru->nama_guru }}</h4>
                <p class="text-xs text-slate-400 font-mono mt-0.5">NIP: {{ $guru->nip ?? '-' }}</p>
                <div class="mt-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        {{ $guru->jabatan ?? 'Guru Pendidik' }}
                    </span>
                </div>

                <div class="mt-6 pt-6 border-t border-slate-100 text-left space-y-3 text-xs">
                    <div>
                        <span class="text-slate-400 block mb-0.5">Nomor Telepon / WhatsApp:</span>
                        <span class="font-bold text-slate-800">{{ $guru->no_hp ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5">Alamat Email:</span>
                        <span class="font-bold text-slate-800">{{ $guru->email ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5">Alamat Domisili:</span>
                        <span class="font-medium text-slate-700">{{ $guru->alamat ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Mata Pelajaran yang Diampu -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6">
                <h4 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Mata Pelajaran yang Diampu
                </h4>
                @if ($guru->mapels && $guru->mapels->count() > 0)
                    <div class="space-y-2">
                        @foreach ($guru->mapels as $mapel)
                            <div class="p-3 rounded-xl bg-purple-50/60 border border-purple-100 flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-bold text-purple-900">{{ $mapel->nama_mapel }}</p>
                                    <p class="text-[11px] text-purple-600 font-mono">Kode: {{ $mapel->kode_mapel }}</p>
                                </div>
                                <span class="text-xs font-bold text-purple-700 bg-white px-2 py-0.5 rounded-md border border-purple-200">
                                    KKM: {{ $mapel->kkm }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-slate-400 italic">Belum ada mata pelajaran yang ditugaskan kepada guru ini.</p>
                @endif
            </div>
        </div>

        <!-- Right Column: Kelas Wali & Siswa Binaan -->
        <div class="lg:col-span-2 space-y-6">
            @if ($guru->kelasWali)
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-extrabold text-sm">
                                {{ $guru->kelasWali->nama_kelas }}
                            </div>
                            <div>
                                <h4 class="text-base font-bold text-slate-900">Wali Kelas {{ $guru->kelasWali->nama_kelas }}</h4>
                                <p class="text-xs text-slate-500">Tingkat {{ $guru->kelasWali->tingkat }} &bull; {{ $guru->kelasWali->siswas->count() }} Siswa Terdaftar</p>
                            </div>
                        </div>
                        <a href="{{ route('kelas.show', $guru->kelasWali) }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700">
                            Buka Detail Kelas &rarr;
                        </a>
                    </div>

                    <!-- Siswa Binaan Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-600">
                            <thead class="bg-slate-50/80 border-b border-slate-200 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                <tr>
                                    <th class="px-6 py-3">No</th>
                                    <th class="px-6 py-3">NIS</th>
                                    <th class="px-6 py-3">Nama Siswa</th>
                                    <th class="px-6 py-3">L/P</th>
                                    <th class="px-6 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs">
                                @forelse ($guru->kelasWali->siswas as $idx => $siswa)
                                    <tr class="hover:bg-slate-50/80 transition-colors">
                                        <td class="px-6 py-3 font-mono text-slate-400">{{ $idx + 1 }}</td>
                                        <td class="px-6 py-3 font-mono font-medium text-slate-700">{{ $siswa->nis }}</td>
                                        <td class="px-6 py-3 font-bold text-slate-900">
                                            <a href="{{ route('siswa.show', $siswa) }}" class="hover:text-emerald-700">
                                                {{ $siswa->nama_siswa }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-3">
                                            <span class="font-bold {{ $siswa->jenis_kelamin === 'L' ? 'text-sky-600' : 'text-rose-500' }}">
                                                {{ $siswa->jenis_kelamin }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-3">
                                            @if ($siswa->status_aktif)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700">
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500">
                                                    Non-Aktif
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-slate-400">
                                            Belum ada data siswa di kelas ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-8 text-center">
                    <div class="w-14 h-14 mx-auto rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mb-3">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h4 class="text-base font-bold text-slate-800">Tidak Mengampu Sebagai Wali Kelas</h4>
                    <p class="text-xs text-slate-400 max-w-sm mx-auto mt-1">
                        Guru ini saat ini belum ditugaskan sebagai wali kelas pada rombongan belajar manapun.
                    </p>
                </div>
            @endif
        </div>

    </div>

</div>
@endsection

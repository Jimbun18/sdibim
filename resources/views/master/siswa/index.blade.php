@extends('layouts.app')

@section('title', 'Data Siswa')
@section('page_title', 'Master Data Siswa')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-emerald-700 mb-1">
                <span>MASTER DATA</span>
                <span>/</span>
                <span>DATA SISWA</span>
            </div>
            <h3 class="text-xl font-extrabold text-slate-900 tracking-tight">Daftar Siswa SD Islam Bina Insan Mandiri</h3>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Kelola data induk siswa, riwayat kelas, status keaktifan, dan profil peserta didik.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('siswa.create') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-700/20 transition-all transform active:scale-95">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Siswa Baru
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Total Siswa -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Siswa</p>
                <h4 class="text-2xl font-bold text-slate-900 mt-0.5">{{ $stats['total'] ?? $siswas->total() }}</h4>
            </div>
        </div>

        <!-- Card 2: Siswa Aktif -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center shrink-0 border border-teal-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Status Aktif</p>
                <h4 class="text-2xl font-bold text-emerald-600 mt-0.5">{{ $stats['aktif'] ?? 0 }}</h4>
            </div>
        </div>

        <!-- Card 3: Ikhwan (Laki-laki) -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0 border border-sky-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Ikhwan (L)</p>
                <h4 class="text-2xl font-bold text-sky-600 mt-0.5">{{ $stats['laki'] ?? 0 }}</h4>
            </div>
        </div>

        <!-- Card 4: Akhwat (Perempuan) -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0 border border-rose-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Akhwat (P)</p>
                <h4 class="text-2xl font-bold text-rose-600 mt-0.5">{{ $stats['perempuan'] ?? 0 }}</h4>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <form action="{{ route('siswa.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
            <!-- Search Bar Input -->
            <div class="md:col-span-5 relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama siswa, NIS, atau NISN..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
            </div>

            <!-- Filter Kelas -->
            <div class="md:col-span-3">
                <select name="kelas_id" class="w-full py-2.5 px-3.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    <option value="">-- Semua Rombel Kelas --</option>
                    @foreach ($kelasList as $itemKelas)
                        <option value="{{ $itemKelas->id }}" {{ (string) $kelasId === (string) $itemKelas->id ? 'selected' : '' }}>
                            Kelas {{ $itemKelas->nama_kelas }} (Tingkat {{ $itemKelas->tingkat }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Status -->
            <div class="md:col-span-2">
                <select name="status_aktif" class="w-full py-2.5 px-3.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    <option value="">-- Semua Status --</option>
                    <option value="1" {{ $statusAktif === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ $statusAktif === '0' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="md:col-span-2 flex items-center gap-2">
                <button type="submit" class="flex-1 py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition-colors flex items-center justify-center gap-1.5 shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    Filter
                </button>
                @if ($search || $kelasId || $statusAktif !== null)
                    <a href="{{ route('siswa.index') }}" class="p-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl transition-colors" title="Reset Filter">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Data Table Container -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50/90 text-slate-600 font-semibold border-b border-slate-200 uppercase text-[11px] tracking-wider">
                    <tr>
                        <th scope="col" class="py-3.5 px-4 text-center w-12">No</th>
                        <th scope="col" class="py-3.5 px-4">Nama Siswa & NIS</th>
                        <th scope="col" class="py-3.5 px-4">Kelas & Wali</th>
                        <th scope="col" class="py-3.5 px-4 text-center">Gender</th>
                        <th scope="col" class="py-3.5 px-4 text-center">Status</th>
                        <th scope="col" class="py-3.5 px-4">Kontak Wali</th>
                        <th scope="col" class="py-3.5 px-4 text-center w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-normal">
                    @forelse ($siswas as $index => $siswa)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- Index -->
                            <td class="py-4 px-4 text-center text-xs text-slate-400 font-mono">
                                {{ $siswas->firstItem() + $index }}
                            </td>

                            <!-- Profil Siswa -->
                            <td class="py-4 px-4">
                                <div class="flex items-center space-x-3">
                                    <!-- Avatar Inisial -->
                                    <div class="w-10 h-10 rounded-full shrink-0 flex items-center justify-center font-bold text-xs shadow-xs border {{ $siswa->jenis_kelamin === 'L' ? 'bg-sky-50 text-sky-700 border-sky-200' : 'bg-rose-50 text-rose-700 border-rose-200' }}">
                                        {{ mb_substr($siswa->nama_siswa, 0, 2) }}
                                    </div>
                                    <div>
                                        <a href="{{ route('siswa.show', $siswa) }}" class="font-bold text-slate-900 hover:text-emerald-600 transition-colors">
                                            {{ $siswa->nama_siswa }}
                                        </a>
                                        <div class="flex items-center gap-2 mt-0.5 text-xs text-slate-500 font-mono">
                                            <span>NIS: <span class="font-medium text-slate-700">{{ $siswa->nis }}</span></span>
                                            @if ($siswa->nisn)
                                                <span>&bull;</span>
                                                <span>NISN: {{ $siswa->nisn }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Kelas & Wali Kelas (Eager Loaded) -->
                            <td class="py-4 px-4">
                                <div class="space-y-0.5">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200/80">
                                        {{ $siswa->kelas?->nama_kelas ?? 'Belum ada kelas' }}
                                    </span>
                                    <p class="text-xs text-slate-500 truncate max-w-xs flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        Wali: {{ $siswa->kelas?->waliKelas?->nama_guru ?? '-' }}
                                    </p>
                                </div>
                            </td>

                            <!-- Gender -->
                            <td class="py-4 px-4 text-center">
                                @if ($siswa->jenis_kelamin === 'L')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-sky-50 text-sky-700 border border-sky-200">
                                        Ikhwan (L)
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-200">
                                        Akhwat (P)
                                    </span>
                                @endif
                            </td>

                            <!-- Status Keaktifan -->
                            <td class="py-4 px-4 text-center">
                                @if ($siswa->status_aktif)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100/80 text-emerald-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                                        Non-Aktif
                                    </span>
                                @endif
                            </td>

                            <!-- Wali & No HP -->
                            <td class="py-4 px-4">
                                <div class="text-xs">
                                    <p class="font-medium text-slate-900">{{ $siswa->nama_wali ?? '-' }}</p>
                                    <p class="text-slate-500 font-mono mt-0.5">{{ $siswa->no_hp_wali ?? '-' }}</p>
                                </div>
                            </td>

                            <!-- Aksi -->
                            <td class="py-4 px-4 text-center">
                                <div class="inline-flex items-center justify-center gap-1 bg-slate-100/70 p-1 rounded-xl border border-slate-200">
                                    <!-- Detail -->
                                    <a href="{{ route('siswa.show', $siswa) }}" class="p-1.5 text-slate-600 hover:text-emerald-600 hover:bg-white rounded-lg transition-all" title="Lihat Profil">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('siswa.edit', $siswa) }}" class="p-1.5 text-slate-600 hover:text-amber-600 hover:bg-white rounded-lg transition-all" title="Edit Siswa">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>

                                    <!-- Delete with Confirmation -->
                                    <form action="{{ route('siswa.destroy', $siswa) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa {{ $siswa->nama_siswa }}? Seluruh data tagihan dan absensi terkait juga akan terhapus.');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-600 hover:text-rose-600 hover:bg-white rounded-lg transition-all" title="Hapus Siswa">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 px-4 text-center">
                                <div class="max-w-sm mx-auto space-y-3">
                                    <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mx-auto text-slate-400">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                    </div>
                                    <h5 class="text-base font-bold text-slate-800">Tidak ada data siswa</h5>
                                    <p class="text-xs text-slate-500">Data siswa tidak ditemukan untuk kata kunci atau filter yang Anda pilih.</p>
                                    <a href="{{ route('siswa.create') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold text-emerald-700 bg-emerald-50 rounded-xl hover:bg-emerald-100 transition-colors">
                                        + Daftarkan Siswa Baru
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Bar -->
        @if ($siswas->hasPages())
            <div class="px-6 py-4 bg-slate-50/80 border-t border-slate-200">
                {{ $siswas->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

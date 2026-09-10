@extends('layouts.app')

@section('title', 'e-Rapor & Input Nilai Siswa')
@section('page_title', 'Modul Akademik (e-Rapor)')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-emerald-700 mb-1">
                <span>AKADEMIK</span>
                <span>/</span>
                <span>E-RAPOR & PENILAIAN</span>
            </div>
            <h3 class="text-xl font-extrabold text-slate-900 tracking-tight">Lembar Penilaian Siswa (e-Rapor Grid)</h3>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                Input nilai harian (Tugas, UTS, UAS) berbasis spreadsheet. Nilai akhir dihitung otomatis berdasarkan pembobotan resmi.
            </p>
        </div>
        <div class="flex items-center gap-2 self-start sm:self-auto">
            <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                <svg class="w-4 h-4 mr-1.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Bobot: 30% Tugas + 30% UTS + 40% UAS
            </span>
        </div>
    </div>

    <!-- Filter Kelas, Mapel, Semester & Tahun Ajaran -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <form action="{{ route('akademik.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-end">
            <!-- Pilihan Kelas -->
            <div class="lg:col-span-3">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Rombel Kelas <span class="text-rose-500">*</span></label>
                <select name="kelas_id" required class="w-full py-2.5 px-3.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    @forelse ($kelasList as $k)
                        <option value="{{ $k->id }}" {{ (string) $kelasId === (string) $k->id ? 'selected' : '' }}>
                            Kelas {{ $k->nama_kelas }} (Tk. {{ $k->tingkat }})
                        </option>
                    @empty
                        <option value="">Belum ada kelas terdaftar</option>
                    @endforelse
                </select>
            </div>

            <!-- Pilihan Mata Pelajaran -->
            <div class="lg:col-span-3">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Mata Pelajaran <span class="text-rose-500">*</span></label>
                <select name="mapel_id" required class="w-full py-2.5 px-3.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    @forelse ($mapelList as $m)
                        <option value="{{ $m->id }}" {{ (string) $mapelId === (string) $m->id ? 'selected' : '' }}>
                            {{ $m->nama_mapel }} (KKM: {{ $m->kkm }})
                        </option>
                    @empty
                        <option value="">Belum ada mata pelajaran</option>
                    @endforelse
                </select>
            </div>

            <!-- Pilihan Semester -->
            <div class="lg:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Semester <span class="text-rose-500">*</span></label>
                <select name="semester" required class="w-full py-2.5 px-3.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    <option value="1" {{ (string) $semester === '1' ? 'selected' : '' }}>Semester 1 (Ganjil)</option>
                    <option value="2" {{ (string) $semester === '2' ? 'selected' : '' }}>Semester 2 (Genap)</option>
                </select>
            </div>

            <!-- Pilihan Tahun Ajaran -->
            <div class="lg:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Tahun Ajaran <span class="text-rose-500">*</span></label>
                <select name="tahun_ajaran" required class="w-full py-2.5 px-3.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    <option value="2025/2026" {{ $tahunAjaran === '2025/2026' ? 'selected' : '' }}>2025/2026</option>
                    <option value="2026/2027" {{ $tahunAjaran === '2026/2027' ? 'selected' : '' }}>2026/2027</option>
                    <option value="2027/2028" {{ $tahunAjaran === '2027/2028' ? 'selected' : '' }}>2027/2028</option>
                </select>
            </div>

            <!-- Tombol Buka Lembar Nilai -->
            <div class="lg:col-span-2">
                <button type="submit" class="w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition-colors flex items-center justify-center gap-2 shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Buka Nilai
                </button>
            </div>
        </form>
    </div>

    @if ($errors->any())
        <div class="rounded-xl bg-rose-50 border border-rose-200 p-4 text-rose-800">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h5 class="font-bold text-sm">Gagal Menyimpan Nilai</h5>
                    <ul class="list-disc list-inside text-xs mt-1 space-y-0.5">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if ($selectedKelas && $selectedMapel)
        @php
            $kkm = $selectedMapel->kkm ?? 75;
            $gradedList = $existingNilai->whereNotNull('nilai_akhir');
            $totalGraded = $gradedList->count();
            $avgScore = $totalGraded > 0 ? round($gradedList->avg('nilai_akhir'), 1) : 0;
            $tuntasCount = $gradedList->where('nilai_akhir', '>=', $kkm)->count();
            $belumTuntasCount = $totalGraded - $tuntasCount;
            $persenTuntas = $totalGraded > 0 ? round(($tuntasCount / $totalGraded) * 100) : 0;
        @endphp

        <!-- Statistik Nilai Akademik Kelas -->
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-3">
            <div class="bg-white p-4 rounded-xl border border-slate-200/80 shadow-xs">
                <span class="text-[11px] font-bold text-slate-500 uppercase">Total Siswa</span>
                <div class="flex items-baseline justify-between mt-1">
                    <h5 class="text-2xl font-black text-slate-900">{{ $siswas->count() }}</h5>
                    <span class="text-xs text-slate-400 font-medium">Siswa Aktif</span>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl border border-blue-100 shadow-xs">
                <span class="text-[11px] font-bold text-blue-700 uppercase">KKM Mapel</span>
                <div class="flex items-baseline justify-between mt-1">
                    <h5 class="text-2xl font-black text-blue-600">{{ $kkm }}</h5>
                    <span class="text-xs text-blue-600/80 font-medium">Batas Lulus</span>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl border border-emerald-100 shadow-xs">
                <span class="text-[11px] font-bold text-emerald-700 uppercase">Rata-Rata Nilai</span>
                <div class="flex items-baseline justify-between mt-1">
                    <h5 class="text-2xl font-black text-emerald-600">{{ $avgScore > 0 ? $avgScore : '-' }}</h5>
                    <span class="text-xs text-emerald-600/80 font-medium">{{ $totalGraded }} Terisi</span>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl border border-teal-100 shadow-xs">
                <span class="text-[11px] font-bold text-teal-700 uppercase">Tuntas KKM</span>
                <div class="flex items-baseline justify-between mt-1">
                    <h5 class="text-2xl font-black text-teal-600">{{ $tuntasCount }}</h5>
                    <span class="text-xs text-teal-700 font-semibold font-mono">{{ $persenTuntas }}%</span>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl border border-rose-100 shadow-xs col-span-2 lg:col-span-1">
                <span class="text-[11px] font-bold text-rose-700 uppercase">Perlu Remedial</span>
                <div class="flex items-baseline justify-between mt-1">
                    <h5 class="text-2xl font-black text-rose-600">{{ $belumTuntasCount }}</h5>
                    <span class="text-xs text-rose-600/80 font-medium">&lt; {{ $kkm }}</span>
                </div>
            </div>
        </div>

        <!-- Spreadsheet Grid Form -->
        <form action="{{ route('akademik.store') }}" method="POST" id="form-nilai">
            @csrf
            <input type="hidden" name="kelas_id" value="{{ $selectedKelas->id }}">
            <input type="hidden" name="mapel_id" value="{{ $selectedMapel->id }}">
            <input type="hidden" name="semester" value="{{ $semester }}">
            <input type="hidden" name="tahun_ajaran" value="{{ $tahunAjaran }}">

            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                <!-- Toolbar Atas Grid -->
                <div class="p-4 sm:p-5 bg-slate-50/80 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <div class="flex items-center gap-2">
                            <h4 class="font-bold text-slate-900 text-sm sm:text-base">
                                {{ $selectedMapel->nama_mapel }} &bull; Kelas {{ $selectedKelas->nama_kelas }}
                            </h4>
                            <span class="text-[11px] bg-emerald-100 text-emerald-800 font-bold px-2 py-0.5 rounded-full">
                                Sem. {{ $semester }} ({{ $tahunAjaran }})
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Guru Pengampu: <strong>{{ $selectedMapel->guru?->nama_guru ?? 'Belum Ditentukan' }}</strong> &bull; KKM: <strong>{{ $kkm }}</strong>
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="submit" class="px-5 py-2 rounded-xl text-xs sm:text-sm font-bold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-700/20 transition-all active:scale-95 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                            </svg>
                            Simpan Nilai
                        </button>
                    </div>
                </div>

                <!-- Spreadsheet Table Grid -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-700 border-collapse" id="spreadsheet-table">
                        <thead class="bg-slate-100/80 text-slate-600 font-semibold border-b border-slate-200 uppercase text-[11px] tracking-wider">
                            <tr>
                                <th scope="col" class="py-3 px-3 text-center w-12 border-r border-slate-200">No</th>
                                <th scope="col" class="py-3 px-4 min-w-[220px] border-r border-slate-200">Nama Siswa & NIS</th>
                                <th scope="col" class="py-3 px-3 text-center w-28 border-r border-slate-200 bg-amber-50/50">
                                    <div class="text-slate-900 font-bold">Tugas</div>
                                    <span class="text-[9px] text-amber-700 font-normal lowercase">(bobot 30%)</span>
                                </th>
                                <th scope="col" class="py-3 px-3 text-center w-28 border-r border-slate-200 bg-sky-50/50">
                                    <div class="text-slate-900 font-bold">UTS</div>
                                    <span class="text-[9px] text-sky-700 font-normal lowercase">(bobot 30%)</span>
                                </th>
                                <th scope="col" class="py-3 px-3 text-center w-28 border-r border-slate-200 bg-indigo-50/50">
                                    <div class="text-slate-900 font-bold">UAS</div>
                                    <span class="text-[9px] text-indigo-700 font-normal lowercase">(bobot 40%)</span>
                                </th>
                                <th scope="col" class="py-3 px-3 text-center w-28 border-r border-slate-200 bg-emerald-50/60">
                                    <div class="text-emerald-900 font-bold">Nilai Akhir</div>
                                    <span class="text-[9px] text-emerald-700 font-normal lowercase">(otomatis)</span>
                                </th>
                                <th scope="col" class="py-3 px-3 text-center w-24 border-r border-slate-200">Predikat</th>
                                <th scope="col" class="py-3 px-4 min-w-[240px]">Capaian Kompetensi / Catatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($siswas as $idx => $siswa)
                                @php
                                    $record = $existingNilai->get($siswa->id);
                                    $tugas = $record?->nilai_tugas !== null ? (float) $record->nilai_tugas : null;
                                    $uts = $record?->nilai_uts !== null ? (float) $record->nilai_uts : null;
                                    $uas = $record?->nilai_uas !== null ? (float) $record->nilai_uas : null;
                                    $akhir = $record?->nilai_akhir !== null ? (float) $record->nilai_akhir : null;
                                    $catatan = $record?->capaian_kompetensi ?? '';

                                    // Predikat
                                    $predikat = '-';
                                    if ($akhir !== null) {
                                        if ($akhir >= 90) $predikat = 'A';
                                        elseif ($akhir >= 80) $predikat = 'B';
                                        elseif ($akhir >= $kkm) $predikat = 'C';
                                        else $predikat = 'D';
                                    }
                                @endphp
                                <tr class="hover:bg-slate-50/80 transition-colors row-siswa" data-siswa-id="{{ $siswa->id }}" data-kkm="{{ $kkm }}">
                                    <!-- No -->
                                    <td class="py-2.5 px-3 text-center text-xs text-slate-400 font-mono border-r border-slate-200">
                                        {{ $idx + 1 }}
                                    </td>

                                    <!-- Nama Siswa & NIS -->
                                    <td class="py-2.5 px-4 border-r border-slate-200">
                                        <div class="flex items-center space-x-2.5">
                                            <div class="w-7 h-7 rounded-full shrink-0 flex items-center justify-center font-bold text-[11px] {{ $siswa->jenis_kelamin === 'L' ? 'bg-sky-100 text-sky-700' : 'bg-rose-100 text-rose-700' }}">
                                                {{ mb_substr($siswa->nama_siswa, 0, 2) }}
                                            </div>
                                            <div class="min-w-0">
                                                <p class="font-bold text-slate-900 text-xs sm:text-sm truncate">{{ $siswa->nama_siswa }}</p>
                                                <p class="text-[11px] text-slate-400 font-mono">NIS: {{ $siswa->nis }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Input Tugas (30%) -->
                                    <td class="py-2 px-2 text-center border-r border-slate-200 bg-amber-50/20">
                                        <input
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            max="100"
                                            name="nilai[{{ $siswa->id }}][nilai_tugas]"
                                            value="{{ $tugas !== null ? $tugas : '' }}"
                                            placeholder="0-100"
                                            class="w-full text-center py-1.5 px-2 bg-white border border-slate-300 rounded-lg text-xs sm:text-sm font-semibold text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all grade-input input-tugas"
                                            data-type="tugas"
                                            data-idx="{{ $idx }}"
                                        >
                                    </td>

                                    <!-- Input UTS (30%) -->
                                    <td class="py-2 px-2 text-center border-r border-slate-200 bg-sky-50/20">
                                        <input
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            max="100"
                                            name="nilai[{{ $siswa->id }}][nilai_uts]"
                                            value="{{ $uts !== null ? $uts : '' }}"
                                            placeholder="0-100"
                                            class="w-full text-center py-1.5 px-2 bg-white border border-slate-300 rounded-lg text-xs sm:text-sm font-semibold text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all grade-input input-uts"
                                            data-type="uts"
                                            data-idx="{{ $idx }}"
                                        >
                                    </td>

                                    <!-- Input UAS (40%) -->
                                    <td class="py-2 px-2 text-center border-r border-slate-200 bg-indigo-50/20">
                                        <input
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            max="100"
                                            name="nilai[{{ $siswa->id }}][nilai_uas]"
                                            value="{{ $uas !== null ? $uas : '' }}"
                                            placeholder="0-100"
                                            class="w-full text-center py-1.5 px-2 bg-white border border-slate-300 rounded-lg text-xs sm:text-sm font-semibold text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all grade-input input-uas"
                                            data-type="uas"
                                            data-idx="{{ $idx }}"
                                        >
                                    </td>

                                    <!-- Nilai Akhir (Kalkulasi Otomatis) -->
                                    <td class="py-2 px-3 text-center border-r border-slate-200 bg-emerald-50/30">
                                        <div class="flex flex-col items-center justify-center">
                                            <span class="text-xs sm:text-sm font-black font-mono cell-nilai-akhir {{ $akhir !== null && $akhir < $kkm ? 'text-rose-600' : 'text-emerald-700' }}">
                                                {{ $akhir !== null ? number_format($akhir, 2) : '-' }}
                                            </span>
                                            <span class="text-[10px] font-semibold cell-kkm-status {{ $akhir !== null && $akhir >= $kkm ? 'text-emerald-600' : ($akhir !== null ? 'text-rose-500' : 'text-slate-400') }}">
                                                {{ $akhir !== null ? ($akhir >= $kkm ? 'Tuntas' : 'Remedial') : '' }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Predikat -->
                                    <td class="py-2 px-2 text-center border-r border-slate-200">
                                        <span class="inline-block w-7 h-7 leading-7 rounded-lg text-xs font-black cell-predikat {{ $predikat === 'A' ? 'bg-emerald-100 text-emerald-800' : ($predikat === 'B' ? 'bg-blue-100 text-blue-800' : ($predikat === 'C' ? 'bg-amber-100 text-amber-800' : ($predikat === 'D' ? 'bg-rose-100 text-rose-800' : 'bg-slate-100 text-slate-400'))) }}">
                                            {{ $predikat }}
                                        </span>
                                    </td>

                                    <!-- Capaian Kompetensi / Catatan -->
                                    <td class="py-2 px-3">
                                        <input
                                            type="text"
                                            name="nilai[{{ $siswa->id }}][capaian_kompetensi]"
                                            value="{{ $catatan }}"
                                            placeholder="Deskripsi pencapaian kompetensi / catatan..."
                                            class="w-full py-1.5 px-3 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all"
                                        >
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-12 text-center text-slate-400">
                                        <svg class="w-12 h-12 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                        Belum ada siswa aktif yang terdaftar pada kelas ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Action Bar -->
                @if ($siswas->isNotEmpty())
                    <div class="p-4 sm:p-6 bg-slate-50/80 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-xs text-slate-500 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Tekan <kbd class="px-1.5 py-0.5 bg-white border border-slate-300 rounded font-mono text-[10px]">Enter</kbd> atau <kbd class="px-1.5 py-0.5 bg-white border border-slate-300 rounded font-mono text-[10px]">&darr;</kbd> untuk navigasi cepat antar baris spreadsheet.</span>
                        </div>
                        <button type="submit" class="w-full sm:w-auto px-8 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-700/20 transition-all transform active:scale-95 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                            </svg>
                            Simpan Seluruh Nilai Siswa
                        </button>
                    </div>
                @endif
            </div>
        </form>
    @else
        <div class="bg-white rounded-2xl border border-slate-200/80 p-12 text-center text-slate-500 shadow-xs">
            <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h4 class="text-base font-bold text-slate-800">Silakan Pilih Kelas dan Mata Pelajaran</h4>
            <p class="text-xs text-slate-500 mt-1 max-w-md mx-auto">Gunakan formulir filter di atas untuk menentukan rombongan belajar dan mata pelajaran yang ingin dinilai.</p>
        </div>
    @endif

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const rows = document.querySelectorAll('.row-siswa');

        function calculateRow(row) {
            const kkm = parseFloat(row.dataset.kkm) || 75;
            const inputTugas = row.querySelector('.input-tugas');
            const inputUts = row.querySelector('.input-uts');
            const inputUas = row.querySelector('.input-uas');
            const cellAkhir = row.querySelector('.cell-nilai-akhir');
            const cellKkm = row.querySelector('.cell-kkm-status');
            const cellPredikat = row.querySelector('.cell-predikat');

            const valTugas = inputTugas.value !== '' ? parseFloat(inputTugas.value) : null;
            const valUts = inputUts.value !== '' ? parseFloat(inputUts.value) : null;
            const valUas = inputUas.value !== '' ? parseFloat(inputUas.value) : null;

            if (valTugas === null && valUts === null && valUas === null) {
                cellAkhir.textContent = '-';
                cellAkhir.className = 'text-xs sm:text-sm font-black font-mono cell-nilai-akhir text-slate-400';
                cellKkm.textContent = '';
                cellPredikat.textContent = '-';
                cellPredikat.className = 'inline-block w-7 h-7 leading-7 rounded-lg text-xs font-black cell-predikat bg-slate-100 text-slate-400';
                return;
            }

            // Rumus bobot: 30% Tugas + 30% UTS + 40% UAS
            const t = valTugas !== null ? valTugas : 0;
            const u = valUts !== null ? valUts : 0;
            const a = valUas !== null ? valUas : 0;

            const finalScore = ((0.30 * t) + (0.30 * u) + (0.40 * a)).toFixed(2);
            cellAkhir.textContent = finalScore;

            // KKM check
            const scoreNum = parseFloat(finalScore);
            if (scoreNum >= kkm) {
                cellAkhir.className = 'text-xs sm:text-sm font-black font-mono cell-nilai-akhir text-emerald-700';
                cellKkm.textContent = 'Tuntas';
                cellKkm.className = 'text-[10px] font-semibold cell-kkm-status text-emerald-600';
            } else {
                cellAkhir.className = 'text-xs sm:text-sm font-black font-mono cell-nilai-akhir text-rose-600';
                cellKkm.textContent = 'Remedial';
                cellKkm.className = 'text-[10px] font-semibold cell-kkm-status text-rose-500';
            }

            // Predikat
            let predikat = 'D';
            let predikatClass = 'bg-rose-100 text-rose-800';
            if (scoreNum >= 90) {
                predikat = 'A';
                predikatClass = 'bg-emerald-100 text-emerald-800';
            } else if (scoreNum >= 80) {
                predikat = 'B';
                predikatClass = 'bg-blue-100 text-blue-800';
            } else if (scoreNum >= kkm) {
                predikat = 'C';
                predikatClass = 'bg-amber-100 text-amber-800';
            }

            cellPredikat.textContent = predikat;
            cellPredikat.className = `inline-block w-7 h-7 leading-7 rounded-lg text-xs font-black cell-predikat ${predikatClass}`;
        }

        // Event listener input real-time
        rows.forEach(row => {
            const inputs = row.querySelectorAll('.grade-input');
            inputs.forEach(input => {
                input.addEventListener('input', function () {
                    // Batasi jika > 100 atau < 0
                    if (parseFloat(this.value) > 100) {
                        this.value = 100;
                    } else if (parseFloat(this.value) < 0) {
                        this.value = 0;
                    }
                    calculateRow(row);
                });

                // Keyboard arrow & Enter spreadsheet navigation
                input.addEventListener('keydown', function (e) {
                    const currentIdx = parseInt(this.dataset.idx, 10);
                    const type = this.dataset.type;

                    if (e.key === 'Enter' || e.key === 'ArrowDown') {
                        e.preventDefault();
                        const nextInput = document.querySelector(`.grade-input[data-type="${type}"][data-idx="${currentIdx + 1}"]`);
                        if (nextInput) nextInput.focus();
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        const prevInput = document.querySelector(`.grade-input[data-type="${type}"][data-idx="${currentIdx - 1}"]`);
                        if (prevInput) prevInput.focus();
                    }
                });
            });
        });
    });
</script>
@endpush
@endsection

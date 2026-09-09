@extends('layouts.app')

@section('title', 'Absensi & Presensi Siswa')
@section('page_title', 'Modul Presensi Harian Siswa')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-emerald-700 mb-1">
                <span>OPERASIONAL</span>
                <span>/</span>
                <span>PRESENSI HARIAN</span>
            </div>
            <h3 class="text-xl font-extrabold text-slate-900 tracking-tight">Presensi Kehadiran Siswa per Rombel Kelas</h3>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Pilih rombongan belajar kelas dan tanggal, lalu isi presensi harian siswa secara cepat pada grid tabel.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('absensi.rekap', ['kelas_id' => $kelasId]) }}" class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 transition-colors shadow-xs">
                <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                Rekap Presensi Bulanan
            </a>
        </div>
    </div>

    <!-- Filter Pemilihan Kelas & Tanggal -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <form action="{{ route('absensi.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
            <!-- Pilihan Kelas -->
            <div class="sm:col-span-6 lg:col-span-5">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Pilih Rombongan Belajar (Kelas) <span class="text-rose-500">*</span></label>
                <select name="kelas_id" required class="w-full py-2.5 px-3.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    @foreach ($kelasList as $k)
                        <option value="{{ $k->id }}" {{ (string) $kelasId === (string) $k->id ? 'selected' : '' }}>
                            Kelas {{ $k->nama_kelas }} (Wali: {{ $k->waliKelas?->nama_guru ?? 'Belum Ditentukan' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Pilihan Tanggal -->
            <div class="sm:col-span-4 lg:col-span-4">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Tanggal Presensi <span class="text-rose-500">*</span></label>
                <input type="date" name="tanggal" value="{{ $tanggal }}" required class="w-full py-2.5 px-3.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
            </div>

            <!-- Tombol Buka Kelas -->
            <div class="sm:col-span-2 lg:col-span-3">
                <button type="submit" class="w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition-colors flex items-center justify-center gap-2 shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    Buka Data Kelas
                </button>
            </div>
        </form>
    </div>

    @if ($selectedKelas)
        <!-- Daily Attendance Statistics -->
        <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
            <div class="bg-white p-4 rounded-xl border border-emerald-100 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-emerald-700 uppercase">Hadir (H)</span>
                    <h5 class="text-xl font-black text-emerald-600 mt-0.5">{{ $rekapHarian['H'] }}</h5>
                </div>
                <span class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs">H</span>
            </div>

            <div class="bg-white p-4 rounded-xl border border-blue-100 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-blue-700 uppercase">Izin (I)</span>
                    <h5 class="text-xl font-black text-blue-600 mt-0.5">{{ $rekapHarian['I'] }}</h5>
                </div>
                <span class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-xs">I</span>
            </div>

            <div class="bg-white p-4 rounded-xl border border-amber-100 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-amber-700 uppercase">Sakit (S)</span>
                    <h5 class="text-xl font-black text-amber-600 mt-0.5">{{ $rekapHarian['S'] }}</h5>
                </div>
                <span class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-xs">S</span>
            </div>

            <div class="bg-white p-4 rounded-xl border border-rose-100 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-rose-700 uppercase">Alpa (A)</span>
                    <h5 class="text-xl font-black text-rose-600 mt-0.5">{{ $rekapHarian['A'] }}</h5>
                </div>
                <span class="w-8 h-8 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center font-bold text-xs">A</span>
            </div>

            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-xs flex items-center justify-between col-span-2 sm:col-span-1">
                <div>
                    <span class="text-[11px] font-bold text-slate-500 uppercase">Belum Diisi</span>
                    <h5 class="text-xl font-black text-slate-700 mt-0.5">{{ $rekapHarian['belum'] }}</h5>
                </div>
                <span class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-xs">-</span>
            </div>
        </div>

        <!-- Attendance Grid Form -->
        <form action="{{ route('absensi.store') }}" method="POST">
            @csrf
            <input type="hidden" name="kelas_id" value="{{ $selectedKelas->id }}">
            <input type="hidden" name="tanggal" value="{{ $tanggal }}">

            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                <!-- Grid Header Toolbar -->
                <div class="p-4 sm:p-5 bg-slate-50/80 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm sm:text-base">
                            Daftar Siswa Kelas {{ $selectedKelas->nama_kelas }} ({{ $siswas->count() }} Siswa)
                        </h4>
                        <p class="text-xs text-slate-500">
                            Wali Kelas: <strong>{{ $selectedKelas->waliKelas?->nama_guru ?? 'Belum Ditentukan' }}</strong> &bull; Tanggal: <strong>{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}</strong>
                        </p>
                    </div>
                    <!-- Quick Set All Present Button -->
                    <button type="button" onclick="setSemuaHadir()" class="inline-flex items-center px-3.5 py-2 rounded-xl text-xs font-bold text-emerald-700 bg-emerald-100 hover:bg-emerald-200 border border-emerald-300 transition-colors shadow-xs">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Set Semua Hadir (H)
                    </button>
                </div>

                <!-- Grid Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-700">
                        <thead class="bg-slate-100/70 text-slate-600 font-semibold border-b border-slate-200 uppercase text-[11px] tracking-wider">
                            <tr>
                                <th scope="col" class="py-3 px-4 text-center w-12">No</th>
                                <th scope="col" class="py-3 px-4">Nama Siswa & NIS</th>
                                <th scope="col" class="py-3 px-4 text-center w-24">Gender</th>
                                <th scope="col" class="py-3 px-4 text-center w-72">Status Kehadiran (H / I / S / A)</th>
                                <th scope="col" class="py-3 px-4">Keterangan Tambahan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($siswas as $idx => $siswa)
                                @php
                                    $currentAbsen = $existingAbsensi->get($siswa->id);
                                    $currentStatus = $currentAbsen?->status ?? 'H';
                                    $currentKet = $currentAbsen?->keterangan ?? '';
                                @endphp
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="py-3.5 px-4 text-center text-xs text-slate-400 font-mono">
                                        {{ $idx + 1 }}
                                    </td>

                                    <!-- Nama & NIS -->
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 rounded-full shrink-0 flex items-center justify-center font-bold text-xs {{ $siswa->jenis_kelamin === 'L' ? 'bg-sky-100 text-sky-700' : 'bg-rose-100 text-rose-700' }}">
                                                {{ mb_substr($siswa->nama_siswa, 0, 2) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-900 leading-tight">{{ $siswa->nama_siswa }}</p>
                                                <p class="text-xs text-slate-500 font-mono mt-0.5">NIS: {{ $siswa->nis }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Gender -->
                                    <td class="py-3.5 px-4 text-center">
                                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $siswa->jenis_kelamin === 'L' ? 'bg-sky-50 text-sky-700' : 'bg-rose-50 text-rose-700' }}">
                                            {{ $siswa->jenis_kelamin === 'L' ? 'Ikhwan' : 'Akhwat' }}
                                        </span>
                                    </td>

                                    <!-- Grid Status Radio (H, I, S, A) -->
                                    <td class="py-3.5 px-4">
                                        <div class="grid grid-cols-4 gap-1.5 p-1 bg-slate-100 rounded-xl border border-slate-200">
                                            <!-- Hadir (H) -->
                                            <label class="flex flex-col items-center justify-center py-1.5 rounded-lg cursor-pointer transition-all has-checked:bg-emerald-600 has-checked:text-white has-checked:shadow-xs hover:bg-slate-200/70">
                                                <input type="radio" name="absensi[{{ $siswa->id }}][status]" value="H" {{ $currentStatus === 'H' ? 'checked' : '' }} class="sr-only status-radio-h">
                                                <span class="text-xs font-bold">H</span>
                                                <span class="text-[9px] uppercase tracking-wider">Hadir</span>
                                            </label>

                                            <!-- Izin (I) -->
                                            <label class="flex flex-col items-center justify-center py-1.5 rounded-lg cursor-pointer transition-all has-checked:bg-blue-600 has-checked:text-white has-checked:shadow-xs hover:bg-slate-200/70">
                                                <input type="radio" name="absensi[{{ $siswa->id }}][status]" value="I" {{ $currentStatus === 'I' ? 'checked' : '' }} class="sr-only">
                                                <span class="text-xs font-bold">I</span>
                                                <span class="text-[9px] uppercase tracking-wider">Izin</span>
                                            </label>

                                            <!-- Sakit (S) -->
                                            <label class="flex flex-col items-center justify-center py-1.5 rounded-lg cursor-pointer transition-all has-checked:bg-amber-500 has-checked:text-white has-checked:shadow-xs hover:bg-slate-200/70">
                                                <input type="radio" name="absensi[{{ $siswa->id }}][status]" value="S" {{ $currentStatus === 'S' ? 'checked' : '' }} class="sr-only">
                                                <span class="text-xs font-bold">S</span>
                                                <span class="text-[9px] uppercase tracking-wider">Sakit</span>
                                            </label>

                                            <!-- Alpa (A) -->
                                            <label class="flex flex-col items-center justify-center py-1.5 rounded-lg cursor-pointer transition-all has-checked:bg-rose-600 has-checked:text-white has-checked:shadow-xs hover:bg-slate-200/70">
                                                <input type="radio" name="absensi[{{ $siswa->id }}][status]" value="A" {{ $currentStatus === 'A' ? 'checked' : '' }} class="sr-only">
                                                <span class="text-xs font-bold">A</span>
                                                <span class="text-[9px] uppercase tracking-wider">Alpa</span>
                                            </label>
                                        </div>
                                    </td>

                                    <!-- Keterangan -->
                                    <td class="py-3.5 px-4">
                                        <input type="text" name="absensi[{{ $siswa->id }}][keterangan]" value="{{ $currentKet }}" placeholder="Catatan khusus (misal: demam, surat terlampir)..." class="w-full py-1.5 px-3 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-900 focus:outline-hidden focus:ring-1 focus:ring-emerald-500 focus:bg-white transition-all">
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-10 text-center text-slate-400">
                                        Belum ada data siswa aktif yang terdaftar di kelas ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Action Bar -->
                @if ($siswas->isNotEmpty())
                    <div class="p-4 sm:p-6 bg-slate-50/80 border-t border-slate-200 flex items-center justify-between">
                        <p class="text-xs text-slate-500">
                            * Pastikan seluruh kehadiran telah terisi dengan benar sebelum menekan simpan.
                        </p>
                        <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-700/20 transition-all transform active:scale-95 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Simpan Presensi Kelas
                        </button>
                    </div>
                @endif
            </div>
        </form>
    @else
        <div class="bg-white rounded-2xl border border-slate-200/80 p-12 text-center text-slate-500">
            Pilih rombel kelas terlebih dahulu untuk memulai pengisian presensi harian.
        </div>
    @endif

</div>

@push('scripts')
<script>
    function setSemuaHadir() {
        const radios = document.querySelectorAll('.status-radio-h');
        radios.forEach(r => {
            r.checked = true;
            r.dispatchEvent(new Event('change'));
        });
    }
</script>
@endpush
@endsection

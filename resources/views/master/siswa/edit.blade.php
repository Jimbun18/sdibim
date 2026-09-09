@extends('layouts.app')

@section('title', 'Edit Data Siswa')
@section('page_title', 'Perbarui Data Siswa')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header Breadcrumb -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-emerald-700 mb-1">
                <a href="{{ route('siswa.index') }}" class="hover:underline">DATA SISWA</a>
                <span>/</span>
                <span>PERBARUI DATA</span>
            </div>
            <h3 class="text-xl font-extrabold text-slate-900 tracking-tight">Edit Data: {{ $siswa->nama_siswa }}</h3>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Perbarui informasi identitas, pemindahan kelas, atau kontak orang tua siswa.</p>
        </div>
        <a href="{{ route('siswa.index') }}" class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors shadow-xs">
            &larr; Kembali ke Daftar
        </a>
    </div>

    <!-- Form Container Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 sm:p-8">
        <form action="{{ route('siswa.update', $siswa) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Section 1: Data Akademik & Identitas Pokok -->
            <div>
                <h4 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 pb-3 border-b border-slate-200">
                    <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs">1</span>
                    Identitas & Penempatan Kelas
                </h4>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mt-5">
                    <!-- NIS -->
                    <div>
                        <label for="nis" class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor Induk Siswa (NIS) <span class="text-rose-500">*</span></label>
                        <input type="text" name="nis" id="nis" value="{{ old('nis', $siswa->nis) }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border @error('nis') border-rose-300 ring-1 ring-rose-300 @else border-slate-300 @enderror rounded-xl text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                        @error('nis')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NISN -->
                    <div>
                        <label for="nisn" class="block text-xs font-semibold text-slate-700 mb-1.5">NISN (Kemendikbud)</label>
                        <input type="text" name="nisn" id="nisn" value="{{ old('nisn', $siswa->nisn) }}" class="w-full px-3.5 py-2.5 bg-slate-50 border @error('nisn') border-rose-300 ring-1 ring-rose-300 @else border-slate-300 @enderror rounded-xl text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                        @error('nisn')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="sm:col-span-2">
                        <label for="nama_siswa" class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Lengkap Siswa <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_siswa" id="nama_siswa" value="{{ old('nama_siswa', $siswa->nama_siswa) }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border @error('nama_siswa') border-rose-300 ring-1 ring-rose-300 @else border-slate-300 @enderror rounded-xl text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                        @error('nama_siswa')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Rombel Kelas -->
                    <div>
                        <label for="kelas_id" class="block text-xs font-semibold text-slate-700 mb-1.5">Rombongan Belajar (Kelas) <span class="text-rose-500">*</span></label>
                        <select name="kelas_id" id="kelas_id" required class="w-full px-3.5 py-2.5 bg-slate-50 border @error('kelas_id') border-rose-300 ring-1 ring-rose-300 @else border-slate-300 @enderror rounded-xl text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($kelasList as $kelas)
                                <option value="{{ $kelas->id }}" {{ old('kelas_id', $siswa->kelas_id) == $kelas->id ? 'selected' : '' }}>
                                    Kelas {{ $kelas->nama_kelas }} (Wali: {{ $kelas->waliKelas?->nama_guru ?? 'Belum Ditentukan' }})
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Jenis Kelamin <span class="text-rose-500">*</span></label>
                        <div class="flex items-center gap-4 mt-2">
                            <label class="inline-flex items-center text-sm text-slate-700 cursor-pointer">
                                <input type="radio" name="jenis_kelamin" value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'L' ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 focus:ring-emerald-500 border-slate-300">
                                <span class="ml-2 font-medium">Laki-laki (Ikhwan)</span>
                            </label>
                            <label class="inline-flex items-center text-sm text-slate-700 cursor-pointer">
                                <input type="radio" name="jenis_kelamin" value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'P' ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 focus:ring-emerald-500 border-slate-300">
                                <span class="ml-2 font-medium">Perempuan (Akhwat)</span>
                            </label>
                        </div>
                        @error('jenis_kelamin')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Keaktifan -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Status Siswa</label>
                        <label class="inline-flex items-center mt-2 cursor-pointer">
                            <input type="checkbox" name="status_aktif" value="1" {{ old('status_aktif', $siswa->status_aktif) ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 rounded-sm focus:ring-emerald-500 border-slate-300">
                            <span class="ml-2 text-sm text-slate-700 font-medium">Siswa Aktif Terdaftar</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Section 2: Kontak & Data Orang Tua / Wali -->
            <div class="pt-4">
                <h4 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 pb-3 border-b border-slate-200">
                    <span class="w-6 h-6 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-xs">2</span>
                    Data Orang Tua / Wali & Alamat
                </h4>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mt-5">
                    <!-- Nama Wali -->
                    <div>
                        <label for="nama_wali" class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Orang Tua / Wali</label>
                        <input type="text" name="nama_wali" id="nama_wali" value="{{ old('nama_wali', $siswa->nama_wali) }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    </div>

                    <!-- No HP / WhatsApp -->
                    <div>
                        <label for="no_hp_wali" class="block text-xs font-semibold text-slate-700 mb-1.5">No. WhatsApp / Telepon Wali</label>
                        <input type="text" name="no_hp_wali" id="no_hp_wali" value="{{ old('no_hp_wali', $siswa->no_hp_wali) }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    </div>

                    <!-- Alamat Lengkap -->
                    <div class="sm:col-span-2">
                        <label for="alamat" class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat Tempat Tinggal</label>
                        <textarea name="alamat" id="alamat" rows="3" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">{{ old('alamat', $siswa->alamat) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-200">
                <a href="{{ route('siswa.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-100 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-700/20 transition-all transform active:scale-95">
                    Perbarui Data Siswa
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

@extends('layouts.app')

@section('title', 'Edit Kelas ' . $kelas->nama_kelas)
@section('page_title', 'Perbarui Informasi Rombongan Belajar (Kelas)')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <!-- Header Breadcrumb -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-emerald-700 mb-1">
                <a href="{{ route('kelas.index') }}" class="hover:underline">DATA KELAS</a>
                <span>/</span>
                <span>EDIT KELAS</span>
            </div>
            <h3 class="text-xl font-extrabold text-slate-900 tracking-tight">Edit Rombel: Kelas {{ $kelas->nama_kelas }}</h3>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Perbarui nama kelas, jenjang tingkat, atau pergantian guru wali kelas.</p>
        </div>
        <a href="{{ route('kelas.index') }}" class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors shadow-xs">
            &larr; Kembali ke Daftar
        </a>
    </div>

    <!-- Form Container Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 sm:p-8">
        <form action="{{ route('kelas.update', $kelas) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Section: Data Kelas -->
            <div>
                <h4 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 pb-3 border-b border-slate-200">
                    <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs">1</span>
                    Informasi Rombel & Tingkat
                </h4>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mt-5">
                    <!-- Nama Kelas -->
                    <div>
                        <label for="nama_kelas" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Nama Kelas / Rombel <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="nama_kelas" id="nama_kelas" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required placeholder="Contoh: 1-A, 2-B, 6-Madinah" class="w-full px-4 py-2.5 bg-slate-50 border @error('nama_kelas') border-rose-300 ring-1 ring-rose-300 @else border-slate-300 @enderror rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                        @error('nama_kelas')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tingkat (1-6) -->
                    <div>
                        <label for="tingkat" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Tingkat Jenjang Pendidikan <span class="text-rose-500">*</span>
                        </label>
                        <select name="tingkat" id="tingkat" required class="w-full px-4 py-2.5 bg-slate-50 border @error('tingkat') border-rose-300 ring-1 ring-rose-300 @else border-slate-300 @enderror rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                            <option value="">-- Pilih Tingkat --</option>
                            @for ($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}" {{ (string)old('tingkat', $kelas->tingkat) === (string)$i ? 'selected' : '' }}>
                                    Tingkat {{ $i }} (Kelas {{ $i }} SD)
                                </option>
                            @endfor
                        </select>
                        @error('tingkat')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Wali Kelas -->
                    <div class="sm:col-span-2">
                        <label for="wali_kelas_id" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Wali Kelas (Pendidik Pembina)
                        </label>
                        <select name="wali_kelas_id" id="wali_kelas_id" class="w-full px-4 py-2.5 bg-slate-50 border @error('wali_kelas_id') border-rose-300 ring-1 ring-rose-300 @else border-slate-300 @enderror rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                            <option value="">-- Belum Menetapkan Wali Kelas --</option>
                            @foreach ($gurus as $guru)
                                <option value="{{ $guru->id }}" {{ (string)old('wali_kelas_id', $kelas->wali_kelas_id) === (string)$guru->id ? 'selected' : '' }}>
                                    {{ $guru->nama_guru }} (NIP: {{ $guru->nip ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                        @error('wali_kelas_id')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-5 border-t border-slate-200 flex items-center justify-end gap-3">
                <a href="{{ route('kelas.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-700/20 transition-all transform active:scale-95">
                    Perbarui Data Kelas
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

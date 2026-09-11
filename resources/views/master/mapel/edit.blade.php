@extends('layouts.app')

@section('title', 'Edit Mapel ' . $mapel->nama_mapel)
@section('page_title', 'Perbarui Data Mata Pelajaran')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <!-- Header Breadcrumb -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-emerald-700 mb-1">
                <a href="{{ route('mapel.index') }}" class="hover:underline">MATA PELAJARAN</a>
                <span>/</span>
                <span>EDIT MAPEL</span>
            </div>
            <h3 class="text-xl font-extrabold text-slate-900 tracking-tight">Edit: {{ $mapel->nama_mapel }}</h3>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Perbarui nama pelajaran, kode, KKM kelulusan, atau pergantian guru pengampu.</p>
        </div>
        <a href="{{ route('mapel.index') }}" class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors shadow-xs">
            &larr; Kembali ke Daftar
        </a>
    </div>

    <!-- Form Container Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 sm:p-8">
        <form action="{{ route('mapel.update', $mapel) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Section: Data Mapel -->
            <div>
                <h4 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 pb-3 border-b border-slate-200">
                    <span class="w-6 h-6 rounded-lg bg-purple-100 text-purple-700 flex items-center justify-center text-xs">1</span>
                    Identitas Mata Pelajaran
                </h4>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mt-5">
                    <!-- Kode Mapel -->
                    <div>
                        <label for="kode_mapel" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Kode Mata Pelajaran <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="kode_mapel" id="kode_mapel" value="{{ old('kode_mapel', $mapel->kode_mapel) }}" required placeholder="Contoh: PAI, TAHFIDZ, MTK, IPA" class="w-full px-4 py-2.5 bg-slate-50 border @error('kode_mapel') border-rose-300 ring-1 ring-rose-300 @else border-slate-300 @enderror rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all uppercase">
                        @error('kode_mapel')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- KKM -->
                    <div>
                        <label for="kkm" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Batas KKM Standar Kelulusan (0-100) <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" name="kkm" id="kkm" value="{{ old('kkm', $mapel->kkm) }}" min="0" max="100" required placeholder="75" class="w-full px-4 py-2.5 bg-slate-50 border @error('kkm') border-rose-300 ring-1 ring-rose-300 @else border-slate-300 @enderror rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                        @error('kkm')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Mapel -->
                    <div class="sm:col-span-2">
                        <label for="nama_mapel" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Nama Lengkap Mata Pelajaran <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="nama_mapel" id="nama_mapel" value="{{ old('nama_mapel', $mapel->nama_mapel) }}" required placeholder="Contoh: Pendidikan Agama Islam & Budi Pekerti" class="w-full px-4 py-2.5 bg-slate-50 border @error('nama_mapel') border-rose-300 ring-1 ring-rose-300 @else border-slate-300 @enderror rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                        @error('nama_mapel')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Guru Pengampu -->
                    <div class="sm:col-span-2">
                        <label for="guru_id" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Guru Pengampu Mata Pelajaran
                        </label>
                        <select name="guru_id" id="guru_id" class="w-full px-4 py-2.5 bg-slate-50 border @error('guru_id') border-rose-300 ring-1 ring-rose-300 @else border-slate-300 @enderror rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                            <option value="">-- Belum Menetapkan Guru Pengampu --</option>
                            @foreach ($gurus as $guru)
                                <option value="{{ $guru->id }}" {{ (string)old('guru_id', $mapel->guru_id) === (string)$guru->id ? 'selected' : '' }}>
                                    {{ $guru->nama_guru }} ({{ $guru->jabatan ?? 'Guru' }})
                                </option>
                            @endforeach
                        </select>
                        @error('guru_id')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-5 border-t border-slate-200 flex items-center justify-end gap-3">
                <a href="{{ route('mapel.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-700/20 transition-all transform active:scale-95">
                    Perbarui Mata Pelajaran
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

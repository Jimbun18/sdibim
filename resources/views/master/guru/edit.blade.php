@extends('layouts.app')

@section('title', 'Edit Data Guru')
@section('page_title', 'Perbarui Data Guru & Tenaga Pendidik')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header Breadcrumb -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-emerald-700 mb-1">
                <a href="{{ route('guru.index') }}" class="hover:underline">DATA GURU</a>
                <span>/</span>
                <span>EDIT DATA</span>
            </div>
            <h3 class="text-xl font-extrabold text-slate-900 tracking-tight">Perbarui: {{ $guru->nama_guru }}</h3>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Perbarui profil tenaga pengajar, kontak, dan penugasan di sekolah.</p>
        </div>
        <a href="{{ route('guru.index') }}" class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors shadow-xs">
            &larr; Kembali ke Daftar
        </a>
    </div>

    <!-- Form Container Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 sm:p-8">
        <form action="{{ route('guru.update', $guru) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Section 1: Identitas Guru -->
            <div>
                <h4 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 pb-3 border-b border-slate-200">
                    <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs">1</span>
                    Data Identitas Guru & Jabatan
                </h4>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mt-5">
                    <!-- Nama Lengkap & Gelar -->
                    <div class="sm:col-span-2">
                        <label for="nama_guru" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Nama Lengkap & Gelar <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="nama_guru" id="nama_guru" value="{{ old('nama_guru', $guru->nama_guru) }}" required placeholder="Contoh: Ustadz Ahmad Zaki, S.Pd.I" class="w-full px-4 py-2.5 bg-slate-50 border @error('nama_guru') border-rose-300 ring-1 ring-rose-300 @else border-slate-300 @enderror rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                        @error('nama_guru')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NIP / NUPTK -->
                    <div>
                        <label for="nip" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            NIP / Nomor Pegawai
                        </label>
                        <input type="text" name="nip" id="nip" value="{{ old('nip', $guru->nip) }}" placeholder="Contoh: 198501152010011005" class="w-full px-4 py-2.5 bg-slate-50 border @error('nip') border-rose-300 ring-1 ring-rose-300 @else border-slate-300 @enderror rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                        @error('nip')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jabatan / Penugasan -->
                    <div>
                        <label for="jabatan" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Jabatan / Penugasan
                        </label>
                        <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan', $guru->jabatan) }}" placeholder="Contoh: Guru Kelas, Guru PAI, Kepala Sekolah" class="w-full px-4 py-2.5 bg-slate-50 border @error('jabatan') border-rose-300 ring-1 ring-rose-300 @else border-slate-300 @enderror rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                        @error('jabatan')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 2: Kontak & Alamat -->
            <div>
                <h4 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 pb-3 border-b border-slate-200">
                    <span class="w-6 h-6 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-xs">2</span>
                    Kontak & Alamat Domisili
                </h4>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mt-5">
                    <!-- Nomor WhatsApp / HP -->
                    <div>
                        <label for="no_hp" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Nomor HP / WhatsApp
                        </label>
                        <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $guru->no_hp) }}" placeholder="Contoh: 081234567890" class="w-full px-4 py-2.5 bg-slate-50 border @error('no_hp') border-rose-300 ring-1 ring-rose-300 @else border-slate-300 @enderror rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                        @error('no_hp')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Resmi -->
                    <div>
                        <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Alamat Email
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $guru->email) }}" placeholder="Contoh: ustadz.ahmad@sdi-bim.sch.id" class="w-full px-4 py-2.5 bg-slate-50 border @error('email') border-rose-300 ring-1 ring-rose-300 @else border-slate-300 @enderror rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                        @error('email')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat Lengkap -->
                    <div class="sm:col-span-2">
                        <label for="alamat" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Alamat Tempat Tinggal
                        </label>
                        <textarea name="alamat" id="alamat" rows="3" placeholder="Alamat domisili lengkap..." class="w-full px-4 py-2.5 bg-slate-50 border @error('alamat') border-rose-300 ring-1 ring-rose-300 @else border-slate-300 @enderror rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">{{ old('alamat', $guru->alamat) }}</textarea>
                        @error('alamat')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-5 border-t border-slate-200 flex items-center justify-end gap-3">
                <a href="{{ route('guru.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-700/20 transition-all transform active:scale-95">
                    Perbarui Data Guru
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

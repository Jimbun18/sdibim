<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KeuanganSppController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

// Redirect halaman utama ke dashboard atau data siswa
Route::get('/', function () {
    return redirect()->route('siswa.index');
})->name('home');

// Modul 2, 3, 4: Master Data (Guru, Kelas, Siswa)
Route::prefix('master')->group(function () {
    Route::resource('guru', GuruController::class);
    Route::resource('kelas', KelasController::class)->parameters(['kelas' => 'kelas']);
    Route::resource('siswa', SiswaController::class);
});

// Alias shortcut routes master data
Route::resource('guru', GuruController::class);
Route::resource('kelas', KelasController::class)->parameters(['kelas' => 'kelas']);
Route::resource('siswa', SiswaController::class);

// Modul 5: Keuangan SPP (Generate Massal, Antarmuka Kasir, Pelunasan, Kuitansi)
Route::prefix('keuangan')->name('keuangan.')->group(function () {
    Route::get('spp', [KeuanganSppController::class, 'index'])->name('spp.index');
    Route::post('spp/generate', [KeuanganSppController::class, 'storeGenerate'])->name('spp.generate');
    Route::post('spp/{spp}/bayar', [KeuanganSppController::class, 'bayar'])->name('spp.bayar');
    Route::post('spp/{spp}/batal-bayar', [KeuanganSppController::class, 'batalBayar'])->name('spp.batal');
    Route::get('spp/{spp}/kuitansi', [KeuanganSppController::class, 'kuitansi'])->name('spp.kuitansi');
});

// Modul 6: Absensi Siswa (Presensi Grid Kelas Harian & Rekapitulasi)
Route::prefix('absensi')->name('absensi.')->group(function () {
    Route::get('/', [AbsensiController::class, 'index'])->name('index');
    Route::post('/', [AbsensiController::class, 'store'])->name('store');
    Route::get('/rekap', [AbsensiController::class, 'rekap'])->name('rekap');
});

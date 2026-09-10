<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AkademikController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KeuanganSppController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

// Halaman Utama: Landing Page Resmi SD Islam Bina Insan Mandiri
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Dashboard: Setelah login, arahkan ke Data Siswa (atau ringkasan SIM-SDI)
Route::get('/dashboard', function () {
    return redirect()->route('siswa.index');
})->middleware(['auth'])->name('dashboard');

// Modul-modul Terproteksi Autentikasi (SIM-SDI)
Route::middleware(['auth'])->group(function () {
    // Modul 2, 3, 4: Master Data (Guru, Kelas, Siswa)
    Route::prefix('master')->group(function () {
        Route::resource('guru', GuruController::class);
        Route::resource('kelas', KelasController::class)->parameters(['kelas' => 'kelas']);
        Route::resource('siswa', SiswaController::class);
    });

    // Shortcut routes master data
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

    // Modul 7: Akademik (e-Rapor Input Nilai Siswa) - Hak Akses Khusus Guru & Admin
    Route::middleware(['role:guru,admin'])->prefix('akademik')->name('akademik.')->group(function () {
        Route::get('nilai', [AkademikController::class, 'index'])->name('index');
        Route::get('/', [AkademikController::class, 'index']);
        Route::post('nilai', [AkademikController::class, 'store'])->name('store');
    });

    // Profil Akun Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Autentikasi Breeze (/login, /logout, dll)
require __DIR__.'/auth.php';

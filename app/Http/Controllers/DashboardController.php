<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\KeuanganSpp;
use App\Models\Mapel;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama SIM-SDI dengan ringkasan statistik dan aktivitas terkini.
     */
    public function index(Request $request): View
    {
        $totalSiswa = Siswa::count();
        $siswaAktif = Siswa::where('status_aktif', true)->count();
        $siswaLaki = Siswa::where('jenis_kelamin', 'L')->count();
        $siswaPerempuan = Siswa::where('jenis_kelamin', 'P')->count();

        $totalGuru = Guru::count();
        $totalKelas = Kelas::count();
        $totalMapel = Mapel::count();

        // Data Keuangan SPP Bulan Berjalan
        $bulanSekarang = now()->translatedFormat('F');
        $tahunSekarang = (int) now()->year;

        $sppBulanIni = KeuanganSpp::where('bulan', $bulanSekarang)
            ->where('tahun', $tahunSekarang);

        $totalTagihanSpp = (clone $sppBulanIni)->sum('nominal');
        $sppLunasNominal = (clone $sppBulanIni)->where('status_bayar', 'lunas')->sum('nominal');
        $sppBelumLunasNominal = (clone $sppBulanIni)->where('status_bayar', 'belum_lunas')->sum('nominal');
        $sppLunasCount = (clone $sppBulanIni)->where('status_bayar', 'lunas')->count();
        $sppTotalCount = (clone $sppBulanIni)->count();
        $sppPersen = $sppTotalCount > 0 ? round(($sppLunasCount / $sppTotalCount) * 100, 1) : 0;

        // Data Presensi Hari Ini
        $today = Carbon::today()->toDateString();
        $absensiHariIni = Absensi::whereDate('tanggal', $today)->get();
        $presensiHadir = $absensiHariIni->where('status', 'H')->count();
        $presensiIzin = $absensiHariIni->where('status', 'I')->count();
        $presensiSakit = $absensiHariIni->where('status', 'S')->count();
        $presensiAlpa = $absensiHariIni->where('status', 'A')->count();
        $presensiTotal = $absensiHariIni->count();
        $presensiHadirPersen = $presensiTotal > 0 ? round(($presensiHadir / $presensiTotal) * 100, 1) : 0;

        // Distribusi Siswa per Kelas
        $kelasList = Kelas::with('waliKelas')->withCount('siswas')->orderBy('tingkat')->orderBy('nama_kelas')->get();

        // Transaksi Pembayaran SPP Terkini
        $transaksiTerbaru = KeuanganSpp::with('siswa.kelas')
            ->where('status_bayar', 'lunas')
            ->latest('updated_at')
            ->take(6)
            ->get();

        // Siswa yang baru didaftarkan
        $siswaTerbaru = Siswa::with('kelas')
            ->latest('id')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalSiswa',
            'siswaAktif',
            'siswaLaki',
            'siswaPerempuan',
            'totalGuru',
            'totalKelas',
            'totalMapel',
            'bulanSekarang',
            'tahunSekarang',
            'totalTagihanSpp',
            'sppLunasNominal',
            'sppBelumLunasNominal',
            'sppLunasCount',
            'sppTotalCount',
            'sppPersen',
            'today',
            'presensiHadir',
            'presensiIzin',
            'presensiSakit',
            'presensiAlpa',
            'presensiTotal',
            'presensiHadirPersen',
            'kelasList',
            'transaksiTerbaru',
            'siswaTerbaru'
        ));
    }
}

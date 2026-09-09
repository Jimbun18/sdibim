<?php

namespace App\Http\Controllers;

use App\Http\Requests\BayarSppRequest;
use App\Http\Requests\GenerateSppRequest;
use App\Models\Kelas;
use App\Models\KeuanganSpp;
use App\Models\Siswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class KeuanganSppController extends Controller
{
    /**
     * Menampilkan antarmuka kasir & daftar tagihan SPP dengan ringkasan keuangan.
     */
    public function index(Request $request): View
    {
        $bulan = $request->input('bulan', now()->translatedFormat('F'));
        $tahun = (int) $request->input('tahun', now()->year);
        $kelasId = $request->input('kelas_id');
        $statusBayar = $request->input('status_bayar');
        $search = $request->input('search');

        // Query utama dengan Eager Loading relasi siswa & kelas
        $sppQuery = KeuanganSpp::query()
            ->with(['siswa.kelas.waliKelas'])
            ->when($bulan, fn ($q) => $q->where('bulan', $bulan))
            ->when($tahun, fn ($q) => $q->where('tahun', $tahun))
            ->when($statusBayar, fn ($q) => $q->where('status_bayar', $statusBayar))
            ->when($kelasId, function ($q) use ($kelasId) {
                $q->whereHas('siswa', fn ($sq) => $sq->where('kelas_id', $kelasId));
            })
            ->when($search, function ($q) use ($search) {
                $q->whereHas('siswa', function ($sq) use ($search) {
                    $sq->where('nama_siswa', 'like', "%{$search}%")
                        ->orWhere('nis', 'like', "%{$search}%");
                });
            });

        // Ringkasan Keuangan berdasarkan filter yang aktif
        $summaryQuery = clone $sppQuery;
        $totalTagihanNominal = (clone $summaryQuery)->sum('nominal');
        $totalLunasNominal = (clone $summaryQuery)->where('status_bayar', 'lunas')->sum('nominal');
        $totalBelumLunasNominal = (clone $summaryQuery)->where('status_bayar', 'belum_lunas')->sum('nominal');
        $jumlahLunas = (clone $summaryQuery)->where('status_bayar', 'lunas')->count();
        $jumlahBelumLunas = (clone $summaryQuery)->where('status_bayar', 'belum_lunas')->count();

        $tagihanList = $sppQuery->latest('id')->paginate(15)->withQueryString();

        $kelasList = Kelas::orderBy('tingkat')->orderBy('nama_kelas')->get();
        $daftarBulan = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
        ];

        return view('keuangan.spp.index', compact(
            'tagihanList',
            'kelasList',
            'daftarBulan',
            'bulan',
            'tahun',
            'kelasId',
            'statusBayar',
            'search',
            'totalTagihanNominal',
            'totalLunasNominal',
            'totalBelumLunasNominal',
            'jumlahLunas',
            'jumlahBelumLunas'
        ));
    }

    /**
     * Menjalankan proses transaksi Generate Tagihan SPP massal untuk seluruh siswa aktif.
     */
    public function storeGenerate(GenerateSppRequest $request): RedirectResponse
    {
        $bulan = $request->input('bulan');
        $tahun = (int) $request->input('tahun');
        $nominal = (float) $request->input('nominal');
        $kelasId = $request->input('kelas_id');

        // Mengambil seluruh siswa aktif (bisa difilter per kelas atau seluruh sekolah)
        $siswaQuery = Siswa::query()->where('status_aktif', true);
        if ($kelasId) {
            $siswaQuery->where('kelas_id', $kelasId);
        }
        $siswaAktif = $siswaQuery->get();

        if ($siswaAktif->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ditemukan siswa berstatus aktif untuk di-generate tagihannya.');
        }

        $berhasil = 0;
        $dilewati = 0;

        DB::transaction(function () use ($siswaAktif, $bulan, $tahun, $nominal, &$berhasil, &$dilewati) {
            foreach ($siswaAktif as $siswa) {
                // Cek apakah tagihan untuk siswa di periode ini sudah pernah dibuat
                $exists = KeuanganSpp::where('siswa_id', $siswa->id)
                    ->where('bulan', $bulan)
                    ->where('tahun', $tahun)
                    ->exists();

                if ($exists) {
                    $dilewati++;

                    continue;
                }

                KeuanganSpp::create([
                    'siswa_id' => $siswa->id,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'nominal' => $nominal,
                    'status_bayar' => 'belum_lunas',
                    'catatan' => "Tagihan SPP {$bulan} {$tahun}",
                ]);
                $berhasil++;
            }
        });

        $pesan = "Sukses men-generate tagihan SPP {$bulan} {$tahun} untuk {$berhasil} siswa aktif.";
        if ($dilewati > 0) {
            $pesan .= " ({$dilewati} siswa dilewati karena sudah memiliki tagihan).";
        }

        return redirect()
            ->route('keuangan.spp.index', ['bulan' => $bulan, 'tahun' => $tahun, 'kelas_id' => $kelasId])
            ->with('success', $pesan);
    }

    /**
     * Memproses transaksi pembayaran kasir SPP dan mengubah status menjadi LUNAS.
     */
    public function bayar(BayarSppRequest $request, KeuanganSpp $spp): RedirectResponse
    {
        $spp->load('siswa');

        $spp->update([
            'status_bayar' => 'lunas',
            'tanggal_bayar' => $request->input('tanggal_bayar'),
            'metode_bayar' => $request->input('metode_bayar'),
            'catatan' => $request->input('catatan') ?? "Pembayaran diterima oleh Kasir TU pada {$request->input('tanggal_bayar')}",
        ]);

        return redirect()->back()->with('success', "Pembayaran SPP siswa {$spp->siswa->nama_siswa} periode {$spp->bulan} {$spp->tahun} berhasil dicatat sebagai LUNAS.");
    }

    /**
     * Membatalkan status pembayaran SPP kembali menjadi BELUM LUNAS jika terjadi kekeliruan kasir.
     */
    public function batalBayar(KeuanganSpp $spp): RedirectResponse
    {
        $spp->load('siswa');

        $spp->update([
            'status_bayar' => 'belum_lunas',
            'tanggal_bayar' => null,
            'metode_bayar' => null,
        ]);

        return redirect()->back()->with('success', "Status pembayaran SPP siswa {$spp->siswa->nama_siswa} dikembalikan menjadi BELUM LUNAS.");
    }

    /**
     * Menampilkan slip kuitansi resmi pembayaran SPP siap cetak.
     */
    public function kuitansi(KeuanganSpp $spp): View
    {
        $spp->load(['siswa.kelas.waliKelas']);

        return view('keuangan.spp.kuitansi', compact('spp'));
    }
}

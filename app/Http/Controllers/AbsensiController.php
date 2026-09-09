<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAbsensiRequest;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AbsensiController extends Controller
{
    /**
     * Menampilkan formulir presensi harian berbasis grid tabel berdasarkan kelas dan tanggal.
     */
    public function index(Request $request): View
    {
        $kelasList = Kelas::with('waliKelas')->orderBy('tingkat')->orderBy('nama_kelas')->get();
        $kelasId = $request->input('kelas_id', $kelasList->first()?->id);
        $tanggal = $request->input('tanggal', Carbon::today()->toDateString());

        $selectedKelas = null;
        $siswas = collect();
        $existingAbsensi = collect();
        $rekapHarian = ['H' => 0, 'I' => 0, 'S' => 0, 'A' => 0, 'belum' => 0];

        if ($kelasId) {
            $selectedKelas = Kelas::with('waliKelas')->find($kelasId);

            if ($selectedKelas) {
                // Ambil seluruh siswa aktif di kelas tersebut
                $siswas = Siswa::query()
                    ->where('kelas_id', $kelasId)
                    ->where('status_aktif', true)
                    ->orderBy('nama_siswa')
                    ->get();

                // Ambil data absensi yang telah diisi pada tanggal tersebut
                $existingAbsensi = Absensi::query()
                    ->whereIn('siswa_id', $siswas->pluck('id'))
                    ->where('tanggal', $tanggal)
                    ->get()
                    ->keyBy('siswa_id');

                // Hitung rekap kehadiran harian
                foreach ($siswas as $siswa) {
                    if (isset($existingAbsensi[$siswa->id])) {
                        $st = $existingAbsensi[$siswa->id]->status;
                        if (isset($rekapHarian[$st])) {
                            $rekapHarian[$st]++;
                        }
                    } else {
                        $rekapHarian['belum']++;
                    }
                }
            }
        }

        return view('absensi.index', compact(
            'kelasList',
            'kelasId',
            'selectedKelas',
            'tanggal',
            'siswas',
            'existingAbsensi',
            'rekapHarian'
        ));
    }

    /**
     * Menyimpan atau memperbarui data absensi siswa sekelas secara massal (grid tabel).
     */
    public function store(StoreAbsensiRequest $request): RedirectResponse
    {
        $kelasId = $request->input('kelas_id');
        $tanggal = $request->input('tanggal');
        $dataAbsensi = $request->input('absensi', []);

        $counts = ['H' => 0, 'I' => 0, 'S' => 0, 'A' => 0];

        DB::transaction(function () use ($tanggal, $dataAbsensi, &$counts) {
            foreach ($dataAbsensi as $siswaId => $item) {
                $status = $item['status'] ?? 'H';
                $keterangan = $item['keterangan'] ?? null;

                $existing = Absensi::where('siswa_id', $siswaId)
                    ->whereDate('tanggal', $tanggal)
                    ->first();

                if ($existing) {
                    $existing->update([
                        'status' => $status,
                        'keterangan' => $keterangan,
                    ]);
                } else {
                    Absensi::create([
                        'siswa_id' => $siswaId,
                        'tanggal' => $tanggal,
                        'status' => $status,
                        'keterangan' => $keterangan,
                    ]);
                }

                if (isset($counts[$status])) {
                    $counts[$status]++;
                }
            }
        });

        $namaKelas = Kelas::find($kelasId)?->nama_kelas ?? 'Kelas';
        $tanggalFormat = Carbon::parse($tanggal)->translatedFormat('d F Y');

        $pesan = "Presensi {$namaKelas} tanggal {$tanggalFormat} berhasil disimpan. ";
        $pesan .= "(Hadir: {$counts['H']}, Izin: {$counts['I']}, Sakit: {$counts['S']}, Alpa: {$counts['A']})";

        return redirect()
            ->route('absensi.index', ['kelas_id' => $kelasId, 'tanggal' => $tanggal])
            ->with('success', $pesan);
    }

    /**
     * Menampilkan rekapitulasi presensi bulanan per rombel kelas.
     */
    public function rekap(Request $request): View
    {
        $kelasList = Kelas::with('waliKelas')->orderBy('tingkat')->orderBy('nama_kelas')->get();
        $kelasId = $request->input('kelas_id', $kelasList->first()?->id);
        $bulan = (int) $request->input('bulan', now()->month);
        $tahun = (int) $request->input('tahun', now()->year);

        $selectedKelas = Kelas::with('waliKelas')->find($kelasId);
        $siswas = collect();
        $rekapBulanan = [];

        if ($selectedKelas) {
            $siswas = Siswa::where('kelas_id', $kelasId)->where('status_aktif', true)->orderBy('nama_siswa')->get();

            $absensiData = Absensi::whereIn('siswa_id', $siswas->pluck('id'))
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->get()
                ->groupBy('siswa_id');

            foreach ($siswas as $siswa) {
                $records = $absensiData->get($siswa->id, collect());
                $h = $records->where('status', 'H')->count();
                $i = $records->where('status', 'I')->count();
                $s = $records->where('status', 'S')->count();
                $a = $records->where('status', 'A')->count();
                $totalHari = $records->count();

                $persentase = $totalHari > 0 ? round(($h / $totalHari) * 100, 1) : 0;

                $rekapBulanan[$siswa->id] = [
                    'hadir' => $h,
                    'izin' => $i,
                    'sakit' => $s,
                    'alpa' => $a,
                    'total' => $totalHari,
                    'persentase' => $persentase,
                ];
            }
        }

        return view('absensi.rekap', compact(
            'kelasList',
            'kelasId',
            'selectedKelas',
            'bulan',
            'tahun',
            'siswas',
            'rekapBulanan'
        ));
    }
}

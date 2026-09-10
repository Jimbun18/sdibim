<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNilaiRequest;
use App\Models\AkademikNilai;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AkademikController extends Controller
{
    /**
     * Menampilkan daftar siswa berdasarkan kelas dan mapel yang diajar untuk pengisian nilai e-Rapor.
     * Menggunakan Eager Loading untuk mencegah N+1 problem.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();

        // Ambil daftar mata pelajaran berdasarkan peran user (guru vs admin)
        if ($user && $user->role === 'guru') {
            $guru = Guru::where('email', $user->email)->first();
            $mapelList = $guru
                ? Mapel::where('guru_id', $guru->id)->orderBy('nama_mapel')->get()
                : Mapel::orderBy('nama_mapel')->get();
        } else {
            $mapelList = Mapel::with('guru')->orderBy('nama_mapel')->get();
        }

        // Daftar kelas yang tersedia
        $kelasList = Kelas::with('waliKelas')->orderBy('tingkat')->orderBy('nama_kelas')->get();

        // Filter parameter aktif
        $kelasId = $request->input('kelas_id', $kelasList->first()?->id);
        $mapelId = $request->input('mapel_id', $mapelList->first()?->id);
        $semester = $request->input('semester', '1');
        $tahunAjaran = $request->input('tahun_ajaran', '2025/2026');

        $selectedKelas = null;
        $selectedMapel = null;
        $siswas = collect();
        $existingNilai = collect();

        if ($kelasId && $mapelId) {
            $selectedKelas = Kelas::with('waliKelas')->find($kelasId);
            $selectedMapel = Mapel::with('guru')->find($mapelId);

            if ($selectedKelas && $selectedMapel) {
                // Eager loading relasi kelas dan catatan nilai spesifik mapel, semester, dan tahun ajaran
                $siswas = Siswa::query()
                    ->with([
                        'kelas',
                        'akademikNilais' => function ($query) use ($mapelId, $semester, $tahunAjaran) {
                            $query->where('mapel_id', $mapelId)
                                ->where('semester', $semester)
                                ->where('tahun_ajaran', $tahunAjaran);
                        },
                    ])
                    ->where('kelas_id', $kelasId)
                    ->where('status_aktif', true)
                    ->orderBy('nama_siswa')
                    ->get();

                // Koleksi nilai terindeks berdasarkan siswa_id untuk akses O(1) di tampilan
                $existingNilai = AkademikNilai::query()
                    ->whereIn('siswa_id', $siswas->pluck('id'))
                    ->where('mapel_id', $mapelId)
                    ->where('semester', $semester)
                    ->where('tahun_ajaran', $tahunAjaran)
                    ->get()
                    ->keyBy('siswa_id');
            }
        }

        return view('akademik.index', compact(
            'kelasList',
            'mapelList',
            'kelasId',
            'mapelId',
            'semester',
            'tahunAjaran',
            'selectedKelas',
            'selectedMapel',
            'siswas',
            'existingNilai'
        ));
    }

    /**
     * Menyimpan atau memperbarui data nilai siswa secara massal dari formulir grid.
     * Otomatis mengkalkulasi Nilai Akhir: 30% Tugas + 30% UTS + 40% UAS.
     */
    public function store(StoreNilaiRequest $request): RedirectResponse
    {
        $kelasId = $request->validated('kelas_id');
        $mapelId = $request->validated('mapel_id');
        $semester = $request->validated('semester');
        $tahunAjaran = $request->validated('tahun_ajaran');
        $nilaiData = $request->validated('nilai');

        $savedCount = 0;

        DB::transaction(function () use ($nilaiData, $mapelId, $semester, $tahunAjaran, &$savedCount) {
            foreach ($nilaiData as $siswaId => $item) {
                $tugas = isset($item['nilai_tugas']) && $item['nilai_tugas'] !== '' ? (float) $item['nilai_tugas'] : null;
                $uts = isset($item['nilai_uts']) && $item['nilai_uts'] !== '' ? (float) $item['nilai_uts'] : null;
                $uas = isset($item['nilai_uas']) && $item['nilai_uas'] !== '' ? (float) $item['nilai_uas'] : null;

                // Hitung nilai akhir dengan bobot 30% Tugas + 30% UTS + 40% UAS jika ada komponen terisi
                if ($tugas === null && $uts === null && $uas === null) {
                    $nilaiAkhir = null;
                } else {
                    $nilaiAkhir = round(
                        (0.30 * ($tugas ?? 0)) +
                        (0.30 * ($uts ?? 0)) +
                        (0.40 * ($uas ?? 0)),
                        2
                    );
                }

                AkademikNilai::updateOrCreate(
                    [
                        'siswa_id' => $siswaId,
                        'mapel_id' => $mapelId,
                        'semester' => $semester,
                        'tahun_ajaran' => $tahunAjaran,
                    ],
                    [
                        'nilai_tugas' => $tugas,
                        'nilai_uts' => $uts,
                        'nilai_uas' => $uas,
                        'nilai_akhir' => $nilaiAkhir,
                        'capaian_kompetensi' => $item['capaian_kompetensi'] ?? null,
                    ]
                );

                $savedCount++;
            }
        });

        return redirect()
            ->route('akademik.index', [
                'kelas_id' => $kelasId,
                'mapel_id' => $mapelId,
                'semester' => $semester,
                'tahun_ajaran' => $tahunAjaran,
            ])
            ->with('success', "Berhasil menyimpan nilai untuk {$savedCount} siswa.");
    }
}

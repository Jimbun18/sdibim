<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiswaController extends Controller
{
    /**
     * Menampilkan daftar Siswa dengan Eager Loading relasi kelas & wali kelas
     * untuk mencegah N+1 Query Problem secara optimal.
     */
    public function index(Request $request): View
    {
        $kelasId = $request->input('kelas_id');
        $statusAktif = $request->input('status_aktif');
        $search = $request->input('search');

        $siswas = Siswa::query()
            ->with(['kelas.waliKelas']) // Eager loading mencegah N+1 problem
            ->when($kelasId, fn ($q) => $q->where('kelas_id', $kelasId))
            ->when($statusAktif !== null && $statusAktif !== '', fn ($q) => $q->where('status_aktif', (bool) $statusAktif))
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_siswa', 'like', "%{$search}%")
                        ->orWhere('nis', 'like', "%{$search}%")
                        ->orWhere('nisn', 'like', "%{$search}%");
                });
            })
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        $kelasList = Kelas::orderBy('tingkat')->orderBy('nama_kelas')->get();

        $stats = [
            'total' => Siswa::count(),
            'aktif' => Siswa::where('status_aktif', true)->count(),
            'laki' => Siswa::where('jenis_kelamin', 'L')->count(),
            'perempuan' => Siswa::where('jenis_kelamin', 'P')->count(),
        ];

        return view('master.siswa.index', compact('siswas', 'kelasList', 'kelasId', 'statusAktif', 'search', 'stats'));
    }

    /**
     * Menampilkan formulir penambahan Siswa baru dengan pilihan kelas yang tersedia.
     */
    public function create(): View
    {
        $kelasList = Kelas::with('waliKelas')->orderBy('tingkat')->orderBy('nama_kelas')->get();

        return view('master.siswa.create', compact('kelasList'));
    }

    /**
     * Menyimpan data Siswa baru ke database, otomatis terhubung ke kelas yang dipilih.
     */
    public function store(StoreSiswaRequest $request): RedirectResponse
    {
        Siswa::create($request->validated());

        return redirect()
            ->route('siswa.index')
            ->with('success', 'Data Siswa baru berhasil ditambahkan dan terhubung dengan kelas.');
    }

    /**
     * Menampilkan profil lengkap Siswa beserta riwayat kelas, SPP, dan absensi.
     */
    public function show(Siswa $siswa): View
    {
        $siswa->load([
            'kelas.waliKelas',
            'keuanganSpps' => fn ($q) => $q->latest()->limit(12),
            'absensis' => fn ($q) => $q->latest('tanggal')->limit(10),
            'akademikNilais.mapel',
        ]);

        return view('master.siswa.show', compact('siswa'));
    }

    /**
     * Menampilkan formulir edit Siswa.
     */
    public function edit(Siswa $siswa): View
    {
        $kelasList = Kelas::with('waliKelas')->orderBy('tingkat')->orderBy('nama_kelas')->get();

        return view('master.siswa.edit', compact('siswa', 'kelasList'));
    }

    /**
     * Memperbarui data Siswa di database.
     */
    public function update(UpdateSiswaRequest $request, Siswa $siswa): RedirectResponse
    {
        $siswa->update($request->validated());

        return redirect()
            ->route('siswa.index')
            ->with('success', 'Data Siswa berhasil diperbarui.');
    }

    /**
     * Menghapus data Siswa.
     */
    public function destroy(Siswa $siswa): RedirectResponse
    {
        $siswa->delete();

        return redirect()
            ->route('siswa.index')
            ->with('success', 'Data Siswa berhasil dihapus.');
    }
}

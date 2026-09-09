<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKelasRequest;
use App\Http\Requests\UpdateKelasRequest;
use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KelasController extends Controller
{
    /**
     * Menampilkan daftar Kelas dengan eager loading wali kelas dan jumlah siswa.
     */
    public function index(Request $request): View
    {
        $tingkat = $request->input('tingkat');
        $search = $request->input('search');

        $kelas = Kelas::query()
            ->with('waliKelas')
            ->withCount('siswas')
            ->when($tingkat, fn ($q) => $q->where('tingkat', $tingkat))
            ->when($search, fn ($q) => $q->where('nama_kelas', 'like', "%{$search}%"))
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->paginate(10)
            ->withQueryString();

        return view('master.kelas.index', compact('kelas', 'tingkat', 'search'));
    }

    /**
     * Menampilkan formulir penambahan Kelas baru.
     */
    public function create(): View
    {
        $gurus = Guru::orderBy('nama_guru')->get();

        return view('master.kelas.create', compact('gurus'));
    }

    /**
     * Menyimpan data Kelas baru ke database.
     */
    public function store(StoreKelasRequest $request): RedirectResponse
    {
        Kelas::create($request->validated());

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Data Kelas berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail Kelas dan daftar siswanya.
     */
    public function show(Kelas $kelas): View
    {
        $kelas->load(['waliKelas', 'siswas' => fn ($q) => $q->orderBy('nama_siswa')]);

        return view('master.kelas.show', compact('kelas'));
    }

    /**
     * Menampilkan formulir edit Kelas.
     */
    public function edit(Kelas $kelas): View
    {
        $gurus = Guru::orderBy('nama_guru')->get();

        return view('master.kelas.edit', compact('kelas', 'gurus'));
    }

    /**
     * Memperbarui data Kelas di database.
     */
    public function update(UpdateKelasRequest $request, Kelas $kelas): RedirectResponse
    {
        $kelas->update($request->validated());

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Data Kelas berhasil diperbarui.');
    }

    /**
     * Menghapus data Kelas.
     */
    public function destroy(Kelas $kelas): RedirectResponse
    {
        if ($kelas->siswas()->exists()) {
            return redirect()
                ->route('kelas.index')
                ->with('error', 'Kelas tidak dapat dihapus karena masih memiliki data siswa terdaftar.');
        }

        $kelas->delete();

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Data Kelas berhasil dihapus.');
    }
}

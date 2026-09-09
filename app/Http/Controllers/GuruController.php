<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGuruRequest;
use App\Http\Requests\UpdateGuruRequest;
use App\Models\Guru;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuruController extends Controller
{
    /**
     * Menampilkan daftar Guru dengan eager loading relasi dan fitur pencarian.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $gurus = Guru::query()
            ->with(['kelasWali', 'mapels'])
            ->when($search, function ($query, $search) {
                $query->where('nama_guru', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('master.guru.index', compact('gurus', 'search'));
    }

    /**
     * Menampilkan formulir penambahan Guru baru.
     */
    public function create(): View
    {
        return view('master.guru.create');
    }

    /**
     * Menyimpan data Guru baru ke database.
     */
    public function store(StoreGuruRequest $request): RedirectResponse
    {
        Guru::create($request->validated());

        return redirect()
            ->route('guru.index')
            ->with('success', 'Data Guru berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail informasi Guru.
     */
    public function show(Guru $guru): View
    {
        $guru->load(['kelasWali.siswas', 'mapels']);

        return view('master.guru.show', compact('guru'));
    }

    /**
     * Menampilkan formulir edit Guru.
     */
    public function edit(Guru $guru): View
    {
        return view('master.guru.edit', compact('guru'));
    }

    /**
     * Memperbarui data Guru di database.
     */
    public function update(UpdateGuruRequest $request, Guru $guru): RedirectResponse
    {
        $guru->update($request->validated());

        return redirect()
            ->route('guru.index')
            ->with('success', 'Data Guru berhasil diperbarui.');
    }

    /**
     * Menghapus data Guru.
     */
    public function destroy(Guru $guru): RedirectResponse
    {
        // Cek jika guru masih menjabat sebagai wali kelas
        if ($guru->kelasWali()->exists()) {
            return redirect()
                ->route('guru.index')
                ->with('error', 'Guru tidak dapat dihapus karena masih tercatat sebagai wali kelas aktif.');
        }

        $guru->delete();

        return redirect()
            ->route('guru.index')
            ->with('success', 'Data Guru berhasil dihapus.');
    }
}

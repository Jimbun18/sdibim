<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMapelRequest;
use App\Http\Requests\UpdateMapelRequest;
use App\Models\Guru;
use App\Models\Mapel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MapelController extends Controller
{
    /**
     * Menampilkan daftar mata pelajaran dengan relasi guru pengampu dan pencarian.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $mapels = Mapel::query()
            ->with('guru')
            ->withCount('akademikNilais')
            ->when($search, function ($query, $search) {
                $query->where('nama_mapel', 'like', "%{$search}%")
                    ->orWhere('kode_mapel', 'like', "%{$search}%");
            })
            ->orderBy('nama_mapel')
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'total' => Mapel::count(),
            'dengan_guru' => Mapel::whereNotNull('guru_id')->count(),
            'rata_kkm' => round(Mapel::avg('kkm') ?? 75, 1),
        ];

        return view('master.mapel.index', compact('mapels', 'search', 'stats'));
    }

    /**
     * Menampilkan formulir penambahan mata pelajaran baru.
     */
    public function create(): View
    {
        $gurus = Guru::orderBy('nama_guru')->get();

        return view('master.mapel.create', compact('gurus'));
    }

    /**
     * Menyimpan mata pelajaran baru ke database.
     */
    public function store(StoreMapelRequest $request): RedirectResponse
    {
        Mapel::create($request->validated());

        return redirect()
            ->route('mapel.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail mata pelajaran.
     */
    public function show(Mapel $mapel): View
    {
        $mapel->load(['guru', 'akademikNilais.siswa.kelas']);

        return view('master.mapel.show', compact('mapel'));
    }

    /**
     * Menampilkan formulir edit mata pelajaran.
     */
    public function edit(Mapel $mapel): View
    {
        $gurus = Guru::orderBy('nama_guru')->get();

        return view('master.mapel.edit', compact('mapel', 'gurus'));
    }

    /**
     * Memperbarui data mata pelajaran di database.
     */
    public function update(UpdateMapelRequest $request, Mapel $mapel): RedirectResponse
    {
        $mapel->update($request->validated());

        return redirect()
            ->route('mapel.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    /**
     * Menghapus mata pelajaran.
     */
    public function destroy(Mapel $mapel): RedirectResponse
    {
        if ($mapel->akademikNilais()->exists()) {
            return redirect()
                ->route('mapel.index')
                ->with('error', 'Mata pelajaran tidak dapat dihapus karena sudah memiliki riwayat penilaian siswa.');
        }

        $mapel->delete();

        return redirect()
            ->route('mapel.index')
            ->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}

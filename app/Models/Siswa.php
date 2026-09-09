<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';

    protected $fillable = [
        'nis',
        'nisn',
        'nama_siswa',
        'jenis_kelamin',
        'kelas_id',
        'status_aktif',
        'nama_wali',
        'no_hp_wali',
        'alamat',
    ];

    protected function casts(): array
    {
        return [
            'status_aktif' => 'boolean',
        ];
    }

    /**
     * Relasi ke Kelas tempat siswa terdaftar.
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Relasi ke catatan tagihan & pembayaran SPP siswa.
     */
    public function keuanganSpps(): HasMany
    {
        return $this->hasMany(KeuanganSpp::class, 'siswa_id');
    }

    /**
     * Relasi ke data absensi harian siswa.
     */
    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class, 'siswa_id');
    }

    /**
     * Relasi ke catatan nilai akademik siswa.
     */
    public function akademikNilais(): HasMany
    {
        return $this->hasMany(AkademikNilai::class, 'siswa_id');
    }

    /**
     * Scope query untuk siswa aktif saja.
     */
    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('status_aktif', true);
    }

    /**
     * Scope query filter berdasarkan kelas.
     */
    public function scopeKelas(Builder $query, int $kelasId): Builder
    {
        return $query->where('kelas_id', $kelasId);
    }
}

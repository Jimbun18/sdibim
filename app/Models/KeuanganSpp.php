<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KeuanganSpp extends Model
{
    use HasFactory;

    protected $table = 'keuangan_spps';

    protected $fillable = [
        'siswa_id',
        'bulan',
        'tahun',
        'nominal',
        'status_bayar',
        'tanggal_bayar',
        'metode_bayar',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tahun' => 'integer',
            'nominal' => 'decimal:2',
            'tanggal_bayar' => 'datetime',
        ];
    }

    /**
     * Relasi ke Siswa pemilik tagihan SPP.
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    /**
     * Scope query untuk SPP yang sudah lunas.
     */
    public function scopeLunas(Builder $query): Builder
    {
        return $query->where('status_bayar', 'lunas');
    }

    /**
     * Scope query untuk SPP yang belum lunas.
     */
    public function scopeBelumLunas(Builder $query): Builder
    {
        return $query->where('status_bayar', 'belum_lunas');
    }

    /**
     * Scope filter berdasarkan bulan dan tahun.
     */
    public function scopePeriode(Builder $query, string $bulan, int $tahun): Builder
    {
        return $query->where('bulan', $bulan)->where('tahun', $tahun);
    }
}

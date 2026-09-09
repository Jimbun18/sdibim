<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensis';

    protected $fillable = [
        'siswa_id',
        'tanggal',
        'status',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    /**
     * Relasi ke Siswa yang diabsen.
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    /**
     * Scope query filter berdasarkan tanggal.
     */
    public function scopeTanggal(Builder $query, string $tanggal): Builder
    {
        return $query->where('tanggal', $tanggal);
    }

    /**
     * Scope query filter status absensi ('H', 'I', 'S', 'A').
     */
    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    /**
     * Mendapatkan label lengkap dari status kehadiran.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'H' => 'Hadir',
            'I' => 'Izin',
            'S' => 'Sakit',
            'A' => 'Alpa',
            default => '-',
        };
    }
}

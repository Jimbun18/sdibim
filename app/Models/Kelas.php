<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
        'tingkat',
        'wali_kelas_id',
    ];

    /**
     * Relasi ke Guru yang menjadi Wali Kelas.
     */
    public function waliKelas(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'wali_kelas_id');
    }

    /**
     * Relasi ke seluruh Siswa yang ada di kelas ini.
     */
    public function siswas(): HasMany
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }

    /**
     * Relasi ke Siswa yang berstatus aktif di kelas ini.
     */
    public function siswaAktif(): HasMany
    {
        return $this->hasMany(Siswa::class, 'kelas_id')->where('status_aktif', true);
    }
}

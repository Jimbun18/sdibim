<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'gurus';

    protected $fillable = [
        'nip',
        'nama_guru',
        'jabatan',
        'no_hp',
        'email',
        'alamat',
    ];

    /**
     * Relasi ke Kelas yang dibimbing sebagai wali kelas.
     */
    public function kelasWali(): HasOne
    {
        return $this->hasOne(Kelas::class, 'wali_kelas_id');
    }

    /**
     * Relasi ke Mata Pelajaran yang diampu.
     */
    public function mapels(): HasMany
    {
        return $this->hasMany(Mapel::class, 'guru_id');
    }
}

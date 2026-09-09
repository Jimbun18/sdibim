<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mapel extends Model
{
    use HasFactory;

    protected $table = 'mapels';

    protected $fillable = [
        'kode_mapel',
        'nama_mapel',
        'kkm',
        'guru_id',
    ];

    /**
     * Relasi ke Guru pengampu mata pelajaran.
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    /**
     * Relasi ke seluruh Nilai Siswa pada mapel ini.
     */
    public function akademikNilais(): HasMany
    {
        return $this->hasMany(AkademikNilai::class, 'mapel_id');
    }
}

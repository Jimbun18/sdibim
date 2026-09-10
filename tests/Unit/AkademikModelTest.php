<?php

namespace Tests\Unit;

use App\Models\AkademikNilai;
use App\Models\Mapel;
use App\Models\Siswa;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class AkademikModelTest extends TestCase
{
    public function test_akademik_nilai_belongs_to_siswa(): void
    {
        $nilai = new AkademikNilai;

        $this->assertInstanceOf(BelongsTo::class, $nilai->siswa());
        $this->assertInstanceOf(Siswa::class, $nilai->siswa()->getRelated());
    }

    public function test_akademik_nilai_belongs_to_mapel(): void
    {
        $nilai = new AkademikNilai;

        $this->assertInstanceOf(BelongsTo::class, $nilai->mapel());
        $this->assertInstanceOf(Mapel::class, $nilai->mapel()->getRelated());
    }

    public function test_mapel_has_many_akademik_nilais(): void
    {
        $mapel = new Mapel;

        $this->assertInstanceOf(HasMany::class, $mapel->akademikNilais());
        $this->assertInstanceOf(AkademikNilai::class, $mapel->akademikNilais()->getRelated());
    }

    public function test_siswa_has_many_akademik_nilais(): void
    {
        $siswa = new Siswa;

        $this->assertInstanceOf(HasMany::class, $siswa->akademikNilais());
        $this->assertInstanceOf(AkademikNilai::class, $siswa->akademikNilais()->getRelated());
    }
}

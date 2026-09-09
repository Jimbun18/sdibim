<?php

namespace Tests\Feature;

use App\Models\Absensi;
use App\Models\AkademikNilai;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\KeuanganSpp;
use App\Models\Mapel;
use App\Models\Siswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelRelationshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_relationships_and_foreign_keys_work_correctly(): void
    {
        // 1. Guru & Kelas relationship
        $guru = Guru::create([
            'nip' => '198501012010011001',
            'nama_guru' => 'Ustadz Abdullah',
            'jabatan' => 'Guru Kelas',
        ]);

        $kelas = Kelas::create([
            'nama_kelas' => '1-A',
            'tingkat' => 1,
            'wali_kelas_id' => $guru->id,
        ]);

        $this->assertEquals($guru->id, $kelas->waliKelas->id);
        $this->assertEquals('Ustadz Abdullah', $kelas->waliKelas->nama_guru);
        $this->assertEquals($kelas->id, $guru->kelasWali->id);

        // 2. Kelas & Siswa relationship
        $siswa = Siswa::create([
            'nis' => '2026001',
            'nama_siswa' => 'Ahmad Fatih',
            'jenis_kelamin' => 'L',
            'kelas_id' => $kelas->id,
            'status_aktif' => true,
        ]);

        $this->assertEquals($kelas->id, $siswa->kelas->id);
        $this->assertTrue($kelas->siswas->contains($siswa));
        $this->assertTrue($kelas->siswaAktif->contains($siswa));

        // 3. Siswa & KeuanganSpp relationship
        $spp = KeuanganSpp::create([
            'siswa_id' => $siswa->id,
            'bulan' => 'Juli',
            'tahun' => 2026,
            'nominal' => 350000,
            'status_bayar' => 'lunas',
            'tanggal_bayar' => now(),
        ]);

        $this->assertEquals($siswa->id, $spp->siswa->id);
        $this->assertTrue($siswa->keuanganSpps->contains($spp));

        // 4. Siswa & Absensi relationship
        $absensi = Absensi::create([
            'siswa_id' => $siswa->id,
            'tanggal' => '2026-07-15',
            'status' => 'H',
            'keterangan' => 'Hadir',
        ]);

        $this->assertEquals($siswa->id, $absensi->siswa->id);
        $this->assertTrue($siswa->absensis->contains($absensi));
        $this->assertEquals('Hadir', $absensi->status_label);

        // 5. Mapel & AkademikNilai relationship
        $mapel = Mapel::create([
            'kode_mapel' => 'PAI-1',
            'nama_mapel' => 'Pendidikan Agama Islam',
            'kkm' => 75,
            'guru_id' => $guru->id,
        ]);

        $nilai = AkademikNilai::create([
            'siswa_id' => $siswa->id,
            'mapel_id' => $mapel->id,
            'semester' => '1',
            'tahun_ajaran' => '2026/2027',
            'nilai_tugas' => 85,
            'nilai_uts' => 90,
            'nilai_uas' => 95,
            'nilai_akhir' => 90,
        ]);

        $this->assertEquals($mapel->id, $nilai->mapel->id);
        $this->assertEquals($siswa->id, $nilai->siswa->id);
        $this->assertTrue($siswa->akademikNilais->contains($nilai));
        $this->assertTrue($mapel->akademikNilais->contains($nilai));
    }
}

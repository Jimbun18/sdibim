<?php

namespace Tests\Feature;

use App\Models\Absensi;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AbsensiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
    }

    public function test_attendance_grid_can_record_and_update_student_presence(): void
    {
        $guru = Guru::create(['nama_guru' => 'Ustadz Mansur']);
        $kelas = Kelas::create(['nama_kelas' => '3-A', 'tingkat' => 3, 'wali_kelas_id' => $guru->id]);

        $siswa1 = Siswa::create([
            'nis' => '2026021',
            'nama_siswa' => 'Ibrahim',
            'jenis_kelamin' => 'L',
            'kelas_id' => $kelas->id,
            'status_aktif' => true,
        ]);

        $siswa2 = Siswa::create([
            'nis' => '2026022',
            'nama_siswa' => 'Sarah',
            'jenis_kelamin' => 'P',
            'kelas_id' => $kelas->id,
            'status_aktif' => true,
        ]);

        // 1. Simpan presensi harian untuk 2 siswa
        $response = $this->post(route('absensi.store'), [
            'kelas_id' => $kelas->id,
            'tanggal' => '2026-09-09',
            'absensi' => [
                $siswa1->id => [
                    'status' => 'H',
                    'keterangan' => 'Hadir tepat waktu',
                ],
                $siswa2->id => [
                    'status' => 'S',
                    'keterangan' => 'Demam flu',
                ],
            ],
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $record1 = Absensi::where('siswa_id', $siswa1->id)->whereDate('tanggal', '2026-09-09')->first();
        $this->assertNotNull($record1);
        $this->assertEquals('H', $record1->status);

        $record2 = Absensi::where('siswa_id', $siswa2->id)->whereDate('tanggal', '2026-09-09')->first();
        $this->assertNotNull($record2);
        $this->assertEquals('S', $record2->status);
        $this->assertEquals('Demam flu', $record2->keterangan);

        // 2. Update presensi pada tanggal yang sama (misal Sarah status diubah jadi Izin)
        $updateResponse = $this->post(route('absensi.store'), [
            'kelas_id' => $kelas->id,
            'tanggal' => '2026-09-09',
            'absensi' => [
                $siswa1->id => ['status' => 'H'],
                $siswa2->id => ['status' => 'I', 'keterangan' => 'Surat izin keluarga'],
            ],
        ]);

        $updateResponse->assertRedirect();
        // Jumlah record tetap 2 (tidak duplicate)
        $this->assertEquals(2, Absensi::whereDate('tanggal', '2026-09-09')->count());

        $record2Updated = Absensi::where('siswa_id', $siswa2->id)->whereDate('tanggal', '2026-09-09')->first();
        $this->assertNotNull($record2Updated);
        $this->assertEquals('I', $record2Updated->status);

        // 3. Akses halaman rekap presensi
        $rekapResponse = $this->get(route('absensi.rekap', ['kelas_id' => $kelas->id, 'bulan' => 9, 'tahun' => 2026]));
        $rekapResponse->assertStatus(200);
        $rekapResponse->assertSee('Ibrahim');
        $rekapResponse->assertSee('Sarah');
    }
}

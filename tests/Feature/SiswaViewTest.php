<?php

namespace Tests\Feature;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiswaViewTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
    }

    public function test_siswa_index_view_renders_successfully(): void
    {
        $guru = Guru::create(['nama_guru' => 'Ustadz Zaid']);
        $kelas = Kelas::create([
            'nama_kelas' => '1-A',
            'tingkat' => 1,
            'wali_kelas_id' => $guru->id,
        ]);

        $siswa = Siswa::create([
            'nis' => '2026001',
            'nama_siswa' => 'Ahmad Rayyan',
            'jenis_kelamin' => 'L',
            'kelas_id' => $kelas->id,
            'status_aktif' => true,
        ]);

        $response = $this->get(route('siswa.index'));

        $response->assertStatus(200);
        $response->assertSee('Daftar Siswa SD Islam Bina Insan Mandiri');
        $response->assertSee('Ahmad Rayyan');
        $response->assertSee('2026001');
        $response->assertSee('SIM-SDI');
        $response->assertSee('1. Dashboard');
        $response->assertSee('2. Data Guru');
        $response->assertSee('3. Data Kelas');
        $response->assertSee('4. Data Siswa');
        $response->assertSee('5. Keuangan SPP');
        $response->assertSee('6. Absensi Siswa');
        $response->assertSee('7. Nilai Akademik');
        $response->assertSee('8. Mata Pelajaran');
    }

    public function test_siswa_create_and_edit_views_render_successfully(): void
    {
        $guru = Guru::create(['nama_guru' => 'Ustadzah Fatimah']);
        $kelas = Kelas::create([
            'nama_kelas' => '2-B',
            'tingkat' => 2,
            'wali_kelas_id' => $guru->id,
        ]);

        $siswa = Siswa::create([
            'nis' => '2026002',
            'nama_siswa' => 'Maryam Khansa',
            'jenis_kelamin' => 'P',
            'kelas_id' => $kelas->id,
            'status_aktif' => true,
        ]);

        $createResponse = $this->get(route('siswa.create'));
        $createResponse->assertStatus(200);
        $createResponse->assertSee('Formulir Pendaftaran Siswa');
        $createResponse->assertSee('Kelas 2-B');

        $editResponse = $this->get(route('siswa.edit', $siswa));
        $editResponse->assertStatus(200);
        $editResponse->assertSee('Edit Data: Maryam Khansa');

        $showResponse = $this->get(route('siswa.show', $siswa));
        $showResponse->assertStatus(200);
        $showResponse->assertSee('Profil Lengkap Siswa');
        $showResponse->assertSee('Maryam Khansa');
    }
}

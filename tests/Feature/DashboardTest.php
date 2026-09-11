<?php

namespace Tests\Feature;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_page_can_be_rendered_for_authenticated_user(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $guru = Guru::create(['nama_guru' => 'Ustadz Zaid', 'nip' => '19850101']);
        $kelas = Kelas::create(['nama_kelas' => '1-A', 'tingkat' => 1, 'wali_kelas_id' => $guru->id]);
        $mapel = Mapel::create(['kode_mapel' => 'PAI1', 'nama_mapel' => 'Pendidikan Agama Islam', 'kkm' => 75]);
        $siswa = Siswa::create(['nis' => '2026001', 'nama_siswa' => 'Ahmad Rayyan', 'jenis_kelamin' => 'L', 'kelas_id' => $kelas->id]);

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Dashboard Utama SIM-SDI');
        $response->assertSee('Akses Cepat Modul SIM-SDI');
        $response->assertSee('Rombongan Belajar');
        $response->assertSee('1-A');
        $response->assertSee('Ustadz Zaid');
    }

    public function test_dashboard_page_redirects_for_guest(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    }
}

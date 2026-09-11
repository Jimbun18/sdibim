<?php

namespace Tests\Feature;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KelasViewTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
    }

    public function test_kelas_index_view_renders_successfully(): void
    {
        $guru = Guru::create(['nama_guru' => 'Ustadz Abu Bakar']);
        $kelas = Kelas::create([
            'nama_kelas' => '5-A',
            'tingkat' => 5,
            'wali_kelas_id' => $guru->id,
        ]);

        $response = $this->get(route('kelas.index'));

        $response->assertStatus(200);
        $response->assertSee('Rombongan Belajar SD Islam Bina Insan Mandiri');
        $response->assertSee('5-A');
        $response->assertSee('Ustadz Abu Bakar');
        $response->assertSee('Tingkat 5');
    }

    public function test_kelas_create_and_edit_views_render_successfully(): void
    {
        $guru = Guru::create(['nama_guru' => 'Ustadz Utsman']);
        $kelas = Kelas::create([
            'nama_kelas' => '4-B',
            'tingkat' => 4,
            'wali_kelas_id' => $guru->id,
        ]);

        $createResponse = $this->get(route('kelas.create'));
        $createResponse->assertStatus(200);
        $createResponse->assertSee('Formulir Kelas Baru');

        $editResponse = $this->get(route('kelas.edit', $kelas));
        $editResponse->assertStatus(200);
        $editResponse->assertSee('Edit Rombel: Kelas 4-B');
    }

    public function test_kelas_show_view_renders_successfully(): void
    {
        $guru = Guru::create(['nama_guru' => 'Ustadz Umar bin Khattab']);
        $kelas = Kelas::create([
            'nama_kelas' => '6-A',
            'tingkat' => 6,
            'wali_kelas_id' => $guru->id,
        ]);

        $siswa = Siswa::create([
            'nis' => '2026099',
            'nama_siswa' => 'Abdullah',
            'jenis_kelamin' => 'L',
            'kelas_id' => $kelas->id,
            'status_aktif' => true,
        ]);

        $response = $this->get(route('kelas.show', $kelas));

        $response->assertStatus(200);
        $response->assertSee('Kelas 6-A');
        $response->assertSee('Ustadz Umar bin Khattab');
        $response->assertSee('Abdullah');
        $response->assertSee('2026099');
    }
}

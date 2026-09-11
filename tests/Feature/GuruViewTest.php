<?php

namespace Tests\Feature;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuruViewTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
    }

    public function test_guru_index_view_renders_successfully(): void
    {
        $guru = Guru::create([
            'nama_guru' => 'Ustadz Salman Al-Farisi',
            'nip' => '19870101',
            'jabatan' => 'Guru PAI & Tahfidz',
            'no_hp' => '081299887766',
            'email' => 'salman@sdi-bim.sch.id',
        ]);

        $response = $this->get(route('guru.index'));

        $response->assertStatus(200);
        $response->assertSee('Daftar Guru SD Islam Bina Insan Mandiri');
        $response->assertSee('Ustadz Salman Al-Farisi');
        $response->assertSee('19870101');
        $response->assertSee('081299887766');
    }

    public function test_guru_create_and_edit_views_render_successfully(): void
    {
        $guru = Guru::create([
            'nama_guru' => 'Ustadzah Maryam',
            'nip' => '19900101',
        ]);

        $createResponse = $this->get(route('guru.create'));
        $createResponse->assertStatus(200);
        $createResponse->assertSee('Formulir Pendidik Baru');

        $editResponse = $this->get(route('guru.edit', $guru));
        $editResponse->assertStatus(200);
        $editResponse->assertSee('Ustadzah Maryam');
        $editResponse->assertSee('19900101');
    }

    public function test_guru_show_view_renders_successfully(): void
    {
        $guru = Guru::create([
            'nama_guru' => 'Ustadz Ali bin Abi Thalib',
            'nip' => '19800101',
            'jabatan' => 'Wali Kelas 3-A',
        ]);

        $kelas = Kelas::create([
            'nama_kelas' => '3-A',
            'tingkat' => 3,
            'wali_kelas_id' => $guru->id,
        ]);

        $mapel = Mapel::create([
            'kode_mapel' => 'AQD3',
            'nama_mapel' => 'Aqidah Akhlak',
            'kkm' => 80,
            'guru_id' => $guru->id,
        ]);

        $response = $this->get(route('guru.show', $guru));

        $response->assertStatus(200);
        $response->assertSee('Ustadz Ali bin Abi Thalib');
        $response->assertSee('Wali Kelas 3-A');
        $response->assertSee('Aqidah Akhlak');
    }
}

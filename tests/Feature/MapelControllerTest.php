<?php

namespace Tests\Feature;

use App\Models\Guru;
use App\Models\Mapel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MapelControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
    }

    public function test_mapel_index_view_renders_successfully(): void
    {
        $guru = Guru::create(['nama_guru' => 'Ustadz Hamzah']);
        $mapel = Mapel::create([
            'kode_mapel' => 'TAHF1',
            'nama_mapel' => 'Tahfidz Al-Qur\'an',
            'kkm' => 80,
            'guru_id' => $guru->id,
        ]);

        $response = $this->get(route('mapel.index'));

        $response->assertStatus(200);
        $response->assertSee('Mata Pelajaran');
        $response->assertSee('TAHF1');
        $response->assertSee('Tahfidz Al-Qur\'an');
        $response->assertSee('Ustadz Hamzah');
    }

    public function test_mapel_create_store_edit_update_destroy_flow(): void
    {
        $guru = Guru::create(['nama_guru' => 'Ustadz Bilal']);

        // 1. Create page
        $createResponse = $this->get(route('mapel.create'));
        $createResponse->assertStatus(200);
        $createResponse->assertSee('Formulir Mata Pelajaran Baru');

        // 2. Store mapel
        $storeResponse = $this->post(route('mapel.store'), [
            'kode_mapel' => 'ARAB1',
            'nama_mapel' => 'Bahasa Arab Dasar',
            'kkm' => 75,
            'guru_id' => $guru->id,
        ]);

        $storeResponse->assertRedirect(route('mapel.index'));
        $this->assertDatabaseHas('mapels', [
            'kode_mapel' => 'ARAB1',
            'nama_mapel' => 'Bahasa Arab Dasar',
            'kkm' => 75,
            'guru_id' => $guru->id,
        ]);

        $mapel = Mapel::where('kode_mapel', 'ARAB1')->first();

        // 3. Edit page
        $editResponse = $this->get(route('mapel.edit', $mapel));
        $editResponse->assertStatus(200);
        $editResponse->assertSee('Bahasa Arab Dasar');

        // 4. Update mapel
        $updateResponse = $this->put(route('mapel.update', $mapel), [
            'kode_mapel' => 'ARAB1',
            'nama_mapel' => 'Bahasa Arab Lanjutan',
            'kkm' => 80,
            'guru_id' => $guru->id,
        ]);

        $updateResponse->assertRedirect(route('mapel.index'));
        $this->assertDatabaseHas('mapels', [
            'kode_mapel' => 'ARAB1',
            'nama_mapel' => 'Bahasa Arab Lanjutan',
            'kkm' => 80,
        ]);

        // 5. Show page
        $showResponse = $this->get(route('mapel.show', $mapel));
        $showResponse->assertStatus(200);
        $showResponse->assertSee('Bahasa Arab Lanjutan');

        // 6. Destroy mapel
        $destroyResponse = $this->delete(route('mapel.destroy', $mapel));
        $destroyResponse->assertRedirect(route('mapel.index'));
        $this->assertDatabaseMissing('mapels', ['id' => $mapel->id]);
    }
}

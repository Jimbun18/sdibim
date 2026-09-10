<?php

namespace Tests\Feature;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MasterDataControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
    }

    public function test_guru_resource_crud_and_validation(): void
    {
        // 1. Validation error when nama_guru is empty
        $response = $this->post(route('guru.store'), []);
        $response->assertSessionHasErrors('nama_guru');

        // 2. Store Guru successfully
        $response = $this->post(route('guru.store'), [
            'nip' => '198705052012011002',
            'nama_guru' => 'Ustadz Hamzah',
            'jabatan' => 'Guru Bahasa Arab',
            'no_hp' => '081122334455',
            'email' => 'hamzah@sdi.sch.id',
            'alamat' => 'Jl. Asy-Syuhada',
        ]);
        $response->assertRedirect(route('guru.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('gurus', ['nama_guru' => 'Ustadz Hamzah']);

        $guru = Guru::where('nama_guru', 'Ustadz Hamzah')->first();

        // 3. Update Guru successfully
        $updateResponse = $this->put(route('guru.update', $guru), [
            'nama_guru' => 'Ustadz Hamzah Al-Qudsy, Lc.',
            'jabatan' => 'Kepala Kurikulum & Guru Bahasa Arab',
        ]);
        $updateResponse->assertRedirect(route('guru.index'));
        $this->assertDatabaseHas('gurus', ['nama_guru' => 'Ustadz Hamzah Al-Qudsy, Lc.']);

        // 4. Destroy Guru successfully
        $deleteResponse = $this->delete(route('guru.destroy', $guru));
        $deleteResponse->assertRedirect(route('guru.index'));
        $this->assertDatabaseMissing('gurus', ['id' => $guru->id]);
    }

    public function test_kelas_resource_crud_and_validation(): void
    {
        $guru = Guru::create([
            'nama_guru' => 'Ustadz Khalid',
        ]);

        // 1. Validation error when nama_kelas or tingkat is empty
        $response = $this->post(route('kelas.store'), []);
        $response->assertSessionHasErrors(['nama_kelas', 'tingkat']);

        // 2. Store Kelas successfully
        $response = $this->post(route('kelas.store'), [
            'nama_kelas' => '3-A (Utsman bin Affan)',
            'tingkat' => 3,
            'wali_kelas_id' => $guru->id,
        ]);
        $response->assertRedirect(route('kelas.index'));
        $this->assertDatabaseHas('kelas', ['nama_kelas' => '3-A (Utsman bin Affan)']);

        $kelas = Kelas::where('nama_kelas', '3-A (Utsman bin Affan)')->first();

        // 3. Update Kelas successfully
        $updateResponse = $this->put(route('kelas.update', $kelas), [
            'nama_kelas' => '3-A Unggulan',
            'tingkat' => 3,
            'wali_kelas_id' => $guru->id,
        ]);
        $updateResponse->assertRedirect(route('kelas.index'));
        $this->assertDatabaseHas('kelas', ['nama_kelas' => '3-A Unggulan']);
    }

    public function test_siswa_resource_crud_with_automatic_class_link_and_eager_loading(): void
    {
        $guru = Guru::create(['nama_guru' => 'Ustadz Salman']);
        $kelas = Kelas::create([
            'nama_kelas' => '1-B',
            'tingkat' => 1,
            'wali_kelas_id' => $guru->id,
        ]);

        // 1. Validation error on required fields
        $response = $this->post(route('siswa.store'), []);
        $response->assertSessionHasErrors(['nis', 'nama_siswa', 'jenis_kelamin', 'kelas_id']);

        // 2. Store Siswa successfully (automatically connected to kelas)
        $response = $this->post(route('siswa.store'), [
            'nis' => '2026101',
            'nisn' => '0099887766',
            'nama_siswa' => 'Fathimah Zahra',
            'jenis_kelamin' => 'P',
            'kelas_id' => $kelas->id,
            'status_aktif' => true,
            'nama_wali' => 'Farhan',
            'no_hp_wali' => '081233445566',
        ]);
        $response->assertRedirect(route('siswa.index'));
        $this->assertDatabaseHas('siswas', [
            'nis' => '2026101',
            'nama_siswa' => 'Fathimah Zahra',
            'kelas_id' => $kelas->id,
        ]);

        $siswa = Siswa::where('nis', '2026101')->first();
        $this->assertEquals($kelas->id, $siswa->kelas->id);
        $this->assertEquals('1-B', $siswa->kelas->nama_kelas);

        // 3. Update Siswa
        $updateResponse = $this->put(route('siswa.update', $siswa), [
            'nis' => '2026101',
            'nama_siswa' => 'Fathimah Az-Zahra',
            'jenis_kelamin' => 'P',
            'kelas_id' => $kelas->id,
            'status_aktif' => true,
        ]);
        $updateResponse->assertRedirect(route('siswa.index'));
        $this->assertDatabaseHas('siswas', ['nama_siswa' => 'Fathimah Az-Zahra']);

        // 4. Verify Eager Loading prevents N+1 query problem on index query
        DB::enableQueryLog();
        $queryResult = Siswa::query()
            ->with(['kelas.waliKelas'])
            ->latest('id')
            ->paginate(10);

        // Access relation attributes
        foreach ($queryResult as $item) {
            $wali = $item->kelas?->waliKelas?->nama_guru;
            $namaKelas = $item->kelas?->nama_kelas;
            $this->assertNotEmpty($namaKelas);
        }

        $log = DB::getQueryLog();
        // The total number of queries should remain constant (pagination count + siswas + kelas + gurus = ~4 queries), NOT 1+N!
        $this->assertLessThanOrEqual(5, count($log));
    }
}

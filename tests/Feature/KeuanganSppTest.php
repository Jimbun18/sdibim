<?php

namespace Tests\Feature;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\KeuanganSpp;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KeuanganSppTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
    }

    public function test_bulk_generate_spp_creates_bills_for_all_active_students(): void
    {
        $guru = Guru::create(['nama_guru' => 'Ustadz Hasan']);
        $kelas = Kelas::create(['nama_kelas' => '1-A', 'tingkat' => 1, 'wali_kelas_id' => $guru->id]);

        // Siswa 1: Aktif
        $siswaAktif1 = Siswa::create([
            'nis' => '2026001',
            'nama_siswa' => 'Abdullah',
            'jenis_kelamin' => 'L',
            'kelas_id' => $kelas->id,
            'status_aktif' => true,
        ]);

        // Siswa 2: Aktif
        $siswaAktif2 = Siswa::create([
            'nis' => '2026002',
            'nama_siswa' => 'Khadijah',
            'jenis_kelamin' => 'P',
            'kelas_id' => $kelas->id,
            'status_aktif' => true,
        ]);

        // Siswa 3: Non-aktif (tidak boleh ter-generate)
        $siswaNonAktif = Siswa::create([
            'nis' => '2026003',
            'nama_siswa' => 'Zubair',
            'jenis_kelamin' => 'L',
            'kelas_id' => $kelas->id,
            'status_aktif' => false,
        ]);

        // Request generate tagihan Agustus 2026
        $response = $this->post(route('keuangan.spp.generate'), [
            'bulan' => 'Agustus',
            'tahun' => 2026,
            'nominal' => 350000,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Pastikan tagihan dibuat untuk siswa aktif
        $this->assertDatabaseHas('keuangan_spps', [
            'siswa_id' => $siswaAktif1->id,
            'bulan' => 'Agustus',
            'tahun' => 2026,
            'nominal' => 350000,
            'status_bayar' => 'belum_lunas',
        ]);
        $this->assertDatabaseHas('keuangan_spps', [
            'siswa_id' => $siswaAktif2->id,
            'bulan' => 'Agustus',
            'tahun' => 2026,
        ]);

        // Pastikan siswa non-aktif tidak mendapatkan tagihan
        $this->assertDatabaseMissing('keuangan_spps', [
            'siswa_id' => $siswaNonAktif->id,
            'bulan' => 'Agustus',
            'tahun' => 2026,
        ]);

        // Generate ulang pada periode yang sama tidak menyebabkan duplikasi (skipping)
        $reGenerateResponse = $this->post(route('keuangan.spp.generate'), [
            'bulan' => 'Agustus',
            'tahun' => 2026,
            'nominal' => 350000,
        ]);
        $reGenerateResponse->assertRedirect();
        $this->assertEquals(2, KeuanganSpp::where('bulan', 'Agustus')->where('tahun', 2026)->count());
    }

    public function test_kasir_can_mark_spp_as_lunas_and_cancel_payment(): void
    {
        $guru = Guru::create(['nama_guru' => 'Ustadzah Halimah']);
        $kelas = Kelas::create(['nama_kelas' => '2-A', 'tingkat' => 2, 'wali_kelas_id' => $guru->id]);
        $siswa = Siswa::create([
            'nis' => '2026010',
            'nama_siswa' => 'Ali Imran',
            'jenis_kelamin' => 'L',
            'kelas_id' => $kelas->id,
            'status_aktif' => true,
        ]);

        $spp = KeuanganSpp::create([
            'siswa_id' => $siswa->id,
            'bulan' => 'September',
            'tahun' => 2026,
            'nominal' => 350000,
            'status_bayar' => 'belum_lunas',
        ]);

        // 1. Kasir memproses pelunasan
        $payResponse = $this->post(route('keuangan.spp.bayar', $spp), [
            'metode_bayar' => 'Transfer Bank BSI',
            'tanggal_bayar' => '2026-09-10 10:00:00',
            'catatan' => 'Transfer via BSI Mobile',
        ]);

        $payResponse->assertRedirect();
        $this->assertDatabaseHas('keuangan_spps', [
            'id' => $spp->id,
            'status_bayar' => 'lunas',
            'metode_bayar' => 'Transfer Bank BSI',
        ]);

        // 2. Akses kuitansi resmi
        $kuitansiResponse = $this->get(route('keuangan.spp.kuitansi', $spp));
        $kuitansiResponse->assertStatus(200);
        $kuitansiResponse->assertSee('BUKTI PEMBAYARAN SPP (LUNAS)');
        $kuitansiResponse->assertSee('Ali Imran');

        // 3. Batalkan pembayaran
        $cancelResponse = $this->post(route('keuangan.spp.batal', $spp));
        $cancelResponse->assertRedirect();
        $this->assertDatabaseHas('keuangan_spps', [
            'id' => $spp->id,
            'status_bayar' => 'belum_lunas',
            'tanggal_bayar' => null,
            'metode_bayar' => null,
        ]);
    }
}

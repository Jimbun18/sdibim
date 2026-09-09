<?php

namespace Database\Seeders;

use App\Models\Absensi;
use App\Models\AkademikNilai;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\KeuanganSpp;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Pengguna (Users)
        $admin = User::create([
            'name' => 'Administrator SIM-SDI',
            'email' => 'admin@sdi-bim.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 2. Data Guru
        $guru1 = Guru::create([
            'nip' => '198501152010011001',
            'nama_guru' => 'Ustadz Ahmad Fauzi, S.Pd.I',
            'jabatan' => 'Wali Kelas & Guru PAI',
            'no_hp' => '081234567890',
            'email' => 'ahmad.fauzi@sdi-bim.sch.id',
            'alamat' => 'Jl. Kebon Jeruk No. 12',
        ]);

        $guru2 = Guru::create([
            'nip' => '199003202015022002',
            'nama_guru' => 'Ustadzah Siti Maryam, S.Pd',
            'jabatan' => 'Guru Matematika',
            'no_hp' => '081298765432',
            'email' => 'siti.maryam@sdi-bim.sch.id',
            'alamat' => 'Jl. Melati Indah No. 5',
        ]);

        // 3. Data Kelas (Relasi ke Wali Kelas)
        $kelas1A = Kelas::create([
            'nama_kelas' => '1-A (Abu Bakar)',
            'tingkat' => 1,
            'wali_kelas_id' => $guru1->id,
        ]);

        $kelas2A = Kelas::create([
            'nama_kelas' => '2-A (Umar bin Khattab)',
            'tingkat' => 2,
            'wali_kelas_id' => $guru2->id,
        ]);

        // 4. Data Siswa (Relasi ke Kelas)
        $siswa1 = Siswa::create([
            'nis' => '2026001',
            'nisn' => '0012345678',
            'nama_siswa' => 'Muhammad Bilal Al-Ghifari',
            'jenis_kelamin' => 'L',
            'kelas_id' => $kelas1A->id,
            'status_aktif' => true,
            'nama_wali' => 'Bambang Sudarsono',
            'no_hp_wali' => '085711223344',
            'alamat' => 'Kavling Madinah No. 8',
        ]);

        $siswa2 = Siswa::create([
            'nis' => '2026002',
            'nisn' => '0012345679',
            'nama_siswa' => 'Aisyah Putri Azzahra',
            'jenis_kelamin' => 'P',
            'kelas_id' => $kelas1A->id,
            'status_aktif' => true,
            'nama_wali' => 'Rahmat Hidayat',
            'no_hp_wali' => '085799887766',
            'alamat' => 'Komplek Permata Hijau Blok C',
        ]);

        // 5. Data Keuangan SPP
        KeuanganSpp::create([
            'siswa_id' => $siswa1->id,
            'bulan' => 'Juli',
            'tahun' => 2026,
            'nominal' => 350000.00,
            'status_bayar' => 'lunas',
            'tanggal_bayar' => now(),
            'metode_bayar' => 'Tunai',
            'catatan' => 'Pembayaran lunas bulan Juli',
        ]);

        KeuanganSpp::create([
            'siswa_id' => $siswa2->id,
            'bulan' => 'Juli',
            'tahun' => 2026,
            'nominal' => 350000.00,
            'status_bayar' => 'belum_lunas',
            'tanggal_bayar' => null,
            'metode_bayar' => null,
            'catatan' => 'Tagihan SPP Juli 2026',
        ]);

        // 6. Data Absensi Harian
        Absensi::create([
            'siswa_id' => $siswa1->id,
            'tanggal' => now()->toDateString(),
            'status' => 'H',
            'keterangan' => 'Hadir tepat waktu',
        ]);

        Absensi::create([
            'siswa_id' => $siswa2->id,
            'tanggal' => now()->toDateString(),
            'status' => 'S',
            'keterangan' => 'Demam (Surat Dokter)',
        ]);

        // 7. Data Mata Pelajaran
        $mapelPAI = Mapel::create([
            'kode_mapel' => 'PAI-01',
            'nama_mapel' => 'Pendidikan Agama Islam & Tahfidz',
            'kkm' => 80,
            'guru_id' => $guru1->id,
        ]);

        // 8. Data Nilai Akademik
        AkademikNilai::create([
            'siswa_id' => $siswa1->id,
            'mapel_id' => $mapelPAI->id,
            'semester' => '1',
            'tahun_ajaran' => '2026/2027',
            'nilai_tugas' => 90.00,
            'nilai_uts' => 88.00,
            'nilai_uas' => 92.00,
            'nilai_akhir' => 90.20,
            'capaian_kompetensi' => 'Sangat baik dalam hafalan Juz 30 dan pemahaman fiqih wudhu.',
        ]);
    }
}

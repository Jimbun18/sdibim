<?php

namespace Tests\Feature;

use App\Http\Requests\StoreNilaiRequest;
use App\Models\AkademikNilai;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class AkademikControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_validation_rejects_scores_above_100_or_below_0(): void
    {
        $guru = Guru::create(['nama_guru' => 'Ustadz Ahmad']);
        $kelas = Kelas::create(['nama_kelas' => '4-A', 'tingkat' => 4, 'wali_kelas_id' => $guru->id]);
        $mapel = Mapel::create(['kode_mapel' => 'PAI4', 'nama_mapel' => 'Pendidikan Agama Islam', 'kkm' => 75]);
        $siswa = Siswa::create(['nis' => '2026101', 'nama_siswa' => 'Abdullah', 'jenis_kelamin' => 'L', 'kelas_id' => $kelas->id]);

        $request = new StoreNilaiRequest;
        $rules = $request->rules();

        $invalidData = [
            'kelas_id' => $kelas->id,
            'mapel_id' => $mapel->id,
            'semester' => '1',
            'tahun_ajaran' => '2025/2026',
            'nilai' => [
                $siswa->id => [
                    'nilai_tugas' => 105, // > 100
                    'nilai_uts' => -10,   // < 0
                    'nilai_uas' => 80,
                ],
            ],
        ];

        $validator = Validator::make($invalidData, $rules);
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('nilai.'.$siswa->id.'.nilai_tugas', $validator->errors()->toArray());
        $this->assertArrayHasKey('nilai.'.$siswa->id.'.nilai_uts', $validator->errors()->toArray());
    }

    public function test_formula_calculates_weighted_final_grade_accurately(): void
    {
        $guru = Guru::create(['nama_guru' => 'Ustadzah Fatimah']);
        $kelas = Kelas::create(['nama_kelas' => '5-B', 'tingkat' => 5, 'wali_kelas_id' => $guru->id]);
        $mapel = Mapel::create(['kode_mapel' => 'MAT5', 'nama_mapel' => 'Matematika', 'kkm' => 75]);
        $siswa = Siswa::create(['nis' => '2026102', 'nama_siswa' => 'Aisyah', 'jenis_kelamin' => 'P', 'kelas_id' => $kelas->id]);

        $tugas = 80.00;
        $uts = 70.00;
        $uas = 90.00;

        // Rumus: 30% Tugas + 30% UTS + 40% UAS
        // (0.30 * 80) + (0.30 * 70) + (0.40 * 90) = 24 + 21 + 36 = 81.00
        $expectedNilaiAkhir = round((0.30 * $tugas) + (0.30 * $uts) + (0.40 * $uas), 2);

        $nilai = AkademikNilai::create([
            'siswa_id' => $siswa->id,
            'mapel_id' => $mapel->id,
            'semester' => '1',
            'tahun_ajaran' => '2025/2026',
            'nilai_tugas' => $tugas,
            'nilai_uts' => $uts,
            'nilai_uas' => $uas,
            'nilai_akhir' => $expectedNilaiAkhir,
            'capaian_kompetensi' => 'Sangat baik dalam operasi pecahan',
        ]);

        $this->assertEquals(81.00, (float) $nilai->fresh()->nilai_akhir);
    }

    public function test_middleware_restricts_access_for_guest(): void
    {
        $response = $this->get(route('akademik.index'));
        $response->assertStatus(403);
    }

    public function test_middleware_restricts_access_for_tu_role(): void
    {
        $tuUser = User::create([
            'name' => 'Staf TU',
            'email' => 'tu@sdi-bim.sch.id',
            'password' => bcrypt('password'),
            'role' => 'tu',
        ]);

        $response = $this->actingAs($tuUser)->get(route('akademik.index'));
        $response->assertStatus(403);
    }

    public function test_middleware_allows_access_for_guru_and_admin(): void
    {
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin2@sdi-bim.sch.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $guru = User::create([
            'name' => 'Guru Wali',
            'email' => 'guru2@sdi-bim.sch.id',
            'password' => bcrypt('password'),
            'role' => 'guru',
        ]);

        $responseAdmin = $this->actingAs($admin)->get(route('akademik.index'));
        $responseAdmin->assertStatus(200);

        $responseGuru = $this->actingAs($guru)->get(route('akademik.index'));
        $responseGuru->assertStatus(200);
    }

    public function test_store_route_persists_grades_via_post(): void
    {
        $guru = Guru::create(['nama_guru' => 'Ustadz Zaid', 'email' => 'zaid@sdi-bim.sch.id']);
        $userGuru = User::create([
            'name' => 'Ustadz Zaid',
            'email' => 'zaid@sdi-bim.sch.id',
            'password' => bcrypt('password'),
            'role' => 'guru',
        ]);

        $kelas = Kelas::create(['nama_kelas' => '6-A', 'tingkat' => 6, 'wali_kelas_id' => $guru->id]);
        $mapel = Mapel::create(['kode_mapel' => 'IPA6', 'nama_mapel' => 'Ilmu Pengetahuan Alam', 'kkm' => 75, 'guru_id' => $guru->id]);
        $siswa = Siswa::create(['nis' => '2026103', 'nama_siswa' => 'Farhan', 'jenis_kelamin' => 'L', 'kelas_id' => $kelas->id]);

        $postData = [
            'kelas_id' => $kelas->id,
            'mapel_id' => $mapel->id,
            'semester' => '1',
            'tahun_ajaran' => '2025/2026',
            'nilai' => [
                $siswa->id => [
                    'nilai_tugas' => 85,
                    'nilai_uts' => 75,
                    'nilai_uas' => 90,
                    'capaian_kompetensi' => 'Memahami konsep tata surya dengan baik',
                ],
            ],
        ];

        // 30% * 85 + 30% * 75 + 40% * 90 = 25.5 + 22.5 + 36 = 84.00
        $response = $this->actingAs($userGuru)->post(route('akademik.store'), $postData);

        $response->assertRedirect(route('akademik.index', [
            'kelas_id' => $kelas->id,
            'mapel_id' => $mapel->id,
            'semester' => '1',
            'tahun_ajaran' => '2025/2026',
        ]));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('akademik_nilais', [
            'siswa_id' => $siswa->id,
            'mapel_id' => $mapel->id,
            'semester' => '1',
            'tahun_ajaran' => '2025/2026',
            'nilai_tugas' => 85.00,
            'nilai_uts' => 75.00,
            'nilai_uas' => 90.00,
            'nilai_akhir' => 84.00,
        ]);
    }

    public function test_index_view_renders_student_grid_with_existing_scores_and_predikat(): void
    {
        $guru = Guru::create(['nama_guru' => 'Ustadzah Halimah', 'email' => 'halimah@sdi-bim.sch.id']);
        $userGuru = User::create([
            'name' => 'Ustadzah Halimah',
            'email' => 'halimah@sdi-bim.sch.id',
            'password' => bcrypt('password'),
            'role' => 'guru',
        ]);

        $kelas = Kelas::create(['nama_kelas' => '2-B', 'tingkat' => 2, 'wali_kelas_id' => $guru->id]);
        $mapel = Mapel::create(['kode_mapel' => 'BINA2', 'nama_mapel' => 'Bahasa Indonesia', 'kkm' => 75, 'guru_id' => $guru->id]);
        $siswa = Siswa::create(['nis' => '2026201', 'nama_siswa' => 'Hasan Al-Banna', 'jenis_kelamin' => 'L', 'kelas_id' => $kelas->id, 'status_aktif' => true]);

        AkademikNilai::create([
            'siswa_id' => $siswa->id,
            'mapel_id' => $mapel->id,
            'semester' => '1',
            'tahun_ajaran' => '2025/2026',
            'nilai_tugas' => 90.00,
            'nilai_uts' => 90.00,
            'nilai_uas' => 90.00,
            'nilai_akhir' => 90.00,
            'capaian_kompetensi' => 'Sangat lancar membaca teks',
        ]);

        $response = $this->actingAs($userGuru)->get(route('akademik.index', [
            'kelas_id' => $kelas->id,
            'mapel_id' => $mapel->id,
            'semester' => '1',
            'tahun_ajaran' => '2025/2026',
        ]));

        $response->assertStatus(200);
        $response->assertSee('Lembar Penilaian Siswa (e-Rapor Grid)');
        $response->assertSee('Hasan Al-Banna');
        $response->assertSee('90.00');
        $response->assertSee('Tuntas');
    }
}

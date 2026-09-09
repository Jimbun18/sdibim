<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('akademik_nilais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')
                ->constrained('siswas')
                ->cascadeOnDelete();
            $table->foreignId('mapel_id')
                ->constrained('mapels')
                ->cascadeOnDelete();
            $table->enum('semester', ['1', '2'])->default('1');
            $table->string('tahun_ajaran', 15)->default('2025/2026');
            $table->decimal('nilai_tugas', 5, 2)->nullable();
            $table->decimal('nilai_uts', 5, 2)->nullable();
            $table->decimal('nilai_uas', 5, 2)->nullable();
            $table->decimal('nilai_akhir', 5, 2)->nullable();
            $table->text('capaian_kompetensi')->nullable();
            $table->timestamps();

            // Mencegah duplikasi nilai untuk siswa, mapel, semester, dan tahun ajaran yang sama
            $table->unique(['siswa_id', 'mapel_id', 'semester', 'tahun_ajaran']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akademik_nilais');
    }
};

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
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')
                ->constrained('siswas')
                ->cascadeOnDelete();
            $table->date('tanggal')->index();
            $table->enum('status', ['H', 'I', 'S', 'A'])->default('H'); // H: Hadir, I: Izin, S: Sakit, A: Alpa
            $table->string('keterangan')->nullable();
            $table->timestamps();

            // Mencegah duplikasi absensi siswa pada tanggal yang sama
            $table->unique(['siswa_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};

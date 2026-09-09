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
        Schema::create('keuangan_spps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')
                ->constrained('siswas')
                ->cascadeOnDelete();
            $table->string('bulan', 20); // Contoh: Juli, Agustus, September, dst.
            $table->unsignedSmallInteger('tahun'); // Contoh: 2026
            $table->decimal('nominal', 12, 2)->default(0);
            $table->enum('status_bayar', ['belum_lunas', 'lunas'])->default('belum_lunas')->index();
            $table->timestamp('tanggal_bayar')->nullable();
            $table->string('metode_bayar', 50)->nullable(); // Tunai, Transfer Bank, dll.
            $table->string('catatan')->nullable();
            $table->timestamps();

            // Mencegah duplikasi tagihan SPP siswa pada bulan dan tahun yang sama
            $table->unique(['siswa_id', 'bulan', 'tahun']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangan_spps');
    }
};

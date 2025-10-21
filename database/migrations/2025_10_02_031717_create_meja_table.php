<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration
     */
    public function up(): void
    {
        Schema::create('meja', function (Blueprint $table) {
            $table->bigIncrements('id_meja'); // primary key dengan nama khusus
            $table->string('nomor_meja')->unique(); // contoh: M01, M02
            $table->enum('status', ['tersedia', 'dipesan', 'sedang digunakan'])->default('tersedia');
            $table->timestamp('waktu_tersedia')->nullable();
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Rollback migration
     */
    public function down(): void
    {
        Schema::dropIfExists('meja');
    }
};

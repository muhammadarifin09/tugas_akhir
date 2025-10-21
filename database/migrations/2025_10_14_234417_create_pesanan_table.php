<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->unsignedBigInteger('id_meja')->nullable();
            $table->enum('tipe_pesanan', ['makan_ditempat', 'dibawa_pulang']);
            $table->decimal('total_harga', 10, 2)->default(0);
            $table->enum('status', ['pending', 'proses', 'selesai', 'batal'])->default('pending');
            $table->timestamp('tanggal_pesanan')->useCurrent();
            $table->timestamps();

            // Relasi ke tabel meja (opsional, bisa null kalau takeaway)
            $table->foreign('id_meja')->references('id_meja')->on('meja')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};

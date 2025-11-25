<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('keranjang', function (Blueprint $table) {
            $table->bigIncrements('id_keranjang');

            $table->unsignedBigInteger('id_user');
            $table->enum('tipe_pesanan', ['makan_ditempat', 'dibawa_pulang']);
            $table->unsignedBigInteger('id_meja')->nullable(); // hanya untuk makan ditempat

            $table->timestamps();

            // Relasi
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_meja')->references('id_meja')->on('meja')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keranjang');
    }
};

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
        Schema::create('produk', function (Blueprint $table) {
            $table->id('id_produk'); // Primary key
            $table->string('nama_produk'); // Nama makanan/minuman
            $table->enum('jenis', ['makanan', 'minuman']); // Jenis produk
            $table->decimal('harga', 10, 2); // Harga dengan 2 angka desimal
            $table->integer('stok')->default(0); // Stok awal 0
            $table->string('gambar')->nullable(); // Path gambar
            $table->text('deskripsi')->nullable(); // Deskripsi produk
            $table->timestamps(); // created_at dan updated_at
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};

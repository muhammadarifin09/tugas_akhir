<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('keranjang_item', function (Blueprint $table) {
            $table->bigIncrements('id_item');

            $table->unsignedBigInteger('id_keranjang');
            $table->unsignedBigInteger('id_produk');

            $table->integer('qty')->default(1);
            $table->text('catatan')->nullable();

            // harga yang disimpan saat dimasukkan ke keranjang (jaga-jaga harga produk berubah)
            $table->decimal('harga_saat_dipesan', 10, 2);

            $table->timestamps();

            // Relasi
            $table->foreign('id_keranjang')->references('id_keranjang')->on('keranjang')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keranjang_item');
    }
};

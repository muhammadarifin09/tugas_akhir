<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('laporan', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_pesanan')->unique();
        $table->string('nama_pelanggan');
        $table->timestamp('tanggal_pesanan');
        $table->decimal('total_bayar', 10, 2);
        $table->enum('metode_pembayaran', ['cod', 'transfer']);
        $table->enum('tipe_pesanan', ['makan_ditempat', 'dibawa_pulang']);
        $table->enum('status', ['pending', 'proses', 'selesai', 'batal']);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};

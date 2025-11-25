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
    Schema::table('keranjang', function (Blueprint $table) {
        $table->string('nama_pelanggan')->nullable();
        $table->string('no_wa')->nullable();
        $table->text('alamat')->nullable();
    });
}

public function down()
{
    Schema::table('keranjang', function (Blueprint $table) {
        $table->dropColumn(['nama_pelanggan', 'no_wa', 'alamat']);
    });
}

};

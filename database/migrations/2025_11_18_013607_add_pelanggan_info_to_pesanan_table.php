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
        Schema::table('pesanan', function (Blueprint $table) {
            $table->string('nama_pelanggan')->after('id_meja');
            $table->string('no_wa')->after('nama_pelanggan');
            $table->text('alamat')->after('no_wa');
        });
    }

    public function down()
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropColumn(['nama_pelanggan', 'no_wa', 'alamat']);
        });
    }

};

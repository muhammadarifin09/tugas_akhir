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
    Schema::table('meja', function (Blueprint $table) {
        $table->text('deskripsi')->nullable()->after('gambar');
        $table->integer('kapasitas')->default(4)->after('nomor_meja');
    });
}

public function down()
{
    Schema::table('meja', function (Blueprint $table) {
        $table->dropColumn(['deskripsi', 'kapasitas']);
    });
}

};

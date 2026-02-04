<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('meja', function (Blueprint $table) {

            // ✅ pastikan kolom status ada
            if (!Schema::hasColumn('meja', 'status')) {
                $table->enum('status', ['tersedia', 'dipesan', 'sedang digunakan'])
                      ->default('tersedia')
                      ->after('kapasitas');
            }

        });

        // ❗ DROP KOLOM SECARA AMAN (cek satu per satu)
        if (Schema::hasColumn('meja', 'tanggal_pesan')) {
            Schema::table('meja', fn (Blueprint $table) => $table->dropColumn('tanggal_pesan'));
        }

        if (Schema::hasColumn('meja', 'jam_mulai')) {
            Schema::table('meja', fn (Blueprint $table) => $table->dropColumn('jam_mulai'));
        }

        if (Schema::hasColumn('meja', 'jam_selesai')) {
            Schema::table('meja', fn (Blueprint $table) => $table->dropColumn('jam_selesai'));
        }
    }

    public function down()
    {
        //
    }
};

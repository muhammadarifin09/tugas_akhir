<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Untuk MySQL
        DB::statement("ALTER TABLE pesanan MODIFY COLUMN status ENUM('pending', 'proses', 'selesai', 'batal', 'menunggu_pembayaran') DEFAULT 'pending'");
        
        // Atau untuk database lain, gunakan approach yang sesuai
    }

    public function down()
    {
        // Rollback - kembalikan ke enum sebelumnya
        DB::statement("ALTER TABLE pesanan MODIFY COLUMN status ENUM('pending', 'proses', 'selesai', 'batal') DEFAULT 'pending'");
    }
};
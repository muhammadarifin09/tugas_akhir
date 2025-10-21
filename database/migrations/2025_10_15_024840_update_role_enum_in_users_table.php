<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1️⃣ Tambahkan nilai baru 'pelanggan' ke ENUM
        DB::statement("
            ALTER TABLE users 
            MODIFY COLUMN role ENUM('admin', 'pegawai', 'pengguna', 'pelanggan') 
            NOT NULL DEFAULT 'pengguna'
        ");

        // 2️⃣ Ubah semua 'pengguna' menjadi 'pelanggan'
        DB::statement("UPDATE users SET role = 'pelanggan' WHERE role = 'pengguna'");

        // 3️⃣ Hapus nilai lama 'pengguna' dari ENUM
        DB::statement("
            ALTER TABLE users 
            MODIFY COLUMN role ENUM('admin', 'pegawai', 'pelanggan') 
            NOT NULL DEFAULT 'pelanggan'
        ");
    }

    public function down(): void
    {
        // Rollback — jika ingin kembali ke versi lama
        DB::statement("
            ALTER TABLE users 
            MODIFY COLUMN role ENUM('admin', 'pegawai', 'pelanggan', 'pengguna') 
            NOT NULL DEFAULT 'pelanggan'
        ");

        DB::statement("UPDATE users SET role = 'pengguna' WHERE role = 'pelanggan'");

        DB::statement("
            ALTER TABLE users 
            MODIFY COLUMN role ENUM('admin', 'pegawai', 'pengguna') 
            NOT NULL DEFAULT 'pengguna'
        ");
    }
};

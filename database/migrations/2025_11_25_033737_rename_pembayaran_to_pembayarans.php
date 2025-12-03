<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('pembayaran', 'pembayarans');
    }

    public function down(): void
    {
        Schema::rename('pembayarans', 'pembayaran');
    }
};

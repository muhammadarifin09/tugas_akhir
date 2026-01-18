<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('meja', function (Blueprint $table) {
            $table->integer('kapasitas')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('meja', function (Blueprint $table) {
            $table->integer('kapasitas')->default(4)->change();
        });
    }
};


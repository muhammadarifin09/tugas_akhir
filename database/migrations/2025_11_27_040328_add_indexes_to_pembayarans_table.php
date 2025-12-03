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
    Schema::table('pembayarans', function (Blueprint $table) {
        if (!Schema::hasColumn('pembayarans', 'midtrans_order_id')) {
            $table->string('midtrans_order_id')->nullable()->index();
        } else {
            $table->index('midtrans_order_id');
        }
        if (!Schema::hasColumn('pembayarans', 'transaction_id')) {
            $table->string('transaction_id')->nullable()->unique();
        } else {
            // ensure unique index exists externally if desired
        }
        if (!Schema::hasColumn('pembayarans', 'id_pesanan')) {
            $table->unsignedBigInteger('id_pesanan')->nullable()->index();
        }
        // optional foreign key:
        // $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanans')->onDelete('cascade');
    });
}
public function down()
{
    Schema::table('pembayarans', function (Blueprint $table) {
        $table->dropIndex(['midtrans_order_id']);
        // $table->dropForeign(['id_pesanan']);
    });
}

};

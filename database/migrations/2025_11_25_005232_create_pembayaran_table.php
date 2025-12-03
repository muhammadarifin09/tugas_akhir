<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranTable extends Migration
{
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->unsignedBigInteger('id_pesanan')->index(); // FK ke pesanan.id_pesanan
            $table->string('midtrans_order_id')->nullable()->index(); // ORDER-...
            $table->string('transaction_id')->nullable()->unique(); // id transaksi midtrans
            $table->string('payment_type')->nullable(); // e.g. bank_transfer, gopay, credit_card
            $table->enum('status', ['pending','settlement','capture','deny','expire','cancel','refund','failed'])->default('pending');
            $table->decimal('gross_amount', 12, 2)->nullable(); // jumlah dari midtrans
            $table->json('raw_payload')->nullable(); // simpan payload notifikasi mentah
            $table->timestamp('received_at')->nullable();
            $table->timestamps();

            // FK (opsional)
            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pembayaran');
    }
}


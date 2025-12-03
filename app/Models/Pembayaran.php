<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayarans';

    // PENTING: primary key custom
    protected $primaryKey = 'id_pembayaran';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_pesanan',
        'midtrans_order_id',
        'transaction_id',
        'payment_type',
        'status',
        'gross_amount',
        'raw_payload',
        'received_at',
    ];

    protected $casts = [
        'raw_payload' => 'array',
        'gross_amount' => 'decimal:2',
        'received_at' => 'datetime',
    ];
}

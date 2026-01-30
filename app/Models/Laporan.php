<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';

    protected $fillable = [
        'id_pesanan',
        'nama_pelanggan',
        'tanggal_pesanan',
        'total_bayar',
        'metode_pembayaran',
        'tipe_pesanan',
        'status',
    ];
}


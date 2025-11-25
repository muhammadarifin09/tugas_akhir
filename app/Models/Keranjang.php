<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';

    protected $fillable = [
    'id_user',
    'nama_pelanggan',
    'no_wa',
    'alamat',
    'tipe_pesanan',
    'id_meja',
    'metode_pembayaran'
];


    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function meja()
    {
        return $this->belongsTo(Meja::class, 'id_meja', 'id_meja');
    }

    public function items()
    {
        return $this->hasMany(KeranjangItem::class, 'id_keranjang', 'id_keranjang');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';

    protected $fillable = [
        'id_user',
        'id_meja',
        'tipe_pesanan',
        'total_harga',
        'snap_token',
        'status',
        'tanggal_pesanan',
        'nama_pelanggan',
        'no_wa',
        'alamat',
        'metode_pembayaran'
    ];

    public $incrementing = true;
    protected $keyType = 'int';

    // Relasi ke meja
    public function meja()
    {
        return $this->belongsTo(Meja::class, 'id_meja', 'id_meja');
    }

    // Relasi ke detail pesanan
    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function details()
{
    return $this->hasMany(DetailPesanan::class, 'id_pesanan');
}

}

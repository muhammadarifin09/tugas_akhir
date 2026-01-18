<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    use HasFactory;

    // Nama tabel kustom
    protected $table = 'meja';

    // Primary key kustom
    protected $primaryKey = 'id_meja';

    // Kolom yang boleh diisi (mass assignable)
    protected $fillable = [
    'nomor_meja',
    'kapasitas',
    'deskripsi',
    'status',
    'waktu_tersedia',
    'gambar',
];

    // Kalau primary key bukan increment integer standar
    public $incrementing = true;

    // Kalau primary key bukan tipe integer bisa diubah jadi false dan ganti $keyType
    protected $keyType = 'int';

    public function getRouteKeyName()
{
    return 'id_meja';
}

}

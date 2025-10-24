<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class PesananPelangganController extends Controller
{
    // Halaman daftar pesanan aktif
    public function index()
    {
        $pesanan = Pesanan::with(['detailPesanan.produk', 'meja'])
            ->where('id_user', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                // Hitung total harga setiap pesanan
                $item->total_harga = $item->detailPesanan->sum(function ($detail) {
                    return $detail->jumlah * $detail->produk->harga;
                });
                return $item;
            });

        return view('pelanggan.pesanan', compact('pesanan'));
    }

    // Halaman riwayat pesanan
    public function riwayat()
{
    $user = Auth::user();

    // Ambil pesanan dengan pagination
    $pesanan = Pesanan::where('id_user', $user->id)
        ->with(['detailPesanan.produk', 'meja'])
        ->orderBy('created_at', 'desc')
        ->paginate(5); // 🔹 Tampilkan 5 data per halaman

    // Hitung total harga setiap pesanan
    foreach ($pesanan as $item) {
        $item->total_harga = $item->detailPesanan->sum(function ($detail) {
            return $detail->jumlah * ($detail->produk->harga ?? 0);
        });
    }

    return view('pelanggan.pesanan', compact('pesanan'));
}

}

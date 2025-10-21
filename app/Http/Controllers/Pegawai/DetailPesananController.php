<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DetailPesanan;
use App\Models\Pesanan;
use App\Models\Produk;

class DetailPesananController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_pesanan' => 'required|exists:pesanan,id_pesanan',
            'id_produk' => 'required|exists:produk,id_produk',
            'jumlah' => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->id_produk);
        $subtotal = $produk->harga * $request->jumlah;

        DetailPesanan::create([
            'id_pesanan' => $request->id_pesanan,
            'id_produk' => $request->id_produk,
            'jumlah' => $request->jumlah,
            'subtotal' => $subtotal,
        ]);

        // Update total harga pesanan
        $pesanan = Pesanan::with('detailPesanan')->find($request->id_pesanan);
        $pesanan->update([
            'total_harga' => $pesanan->detailPesanan->sum('subtotal'),
            'status' => 'proses'
        ]);

        return back()->with('success', 'Produk berhasil ditambahkan ke pesanan.');
    }
}

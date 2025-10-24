<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Produk;
use App\Models\Meja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class PesanController extends Controller
{
    public function index()
    {
        $produks = Produk::all();
        $mejas = Meja::where('status', 'tersedia')->orderBy('nomor_meja')->get();

        return view('pesan', compact('produks', 'mejas'));
    }

    public function store(Request $request)
{
    // Validasi
    $request->validate([
        'id_produk' => 'required|array|min:1',
        'id_produk.*' => 'exists:produk,id_produk',
        'jumlah' => 'required|array|min:1',
        'jumlah.*' => 'integer|min:1',
        'tipe_pesanan' => 'required|string',
        'id_meja' => 'nullable|exists:mejas,id_meja',
    ]);

    // Hitung total harga
    $total_harga = 0;
    foreach ($request->id_produk as $key => $id_produk) {
        $produk = Produk::find($id_produk);
        $total_harga += $produk->harga * $request->jumlah[$key];
    }

    // Simpan pesanan utama
    $pesanan = Pesanan::create([
        'id_user' => Auth::id(),
        'id_meja' => $request->tipe_pesanan == 'makan_ditempat' ? $request->id_meja : null,
        'tipe_pesanan' => $request->tipe_pesanan,
        //'status' => 'menunggu',
        'total_harga' => $total_harga,
    ]);

    // Simpan detail pesanan
    foreach ($request->id_produk as $key => $id_produk) {
        DetailPesanan::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'id_produk' => $id_produk,
            'jumlah' => $request->jumlah[$key],
            'subtotal' => Produk::find($id_produk)->harga * $request->jumlah[$key],
        ]);
    }

    // Ubah status meja jadi 'dipakai' jika makan di tempat
    if ($request->tipe_pesanan == 'makan_ditempat' && $request->id_meja) {
        Meja::where('id_meja', $request->id_meja)->update(['status' => 'dipakai']);
    }

    return redirect()->route('pesan')->with('success', 'Pesanan berhasil dibuat!');
}
}

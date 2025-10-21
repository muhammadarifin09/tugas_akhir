<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Meja;
use Illuminate\Support\Facades\Auth;


class PemesananController extends Controller
{
    public function create($id)
    {
        $produk = Produk::findOrFail($id);
        $meja = Meja::where('status', 'tersedia')->get();

        return view('pelanggan.pesan', compact('produk', 'meja'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe_pesanan' => 'required|in:makan_ditempat,dibawa_pulang',
            'id_meja' => 'nullable|exists:meja,id_meja',
            'id_produk' => 'required|exists:produk,id_produk',
            'jumlah' => 'required|integer|min:1'
        ]);

        // Buat pesanan baru
        $pesanan = Pesanan::create([
             'id_user' => Auth::id(),
            'id_meja' => $request->tipe_pesanan == 'makan_ditempat' ? $request->id_meja : null,
            'tipe_pesanan' => $request->tipe_pesanan,
            'status' => 'pending',
            'total_harga' => 0,
        ]);

        // Ambil produk yang dipesan
        $produk = Produk::find($request->id_produk);
        $subtotal = $produk->harga * $request->jumlah;

        // Simpan detail pesanan
        DetailPesanan::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'id_produk' => $produk->id_produk,
            'jumlah' => $request->jumlah,
            'subtotal' => $subtotal,
            'harga_satuan' => $produk->harga,
        ]);

        // Update total harga di tabel pesanan
        $pesanan->update(['total_harga' => $subtotal]);

        // Ubah status meja jika makan di tempat
        if ($pesanan->id_meja) {
            $pesanan->meja->update(['status' => 'dipesan']);
        }

        return redirect()->route('beranda')->with('success', 'Pesanan berhasil dikirim!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Produk;
use App\Models\Meja;
use App\Models\Keranjang;
use App\Models\KeranjangItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesanController extends Controller
{
    public function index()
    {
        $produks = Produk::all();
        $mejas = Meja::where('status', 'tersedia')->orderBy('nomor_meja')->get();

        // OPTIONAL: tampilkan data keranjang
        $keranjang = Keranjang::where('id_user', Auth::id())->first();
        $items = $keranjang ? $keranjang->items : collect([]);

        return view('pesan', compact('produks', 'mejas', 'keranjang', 'items'));
    }

    // proses dari keranjang → buat pesanan
    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:100',
            'no_wa' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'tipe_pesanan' => 'required|string',
            'id_meja' => 'nullable|exists:meja,id_meja',
        ]);

        $keranjang = Keranjang::where('id_user', Auth::id())->first();
        if (!$keranjang) {
            return back()->with('error', 'Keranjang tidak ditemukan.');
        }

        $items = KeranjangItem::where('id_keranjang', $keranjang->id_keranjang)->get();
        if ($items->isEmpty()) {
            return back()->with('error', 'Keranjang masih kosong.');
        }

        // Hitung total harga
        $total_harga = 0;
        foreach ($items as $item) {
            $total_harga += $item->qty * $item->harga_saat_dipesan;
        }

        // Buat pesanan baru
        $pesanan = Pesanan::create([
            'id_user' => Auth::id(),
            'id_meja' => $request->tipe_pesanan == 'makan_ditempat' ? $request->id_meja : null,
            'tipe_pesanan' => $request->tipe_pesanan,
            'total_harga' => $total_harga,

            // info pelanggan
            'nama_pelanggan' => $request->nama_pelanggan,
            'no_wa' => $request->no_wa,
            'alamat' => $request->alamat,
        ]);

        // Simpan detail pesanan
        foreach ($items as $item) {
            DetailPesanan::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'id_produk'  => $item->id_produk,
                'jumlah'     => $item->qty,
                'subtotal'   => $item->qty * $item->harga_saat_dipesan,
            ]);
        }

        // Update status meja jika makan di tempat
        if ($request->tipe_pesanan == 'makan_ditempat' && $request->id_meja) {
            Meja::where('id_meja', $request->id_meja)
                ->update(['status' => 'sedang digunakan']);
        }

        // Kosongkan keranjang
        KeranjangItem::where('id_keranjang', $keranjang->id_keranjang)->delete();
        $keranjang->delete();

        return redirect()->route('pesan')->with('success', 'Pesanan berhasil dibuat!');
    }
}

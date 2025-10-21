<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\Meja;
use Illuminate\Support\Facades\Auth;

class BerandaController extends Controller
{
    public function index()
    {
        // Ambil semua produk
        $produks = Produk::all();

        // Ambil semua meja (jika makan di tempat)
        $mejas = Meja::all();

        // Default nilai pesanan = koleksi kosong
        $pesanan = collect();

        // Jika user login dan rolenya pelanggan, ambil pesanan
        if (Auth::check() && Auth::user()->role == 'pelanggan') {
            $pesanan = Pesanan::with(['detailPesanan.produk'])
                ->where('id_user', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // Kirim data ke view
        return view('beranda', compact('produks', 'mejas', 'pesanan'));
    }
}

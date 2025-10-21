<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class PesananPelangganController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::with(['detailPesanan.produk', 'meja'])
            ->where('id_user', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pelanggan.pesanan', compact('pesanan'));
    }

    public function riwayat()
{
    $user = Auth::user();

    $pesanan = Pesanan::where('id_user', $user->id)
        ->with('detailPesanan.produk') // relasi berantai
        ->orderBy('created_at', 'desc')
        ->get();

    return view('pelanggan.pesanan', compact('pesanan'));
}


}

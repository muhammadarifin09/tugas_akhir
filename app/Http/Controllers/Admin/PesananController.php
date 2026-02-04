<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::with(['meja', 'detailPesanan.produk'])
            ->orderByDesc('id_pesanan')
            ->paginate(10);

        return view('admin.pesanan.index', compact('pesanan'));
    }

    public function show(Pesanan $pesanan)
    {
        $pesanan->load(['meja', 'detailPesanan.produk']);

        return view('admin.pesanan.show', compact('pesanan'));
    }
}

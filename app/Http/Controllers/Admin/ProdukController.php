<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Tampilkan menu produk di dashboard admin
     */
    public function index()
    {
        $produks = Produk::orderBy('jenis')
            ->orderBy('nama_produk')
            ->get();

        return view('admin.produk.index', compact('produks'));
    }

    /**
     * Tampilkan detail produk
     */
    public function show(Produk $produk)
    {
        return view('admin.produk.show', compact('produk'));
    }
}

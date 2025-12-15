<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class PublicReceiptController extends Controller
{
    // Signed URL view
    public function showSigned($id)
    {
        $pesanan = Pesanan::with('detailPesanan.produk')->findOrFail($id);
        return view('receipt_public', compact('pesanan'));
    }

    // If you prefer direct public url pointing to stored png file
    public function showPublic($id)
    {
        $pesanan = Pesanan::with('detailPesanan.produk')->findOrFail($id);
        // If you stored receipt_url in DB, you can redirect to that
        if ($pesanan->receipt_url) {
            return redirect($pesanan->receipt_url);
        }
        return view('receipt_public', compact('pesanan'));
    }
}

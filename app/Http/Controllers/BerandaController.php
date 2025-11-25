<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\Meja;
use App\Models\Keranjang;
use App\Models\KeranjangItem;
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

        // Hitung jumlah item di keranjang
        $cartCount = 0;
        $keranjang = null;

        // Jika user login, ambil data keranjang dan pesanan
        if (Auth::check()) {
            // Ambil pesanan untuk pelanggan
            if (Auth::user()->role == 'pelanggan') {
                $pesanan = Pesanan::with(['detailPesanan.produk'])
                    ->where('id_user', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->get();
            }

            // Ambil data keranjang
            $keranjang = Keranjang::where('id_user', Auth::id())->first();
            if ($keranjang) {
                $cartCount = $keranjang->items()->sum('qty');
            }
        }

        // Kirim data ke view
        return view('beranda', compact('produks', 'mejas', 'pesanan', 'cartCount', 'keranjang'));
    }

    public function menuMeja()
{
    $produks = Produk::all();
    $mejas = Meja::orderBy('nomor_meja')->get();

    // Hitung jumlah item di keranjang dan total harga
    $cartCount = 0;
    $totalHarga = 0;
    $keranjang = null;
    
    if (Auth::check()) {
        $keranjang = Keranjang::where('id_user', Auth::id())->first();
        if ($keranjang) {
            $cartCount = $keranjang->items()->sum('qty');
            // Hitung total harga
            foreach ($keranjang->items as $item) {
                $totalHarga += $item->qty * $item->harga_saat_dipesan;
            }
        }
    }

    return view('menu_meja', compact('produks', 'mejas', 'cartCount', 'keranjang', 'totalHarga'));
}

    /**
     * Method untuk handle Ajax add to cart
     */
   public function tambahKeKeranjang(Request $request)
{
    if (!Auth::check()) {
        return response()->json([
            'success' => false,
            'message' => 'Silakan login terlebih dahulu'
        ], 401);
    }

    $request->validate([
        'id_produk' => 'required|exists:produk,id_produk',
        'jumlah' => 'required|integer|min:1|max:10',
    ]);

    try {
        // Cari atau buat keranjang user
        $keranjang = Keranjang::firstOrCreate(
            ['id_user' => Auth::id()],
            [
                'nama_pelanggan' => Auth::user()->name,
                'no_wa' => Auth::user()->phone ?? '081234567890',
                'tipe_pesanan' => 'makan_ditempat',
                'metode_pembayaran' => 'cod',
            ]
        );

        $produk = Produk::findOrFail($request->id_produk);

        // Cek apakah item sudah ada di keranjang
        $existingItem = KeranjangItem::where('id_keranjang', $keranjang->id_keranjang)
            ->where('id_produk', $request->id_produk)
            ->first();

        if ($existingItem) {
            // Update quantity
            $newQty = $existingItem->qty + $request->jumlah;
            if ($newQty > 10) {
                return response()->json([
                    'success' => false,
                    'message' => 'Maksimal quantity per item adalah 10'
                ]);
            }
            $existingItem->update(['qty' => $newQty]);
        } else {
            // Tambah item baru
            KeranjangItem::create([
                'id_keranjang' => $keranjang->id_keranjang,
                'id_produk' => $request->id_produk,
                'qty' => $request->jumlah,
                'harga_saat_dipesan' => $produk->harga,
            ]);
        }

        // Hitung ulang total item dan total harga
        $cartCount = KeranjangItem::where('id_keranjang', $keranjang->id_keranjang)->sum('qty');
        $totalHarga = 0;
        
        $items = KeranjangItem::where('id_keranjang', $keranjang->id_keranjang)->get();
        foreach ($items as $item) {
            $totalHarga += $item->qty * $item->harga_saat_dipesan;
        }

        return response()->json([
            'success' => true,
            'message' => $produk->nama_produk . ' berhasil ditambahkan ke keranjang!',
            'cartCount' => $cartCount,
            'totalHarga' => $totalHarga
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Method untuk get cart count (bisa digunakan untuk Ajax update)
     */
    public function getCartCount()
    {
        $cartCount = 0;
        if (Auth::check()) {
            $keranjang = Keranjang::where('id_user', Auth::id())->first();
            if ($keranjang) {
                $cartCount = $keranjang->items()->sum('qty');
            }
        }

        return response()->json([
            'cartCount' => $cartCount
        ]);
    }

    public function getCartData()
{
    $cartCount = 0;
    $totalHarga = 0;
    
    if (Auth::check()) {
        $keranjang = Keranjang::where('id_user', Auth::id())->first();
        if ($keranjang) {
            $cartCount = $keranjang->items()->sum('qty');
            foreach ($keranjang->items as $item) {
                $totalHarga += $item->qty * $item->harga_saat_dipesan;
            }
        }
    }

    return response()->json([
        'cartCount' => $cartCount,
        'totalHarga' => $totalHarga
    ]);
}
}
<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\KeranjangItem;
use App\Models\Produk;
use App\Models\Meja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjang = Keranjang::where('id_user', Auth::id())->first();
        $mejas = Meja::where('status', 'tersedia')->orderBy('nomor_meja')->get();

        return view('keranjang.index', [
            'keranjang' => $keranjang,
            'items' => $keranjang ? $keranjang->items : [],
            'mejas' => $mejas // Tambahkan ini
        ]);
    }


    public function tambah(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        // VALIDASI DASAR
        $request->validate([
            'nama_pelanggan' => 'required|string|max:100',
            'no_wa' => 'required|string|max:20',
            'tipe_pesanan' => 'required|in:makan_ditempat,dibawa_pulang',
            'id_produk' => 'required|array',
            'id_produk.*' => 'exists:produk,id_produk',
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1',
            'metode_pembayaran' => 'required|in:cod,transfer',
        ]);

        // VALIDASI TAMBAHAN: jika makan di tempat → wajib pilih meja
        if ($request->tipe_pesanan === 'makan_ditempat') {
            $request->validate([
                'id_meja' => 'required|exists:meja,id_meja',
            ]);
        }

        // VALIDASI TAMBAHAN: jika dibawa pulang → wajib isi alamat
        if ($request->tipe_pesanan === 'dibawa_pulang') {
            $request->validate([
                'alamat' => 'required|string|max:255',
            ]);
        }

        // 1. Ambil atau buat keranjang user
        $keranjang = Keranjang::updateOrCreate(
            ['id_user' => Auth::id()],
            [
                'nama_pelanggan' => $request->nama_pelanggan,
                'no_wa' => $request->no_wa,
                'alamat' => $request->tipe_pesanan === 'dibawa_pulang' ? $request->alamat : null,
                'tipe_pesanan' => $request->tipe_pesanan,
                'id_meja' => $request->tipe_pesanan === 'makan_ditempat' ? $request->id_meja : null,
                'metode_pembayaran' => $request->metode_pembayaran,
            ]
        );

        // 2. Tambahkan item ke keranjang
        foreach ($request->id_produk as $key => $id_produk) {

            $produk = Produk::find($id_produk);
            if (!$produk) continue;

            $qty = $request->jumlah[$key];

            $item = KeranjangItem::where('id_keranjang', $keranjang->id_keranjang)
                ->where('id_produk', $id_produk)
                ->first();

            if ($item) {
                // update qty
                $item->update([
                    'qty' => $item->qty + $qty,
                ]);
            } else {
                // insert baru
                KeranjangItem::create([
                    'id_keranjang' => $keranjang->id_keranjang,
                    'id_produk' => $id_produk,
                    'qty' => $qty,
                    'harga_saat_dipesan' => $produk->harga,
                ]);
            }
        }

        return redirect()->route('keranjang')->with('success', 'Berhasil ditambahkan ke keranjang!');
    }

    public function hapusItem($id)
    {
        KeranjangItem::where('id_item', $id)->delete();
        return back()->with('success', 'Item dihapus!');
    }

    public function kosongkan()
    {
        $keranjang = Keranjang::where('id_user', Auth::id())->first();

        if ($keranjang) {
            KeranjangItem::where('id_keranjang', $keranjang->id_keranjang)->delete();
            $keranjang->delete();
        }

        return back()->with('success', 'Keranjang dikosongkan!');
    }

   public function checkout(Request $request)
{
    // Validasi data dari form keranjang
    $request->validate([
        'nama_pelanggan' => 'required|string|max:100',
        'no_wa' => 'required|string|max:20',
        'tipe_pesanan' => 'required|in:makan_ditempat,dibawa_pulang',
        'id_meja' => 'nullable|required_if:tipe_pesanan,makan_ditempat|exists:meja,id_meja',
        'alamat' => 'nullable|required_if:tipe_pesanan,dibawa_pulang|string|max:255',
        'metode_pembayaran' => 'required|in:cod,transfer',
    ]);

    $keranjang = Keranjang::where('id_user', Auth::id())->first();
    
    if (!$keranjang || $keranjang->items->isEmpty()) {
        return redirect()->route('keranjang')->with('error', 'Keranjang masih kosong');
    }

    try {
        // Update data keranjang dengan input terbaru
        $keranjang->update([
            'nama_pelanggan' => $request->nama_pelanggan,
            'no_wa' => $request->no_wa,
            'tipe_pesanan' => $request->tipe_pesanan,
            'id_meja' => $request->tipe_pesanan === 'makan_ditempat' ? $request->id_meja : null,
            'alamat' => $request->tipe_pesanan === 'dibawa_pulang' ? $request->alamat : null,
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        // Redirect ke halaman proses checkout
        return redirect()->route('payment.redirect', $keranjang->id_keranjang);

    } catch (\Exception $e) {
        return redirect()->route('keranjang')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

    public function tambahAjax(Request $request)
{
    if (!Auth::check()) {
        return response()->json([
            'success' => false,
            'message' => 'Silakan login terlebih dahulu'
        ], 401);
    }

    $request->validate([
        'id_produk' => 'required|exists:produk,id_produk',
        'jumlah' => 'required|integer|min:1',
    ]);

    // Cari atau buat keranjang user
    $keranjang = Keranjang::firstOrCreate(
        ['id_user' => Auth::id()],
        [
            'nama_pelanggan' => Auth::user()->name,
            'no_wa' => Auth::user()->phone ?? '',
            'tipe_pesanan' => 'makan_ditempat', // default
            'metode_pembayaran' => 'cod', // default
        ]
    );

    $produk = Produk::find($request->id_produk);

    // Cek apakah item sudah ada di keranjang
    $existingItem = KeranjangItem::where('id_keranjang', $keranjang->id_keranjang)
        ->where('id_produk', $request->id_produk)
        ->first();

    if ($existingItem) {
        // Update quantity
        $existingItem->update([
            'qty' => $existingItem->qty + $request->jumlah
        ]);
    } else {
        // Tambah item baru
        KeranjangItem::create([
            'id_keranjang' => $keranjang->id_keranjang,
            'id_produk' => $request->id_produk,
            'qty' => $request->jumlah,
            'harga_saat_dipesan' => $produk->harga,
        ]);
    }

    $cartCount = $keranjang->items()->sum('qty');

    return response()->json([
        'success' => true,
        'message' => 'Produk berhasil ditambahkan ke keranjang!',
        'cartCount' => $cartCount
    ]);
}
}

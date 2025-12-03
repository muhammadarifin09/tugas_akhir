<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Keranjang;
use App\Models\KeranjangItem;
use App\Models\Meja;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function redirect($id_keranjang)
    {
        $keranjang = Keranjang::with(['items.produk', 'meja'])->find($id_keranjang);
        
        if (!$keranjang || $keranjang->id_user !== Auth::id()) {
            return redirect()->route('keranjang')->with('error', 'Keranjang tidak ditemukan');
        }

        if ($keranjang->items->isEmpty()) {
            return redirect()->route('keranjang')->with('error', 'Keranjang masih kosong');
        }

        // Validasi data wajib
        if (
            empty($keranjang->nama_pelanggan) || 
            empty($keranjang->no_wa) || 
            empty($keranjang->metode_pembayaran)
        ) {
            return redirect()->route('keranjang')->with('error', 'Silakan lengkapi data pelanggan terlebih dahulu');
        }

        return view('checkout.process', compact('keranjang'));
    }


    public function process(Request $request, $id_keranjang)
    {
        DB::beginTransaction();

        try {
            $keranjang = Keranjang::with(['items.produk', 'meja'])->find($id_keranjang);

            if (!$keranjang || $keranjang->id_user !== Auth::id()) {
                return redirect()->route('keranjang')->with('error', 'Keranjang tidak ditemukan');
            }

            // Validasi stok
            foreach ($keranjang->items as $item) {
                if ($item->produk->stok < $item->qty) {
                    return back()->with('error', "Stok {$item->produk->nama_produk} tidak mencukupi");
                }
            }

            // Hitung total
            $total_harga = (int) $keranjang->items->sum(function ($i) {
                return (int)$i->qty * (int)$i->harga_saat_dipesan;
            });


            // Status default
            $status = $keranjang->metode_pembayaran == 'cod'
                ? 'proses'
                : 'menunggu_pembayaran';

            // Handle alamat jika makan ditempat
            $alamat = $keranjang->tipe_pesanan === 'makan_ditempat'
                ? ''
                : $keranjang->alamat;

            // ========== BUAT PESANAN ==========
            $pesanan = Pesanan::create([
                'id_user'            => Auth::id(),
                'id_meja'            => $keranjang->id_meja,
                'tipe_pesanan'       => $keranjang->tipe_pesanan,
                'total_harga'        => $total_harga,
                'nama_pelanggan'     => $keranjang->nama_pelanggan,
                'no_wa'              => $keranjang->no_wa,
                'alamat'             => $alamat,
                'metode_pembayaran'  => $keranjang->metode_pembayaran,
                'status'             => $status,
                'snap_token'         => null,
            ]);

            // ========= DETAIL PESANAN + UPDATE STOK ==========
            foreach ($keranjang->items as $item) {
                DetailPesanan::create([
                    'id_pesanan'   => $pesanan->id_pesanan,
                    'id_produk'    => $item->id_produk,
                    'jumlah'       => $item->qty,
                    'harga_satuan' => $item->harga_saat_dipesan,
                    'subtotal'     => $item->qty * $item->harga_saat_dipesan,
                ]);

                $item->produk->decrement('stok', $item->qty);
            }

            // Update meja
            if ($keranjang->tipe_pesanan === 'makan_ditempat' && $keranjang->id_meja) {
                Meja::where('id_meja', $keranjang->id_meja)
                    ->update(['status' => 'sedang digunakan']);
            }

            // ========== JIKA METODE TRANSFER → MIDTRANS ==========
            if ($keranjang->metode_pembayaran === 'transfer') {

                $midtrans = new MidtransService();

                $orderData = [
                    'order_id' => 'ORDER-' . $pesanan->id_pesanan . '-' . time(),
                    'total'    => (int) $total_harga,
                    'name'     => $pesanan->nama_pelanggan,
                    'phone'    => $pesanan->no_wa,
                   'items'    => $keranjang->items->map(function ($item) {
                    return [
                        'id'       => $item->id_produk,
                        'price'    => (int) $item->harga_saat_dipesan,
                        'quantity' => (int) $item->qty,
                        'name'     => $item->produk->nama_produk,
                    ];
                })->toArray()

                ];

                $snapToken = $midtrans->createTransaction($orderData);

                // Simpan token + midtrans_order_id (opsional di tabel pesanan)
                $pesanan->update([
                    'snap_token' => $snapToken,
                    'midtrans_order_id' => $orderData['order_id'], // tambahkan kolom ini di migration jika mau
                ]);

                // Buat record pembayaran awal
                \App\Models\Pembayaran::create([
                    'id_pesanan' => $pesanan->id_pesanan,
                    'midtrans_order_id' => $orderData['order_id'],
                    'status' => 'pending',
                    'gross_amount' => $total_harga,
                    'received_at' => now(),
                ]);


                // Bersihkan keranjang
                KeranjangItem::where('id_keranjang', $keranjang->id_keranjang)->delete();
                $keranjang->delete();

                DB::commit();

                return redirect()->route('checkout.pay', $pesanan->id_pesanan);
            }

            // ========== JIKA COD ==========
            KeranjangItem::where('id_keranjang', $keranjang->id_keranjang)->delete();
            $keranjang->delete();

            DB::commit();

            return redirect()->route('checkout.success', $pesanan->id_pesanan)
                ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {

            DB::rollBack();
            return redirect()->route('keranjang')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function pay($id)
{
    $pesanan = Pesanan::find($id);

    if (!$pesanan || $pesanan->id_user !== Auth::id()) {
        return redirect()->route('/menu-meja')->with('error', 'Pesanan tidak ditemukan');
    }

    // Ambil snap token dari database
    $snapToken = $pesanan->snap_token;

    if (!$snapToken) {
        return redirect()->route('keranjang')->with('error', 'Snap token tidak tersedia');
    }

    return view('checkout.pay', [
        'pesanan' => $pesanan,
        'snapToken' => $snapToken
    ]);
}




    public function success($id_pesanan)
    {
        $pesanan = Pesanan::with(['detailPesanan.produk', 'meja'])->find($id_pesanan);
        
        if (!$pesanan || $pesanan->id_user !== Auth::id()) {
            return redirect()->route('home')->with('error', 'Pesanan tidak ditemukan');
        }

        return view('checkout.success', compact('pesanan'));
    }
}

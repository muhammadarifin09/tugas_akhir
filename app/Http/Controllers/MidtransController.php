<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;
use App\Models\Pesanan;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        // Set konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Ambil notifikasi dari Midtrans
        $notif = new Notification();

        $orderId = $notif->order_id; // contoh: ORDER-15-1732348244
        $status = $notif->transaction_status;
        $fraud = $notif->fraud_status;

        // ======================
        // Ambil ID pesanan asli
        // ======================
        $parts = explode('-', $orderId);

        if (count($parts) < 3) {
            return response()->json(['message' => 'Format order ID tidak valid'], 400);
        }

        $id_pesanan = $parts[1]; // ambil angka kedua → ID pesanan asli

        // Cari pesanan berdasarkan id_pesanan
        $pesanan = Pesanan::where('id_pesanan', $id_pesanan)->first();

        if (!$pesanan) {
            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        }

        // Update status berdasarkan notifikasi Midtrans
        if ($status == 'capture') {
            if ($fraud == 'challenge') {
                $pesanan->status = 'menunggu_validasi';
            } else {
                $pesanan->status = 'proses';
            }
        }
        else if ($status == 'settlement') {
            $pesanan->status = 'proses';
        }
        else if ($status == 'pending') {
            $pesanan->status = 'menunggu_pembayaran';
        }
        else if ($status == 'deny') {
            $pesanan->status = 'ditolak';
        }
        else if ($status == 'expire') {
            $pesanan->status = 'expired';
        }
        else if ($status == 'cancel') {
            $pesanan->status = 'batal';
        }

        $pesanan->save();

        return response()->json(['message' => 'Callback diterima']);
    }
}

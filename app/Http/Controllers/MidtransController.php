<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use App\Models\Pesanan;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Jobs\SendWhatsappNotification;



class MidtransController extends Controller

{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key') ?? env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = config('midtrans.is_production') ?? env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

   public function callback(Request $request)
{
    // Parse payload
    $raw = $request->getContent();
    $payload = json_decode($raw, true) ?: $request->all();
    Log::info('Midtrans callback raw payload', $payload);

    // Signature verification
    $orderId     = (string) ($payload['order_id'] ?? '');
    $statusCode  = (string) ($payload['status_code'] ?? '');
    $grossAmount = (string) ($payload['gross_amount'] ?? '');
    $signatureFromMidtrans = (string) ($payload['signature_key'] ?? '');
    $serverKey = config('midtrans.server_key') ?? env('MIDTRANS_SERVER_KEY');
    $computed = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

    Log::info('Midtrans signature debug', ['computed'=>$computed, 'received'=>$signatureFromMidtrans, 'order_id'=>$orderId]);

    if (! hash_equals($computed, $signatureFromMidtrans)) {
        Log::warning('Midtrans signature mismatch', ['computed'=>$computed, 'received'=>$signatureFromMidtrans]);
        return response()->json(['message' => 'Invalid signature'], 400);
    }

    $transactionStatus = $payload['transaction_status'] ?? ($payload['status'] ?? null);
    $paymentType = $payload['payment_type'] ?? null;
    $transactionId = $payload['transaction_id'] ?? null;

    if (! $orderId) {
        Log::error('Midtrans callback missing order_id', $payload);
        return response()->json(['message' => 'order_id missing'], 400);
    }

    $parts = explode('-', $orderId);
    if (count($parts) < 3) {
        Log::error('Midtrans callback invalid order_id format', ['order_id'=>$orderId]);
        return response()->json(['message' => 'Invalid order id format'], 400);
    }
    $id_pesanan = $parts[1];

    $pesanan = Pesanan::where('id_pesanan', $id_pesanan)->first();
    if (! $pesanan) {
        Log::error('Midtrans callback pesanan not found', ['id_pesanan'=>$id_pesanan, 'order_id'=>$orderId]);
        return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
    }

    // Begin transaction
    try {
        DB::beginTransaction();

        // data payment prepared
        $dataPembayaran = [
            'id_pesanan' => $pesanan->id_pesanan,
            'midtrans_order_id' => $orderId,
            'transaction_id' => $transactionId,
            'payment_type' => $paymentType,
            'status' => $transactionStatus ?? 'pending',
            'gross_amount' => is_numeric($grossAmount) ? $grossAmount : null,
            'raw_payload' => $payload,
            'received_at' => now(),
        ];

        // Update existing pembayaran by transaction_id first, jika tidak ada coba by midtrans_order_id
        $pembayaran = null;
        if (!empty($transactionId)) {
            $pembayaran = Pembayaran::where('transaction_id', $transactionId)->first();
        }
        if (! $pembayaran) {
            $pembayaran = Pembayaran::where('midtrans_order_id', $orderId)->latest()->first();
        }

        if ($pembayaran) {
            $pembayaran->update($dataPembayaran);
            Log::info('Pembayaran updated', ['id_pembayaran' => $pembayaran->{$pembayaran->getKeyName()} ]);
        } else {
            $pembayaran = Pembayaran::create($dataPembayaran);
            Log::info('Pembayaran created', ['id_pembayaran' => $pembayaran->{$pembayaran->getKeyName()} ]);
        }

        // Map transaction status -> order status
        $newStatus = $pesanan->status;
        if ($transactionStatus === 'capture') {
            if ($paymentType === 'credit_card') {
                $fraud = $payload['fraud_status'] ?? null;
                $newStatus = ($fraud === 'challenge') ? 'menunggu_validasi' : 'proses';
            } else {
                $newStatus = 'proses';
            }
        } elseif ($transactionStatus === 'settlement') {
            $newStatus = 'proses';
        } elseif ($transactionStatus === 'pending') {
            $newStatus = 'menunggu_pembayaran';
        } elseif (in_array($transactionStatus, ['deny'])) {
            $newStatus = 'ditolak';
        } elseif ($transactionStatus === 'expire') {
            $newStatus = 'expired';
        } elseif ($transactionStatus === 'cancel') {
            $newStatus = 'batal';
        }

        $pesanan->status = $newStatus;
        $pesanan->save();

        DB::commit();
    } catch (\Throwable $e) {
        DB::rollBack();
        Log::error('Midtrans callback processing failed', ['error'=>$e->getMessage(), 'trace'=>$e->getTraceAsString()]);
        return response()->json(['message'=>'Internal error'], 500);
    }

    Log::info('Midtrans callback processed OK', ['id_pesanan'=>$pesanan->id_pesanan, 'status'=>$newStatus, 'transaction_id'=>$transactionId]);

    // Dispatch WA job dengan id pesanan (sync saat local)
   // Dispatch WA job dengan id pesanan (sync saat local)
        if ($newStatus === 'proses') {
            if (config('app.env') === 'local' || config('app.debug') === true) {
                dispatch_sync(new \App\Jobs\SendWhatsappNotification($pesanan->id_pesanan));
            } else {
                \App\Jobs\SendWhatsappNotification::dispatch($pesanan->id_pesanan);
            }
        }


    return response()->json(['message'=>'OK'], 200);
}


}

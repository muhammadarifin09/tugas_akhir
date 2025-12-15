<?php

namespace App\Jobs;

use App\Services\ReceiptGenerator;
use App\Services\WAService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class SendWhatsappNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $pesananId;

    public function __construct($pesananId)
    {
        $this->pesananId = $pesananId;
    }

    public function handle(ReceiptGenerator $generator)
    {
        $pesanan = Pesanan::with('detailPesanan.produk', 'meja')
            ->find($this->pesananId);

        if (!$pesanan) {
            Log::error("SendWhatsappNotification: Pesanan not found", [
                'id_pesanan' => $this->pesananId
            ]);
            return;
        }

        // =====================================================
        // 🛑 ANTI DUPLIKASI — JIKA STRUK SUDAH TERKIRIM, STOP
        // =====================================================
        if ($pesanan->receipt_sent_at) {
            Log::warning('WA skipped: receipt already sent', [
                'id_pesanan' => $pesanan->id_pesanan,
                'sent_at'    => $pesanan->receipt_sent_at
            ]);
            return;
        }

        // 1️⃣ Generate image
        $localImage = $generator->generateFromOrder($pesanan);
        if (!$localImage) {
            Log::error("SendWhatsappNotification: Failed generate receipt image", [
                'id_pesanan' => $pesanan->id_pesanan
            ]);
            return;
        }

        // 2️⃣ Upload ke Cloudinary (PRIORITAS)
        $publicUrl = $generator->uploadToCloudinary($localImage);
        Log::info('Cloudinary upload result', [
            'order_id' => $pesanan->id_pesanan,
            'url'      => $publicUrl
        ]);

        // 3️⃣ Fallback ke storage lokal (ngrok)
        if (!$publicUrl) {
            $publicUrl = $generator->storeToPublicUrl($localImage);
            Log::info('Fallback to local storage URL', [
                'order_id' => $pesanan->id_pesanan,
                'url'      => $publicUrl
            ]);
        }

        // hapus file lokal
        @unlink($localImage);

        // 4️⃣ Fallback terakhir (signed route)
        if (!$publicUrl) {
            $publicUrl = URL::temporarySignedRoute(
                'receipt.show.signed',
                now()->addHours(24),
                ['id' => $pesanan->id_pesanan]
            );
        }

        // 5️⃣ Build pesan
        $message  = "Terima kasih telah memesan di Juragan 96 Resto 🍽️\n\n";
        $message .= "No. Pesanan: {$pesanan->id_pesanan}\n";
        $message .= "Nama: {$pesanan->nama_pelanggan}\n";
        $message .= "Total: Rp " . number_format($pesanan->total_harga, 0, ',', '.') . "\n\n";
        $message .= "📄 Lihat Struk Pesanan Anda di sini:\n{$publicUrl}\n\n";
        $message .= "Jika ada kendala, silakan balas pesan ini.";

        // 6️⃣ Kirim WA
        $sent = WAService::kirim($pesanan->no_wa, $message);

        if ($sent) {
            $pesanan->update([
                'receipt_sent_at' => now(),
                'receipt_url'     => $publicUrl
            ]);

            Log::info("SendWhatsappNotification: sent", [
                'id_pesanan' => $pesanan->id_pesanan
            ]);
        } else {
            Log::error("SendWhatsappNotification: failed to send", [
                'id_pesanan' => $pesanan->id_pesanan
            ]);
        }
    }
}

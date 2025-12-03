<?php

namespace App\Jobs;

use App\Models\Pesanan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendWhatsappNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $id_pesanan;

    // optional: berapa kali retry, backoff detik
    public $tries = 3;
    public $backoff = 60;

    public function __construct($id_pesanan)
    {
        $this->id_pesanan = $id_pesanan;
    }

    public function handle()
    {
        $pesanan = Pesanan::find($this->id_pesanan);

        if (! $pesanan) {
            Log::warning('WA Job: Pesanan tidak ditemukan', ['id_pesanan' => $this->id_pesanan]);
            return;
        }

        $to = $pesanan->no_wa;
        if (! $to) {
            Log::warning('WA Job: Nomor WA tidak ditemukan', ['id_pesanan' => $this->id_pesanan]);
            return;
        }

        // bersihkan & pastikan format nomor (contoh sederhana)
        $toClean = preg_replace('/\D+/', '', $to);
        if (strlen($toClean) < 9) {
            Log::warning('WA Job: Nomor WA tampak tidak valid', ['raw' => $to, 'clean' => $toClean]);
            return;
        }

        $message = "Pembayaran berhasil! 🎉\n"
                 . "ID Pesanan: {$pesanan->id_pesanan}\n"
                 . "Total: Rp " . number_format($pesanan->total_harga, 0, ',', '.');

        $token = env('WHATSAPP_ACCESS_TOKEN');
        $phoneId = env('WHATSAPP_PHONE_NUMBER_ID');

        if (! $token || ! $phoneId) {
            Log::error('WA Job: credential WhatsApp tidak ditemukan di .env');
            return;
        }

        $url = "https://graph.facebook.com/v17.0/{$phoneId}/messages";

        try {
            $response = Http::withToken($token)->post($url, [
                'messaging_product' => 'whatsapp',
                'to' => $toClean,
                'type' => 'text',
                'text' => ['body' => $message],
            ]);

            Log::info('WA Job: response', [
                'status' => $response->status(),
                'body'   => $response->body(),
                'id_pesanan' => $this->id_pesanan
            ]);

            if ($response->failed()) {
                // Jika using queue driver non-sync -> biarkan throw untuk retry
                if (config('queue.default') !== 'sync') {
                    throw new \Exception('WA API request failed: ' . $response->body());
                } else {
                    // Lokal: log saja, jangan throw supaya callback Midtrans tidak gagal
                    Log::error('WA Job (sync): gagal mengirim, tidak melempar exception (lihat log).');
                }
            }
        } catch (\Throwable $e) {
            Log::error('WA Job Exception: ' . $e->getMessage(), ['id_pesanan' => $this->id_pesanan]);

            // jika worker queue (bukan sync), re-throw supaya worker bisa retry
            if (config('queue.default') !== 'sync') {
                throw $e;
            }

            // jika sync (lokal), jangan throw => selesai
        }
    }

    public function failed(\Throwable $exception)
    {
        // optional: dipanggil setelah job benar-benar gagal (exhausted retries)
        Log::error('WA Job failed permanently', [
            'id_pesanan' => $this->id_pesanan,
            'error' => $exception->getMessage(),
        ]);
    }
}

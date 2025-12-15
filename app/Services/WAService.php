<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WAService
{
    /**
     * Kirim pesan WhatsApp via provider (contoh: Fonnte)
     * @param string $nomor in format internasional (e.g. 628123456)
     * @param string $pesan teks
     * @param string|null $imageUrl optional public image url
     * @return bool
     */
    public static function kirim(string $nomor, string $pesan, string $imageUrl = null): bool
    {
        try {
            $token = env('FONNTE_TOKEN');
            $url = env('FONNTE_URL', 'https://api.fonnte.com/send');

            $payload = [
                'target' => $nomor,
                'message' => $pesan,
            ];

            if ($imageUrl) {
                // banyak provider menerima field 'image' atau 'image_url' — gunakan key yang sesuai
                // coba 'image' first and fallback to 'image_url'
                $payload['image'] = $imageUrl;
                // $payload['image_url'] = $imageUrl; // uncomment jika Fonnte butuh key ini
            }

            $res = Http::withHeaders([
                'Authorization' => $token,
                'Accept' => 'application/json',
            ])->post($url, $payload);

            Log::info('WAService response', ['status' => $res->status(), 'body' => $res->body()]);

            return $res->successful();
        } catch (\Throwable $e) {
            Log::error('WAService error: ' . $e->getMessage());
            return false;
        }
    }
}

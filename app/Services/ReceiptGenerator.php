<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Log;
use Illuminate\Filesystem\FilesystemAdapter; // tambahkan di paling atas bersama use lain

class ReceiptGenerator
{
    protected $wkBinary;

    public function __construct()
    {
        $this->wkBinary = env('WKHTMLTOIMAGE_BIN', '/usr/local/bin/wkhtmltoimage');
    }

    /**
     * Generate PNG receipt image from a blade view (returns local file path or null)
     */
    public function generateFromOrder($order)
    {
        $html = View::make('receipt', ['pesanan' => $order])->render();


        $tmpDir = storage_path('app/tmp');
        if (!is_dir($tmpDir)) mkdir($tmpDir, 0755, true);

        $tmpHtml = $tmpDir . '/receipt_' . uniqid() . '.html';
        $tmpPng  = $tmpDir . '/receipt_' . uniqid() . '.png';

        file_put_contents($tmpHtml, $html);

        $cmd = [
            $this->wkBinary,
            '--width', '600',
            '--disable-smart-width',
            $tmpHtml,
            $tmpPng
        ];

        try {
            $process = new Process($cmd);
            $process->setTimeout(60);
            $process->run();

            if (!$process->isSuccessful()) {
                Log::error('wkhtmltoimage failed: ' . $process->getErrorOutput());
                @unlink($tmpHtml);
                return null;
            }

            @unlink($tmpHtml);
            return $tmpPng;
        } catch (\Throwable $e) {
            Log::error('ReceiptGenerator exception: ' . $e->getMessage());
            @unlink($tmpHtml);
            return null;
        }
    }

    /**
     * Store local image to public disk and return public url
     */
    /**
 * Store local image to public disk and return public url
 */


    
public function storeToPublicUrl(string $localFile, string $filename = null): ?string
{
    if (!file_exists($localFile)) {
        return null;
    }

    $filename = $filename ?? 'receipts/' . now()->format('Ymd') . '/receipt_' . Str::random(8) . '.png';

    $stream = fopen($localFile, 'r');
    try {
        Storage::disk('public')->put($filename, $stream);
    } finally {
        if (is_resource($stream)) {
            fclose($stream);
        }
    }

    // --- help the static analyzer by annotating the disk variable ---
    /** @var FilesystemAdapter $disk */
    $disk = Storage::disk('public');

    // Now Intelephense will recognize url() exists on FilesystemAdapter
    $url = $disk->url($filename);

    // Ensure string
    $url = is_string($url) ? $url : (string) $url;

    if (stripos($url, 'http://') !== 0 && stripos($url, 'https://') !== 0) {
        $appUrl = rtrim(config('app.url') ?: env('APP_URL', ''), '/');
        if (!empty($appUrl)) {
            if (substr($url, 0, 1) !== '/') {
                $url = '/' . $url;
            }
            $url = $appUrl . $url;
        }
    }

    return $url;
}



public function uploadToCloudinary(string $localFile): ?string
{
    if (!file_exists($localFile)) {
        return null;
    }

    $cloud  = env('CLOUDINARY_CLOUD_NAME');
    $key    = env('CLOUDINARY_API_KEY');
    $secret = env('CLOUDINARY_API_SECRET');

    if (!$cloud || !$key || !$secret) {
        Log::error('Cloudinary config missing');
        return null;
    }

    $timestamp = time();

    // ✅ STRING TO SIGN HARUS PERSIS
    $stringToSign = "folder=receipts&timestamp={$timestamp}";

    // ✅ CLOUDINARY PAKAI SHA1 BIASA + API_SECRET (BUKAN HMAC)
    $signature = sha1($stringToSign . $secret);

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => "https://api.cloudinary.com/v1_1/{$cloud}/image/upload",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => [
            'file'      => new \CURLFile($localFile),
            'api_key'   => $key,
            'timestamp' => $timestamp,
            'signature' => $signature,
            'folder'    => 'receipts',
        ],
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    if (!isset($result['secure_url'])) {
        Log::error('Cloudinary upload failed', ['response' => $result]);
        return null;
    }

    return $result['secure_url'];
}



}

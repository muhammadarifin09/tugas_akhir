<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\ReceiptGenerator;
use App\Services\WhatsAppMetaService;
use App\Models\Pesanan;                 // <- pakai Pesanan
use Illuminate\Support\Facades\Log;

class SendReceiptImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $orderId; // ini tetap id yang kamu dispatch, yaitu id_pesanan

    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    public function handle(ReceiptGenerator $generator, WhatsAppMetaService $wa)
    {
        // ambil pesanan berdasarkan primary key id_pesanan
        $order = Pesanan::with('detailPesanan')->find($this->orderId);

        if (! $order) {
            Log::warning("Pesanan tidak ditemukan: {$this->orderId}");
            return;
        }

        // generate gambar struk (ReceiptGenerator harus kompatibel dengan model Pesanan)
        $fileName = $generator->generateFromOrder($order);
        if (! $fileName) {
            Log::error("Gagal generate struk untuk pesanan {$this->orderId}");
            return;
        }

        $filePath = storage_path('app/public/' . $fileName);

        // upload image ke WA (Meta)
        $mediaId = $wa->uploadMedia($filePath, 'image/png');
        if (! $mediaId) {
            Log::error("Gagal upload media ke WA untuk pesanan {$this->orderId}");
            return;
        }

        // buat caption: sesuaikan field total_harga pada model Pesanan
        $total = $order->total_harga ?? 0;
        $caption = "Struk Pesanan #{$order->id_pesanan}\nTotal: Rp " . number_format($total, 0, ',', '.');

        // ambil nomor WA pelanggan; pastikan dalam format internasional
        $rawNumber = $order->no_wa ?? $order->no_wa ?? null; // fallback jika beda nama
        if (! $rawNumber) {
            Log::warning("Nomor WA pelanggan kosong untuk pesanan {$this->orderId}");
            return;
        }

        // Normalize nomor: jika mulai dengan 0 -> ganti ke 62 (Indonesia)
        $to = $this->normalizePhoneNumber($rawNumber);

        $res = $wa->sendImageMessage($to, $mediaId, $caption);

        Log::info("SendReceiptImageJob result", [
            'order' => $this->orderId,
            'to' => $to,
            'response' => $res
        ]);
    }

    /**
     * Normalisasi nomor: contoh input: '0812345...' atau '+628123...' atau '628123...'
     * Hasil: '628123...' (tanpa plus)
     */
    protected function normalizePhoneNumber($phone)
    {
        $p = trim($phone);

        // hapus spasi, minus, kurung
        $p = preg_replace('/[\s\-\(\)]/', '', $p);

        // jika mulai + -> hapus +
        if (substr($p, 0, 1) === '+') {
            $p = substr($p, 1);
        }

        // jika mulai dengan 0 -> ganti 0 -> 62
        if (substr($p, 0, 1) === '0') {
            $p = '62' . substr($p, 1);
        }

        return $p; // contoh: 62812345...
    }
}

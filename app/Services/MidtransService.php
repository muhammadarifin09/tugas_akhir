<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey     = config('midtrans.server_key');
        Config::$clientKey     = config('midtrans.client_key');
        Config::$isProduction  = config('midtrans.is_production');
        Config::$isSanitized   = true;
        Config::$is3ds         = true;
    }

   public function createTransaction($order)
{
    try {
        $params = [
            'transaction_details' => [
                'order_id'      => $order['order_id'],
                'gross_amount'  => (int) $order['total'], // FIX
            ],
            'customer_details' => [
                'first_name' => $order['name'],
                'phone'      => $order['phone'],
            ],
            'item_details' => $order['items']
        ];

        $snapToken = Snap::getSnapToken($params);

        if (!$snapToken) {
    throw new \Exception("Snap token kosong dari Midtrans");
    }


        return $snapToken;

    } catch (\Exception $e) {
        dd("MIDTRANS ERROR: " . $e->getMessage());
    }
}

}



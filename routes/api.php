<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\Api\PesananStatusController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('pesanan/{id}/status', [PesananStatusController::class, 'status']);

// Production callback (Midtrans will POST here)
Route::post('midtrans/callback', [MidtransController::class, 'callback'])
    ->name('midtrans.callback');

// Debug/test endpoint — gunakan ini untuk memastikan ngrok -> app bekerja.
// Supports both GET (quick browser check) and POST (simulate Midtrans).
Route::match(['get', 'post'], 'midtrans/test-callback', function (Request $request) {
    Log::info('hit test-callback via ngrok', $request->all());
    return response()->json([
        'ok' => true,
        'method' => $request->method(),
        'payload' => $request->all()
    ]);
})->name('midtrans.test');

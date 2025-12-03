<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananStatusController extends Controller
{
    public function status($id)
    {
        $pesanan = Pesanan::find($id);
        if (! $pesanan) {
            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        }
        return response()->json(['status' => $pesanan->status]);
    }
}

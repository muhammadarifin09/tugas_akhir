<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Meja;
use App\Models\Pesanan;
use App\Models\Produk;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ======================
        // DATA MEJA
        // ======================
        $jumlahMeja = Meja::count();

        $mejaDigunakan = Meja::whereIn('status', [
            'dipesan',
            'sedang digunakan'
        ])->count();

        // ======================
        // DATA PESANAN
        // ======================
        $jumlahPesanan = Pesanan::whereIn('status', [
            'pending',
            'proses'
        ])->count();

        $pesananSelesai = Pesanan::where('status', 'selesai')->count();

        $pesananPending = Pesanan::where('status', 'pending')->count();

        // ======================
        // PESANAN TERBARU
        // ======================
        $recentOrders = Pesanan::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // ======================
        // DATA MENU
        // ======================
        $totalMenu = Produk::count();

        // ======================
        // PENDAPATAN HARI INI
        // ======================
        $totalPendapatan = Pesanan::whereDate('created_at', Carbon::today())
            ->where('status', 'selesai')
            ->sum('total_harga');

        return view('pegawai.dashboard', compact(
            'jumlahMeja',
            'jumlahPesanan',
            'mejaDigunakan',
            'recentOrders',
            'totalMenu',
            'pesananSelesai',
            'pesananPending',
            'totalPendapatan'
        ));
    }
}

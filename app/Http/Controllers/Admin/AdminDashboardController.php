<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Meja;
use App\Models\Produk;
use App\Models\Pesanan;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ======================
        // DATA AKUN
        // ======================
        $totalAkun = User::count();

        $jumlahAdmin = User::where('role', 'admin')->count();
        $jumlahPegawai = User::where('role', 'pegawai')->count();

        // ======================
        // DATA PRODUK / MENU
        // ======================
        $totalProduk = Produk::count();

        $menuHabis = Produk::where('stok', '<=', 0)->count();

        // ======================
        // DATA PESANAN
        // ======================
        $totalPesanan = Pesanan::count();

        $pesananSelesai = Pesanan::where('status', 'selesai')->count();
        $pesananPending = Pesanan::where('status', 'pending')->count();


        // ======================
        // DATA MEJA
        // ======================
        $jumlahMeja = Meja::count();

        $mejaDigunakan = Meja::whereIn('status', [
            'dipesan',
            'sedang digunakan'
        ])->count();

        // ======================
        // PESANAN TERBARU
        // ======================
        $produkTerbaru = Produk::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // ======================
        // PENDAPATAN HARI INI
        // ======================
        $totalPendapatan = Pesanan::whereDate('created_at', Carbon::today())
            ->where('status', 'selesai')
            ->sum('total_harga');

        return view('admin.dashboard', compact(
            'totalAkun',
            'jumlahAdmin',
            'jumlahPegawai',
            'totalProduk',
            'menuHabis',
            'totalPesanan',
            'pesananSelesai',
            'pesananPending',
            'produkTerbaru',
             'mejaDigunakan',
            'totalPendapatan'
        ));
    }
}

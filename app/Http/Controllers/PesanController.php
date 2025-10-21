<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PesanController extends Controller
{
    public function index()
    {
        return view('pesan.makanan'); // buat view baru pesan/makanan.blade.php
    }

    public function store(Request $request)
    {
        // logika simpan pesanan ke database
        return redirect()->route('pesan.makanan')->with('success', 'Pesanan berhasil!');
    }
}


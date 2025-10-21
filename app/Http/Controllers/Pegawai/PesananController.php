<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Meja;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function index()
    {
        // ambil pesanan + relasi yang diperlukan
        $pesanan = Pesanan::with(['meja', 'detailPesanan.produk'])
                    ->orderByDesc('id_pesanan')
                    ->get();

        // meja yang tersedia (dipakai di form create)
        $mejas = Meja::where('status', 'tersedia')->get();

        // kirim variabel ke view dengan nama yang diharapkan: $pesanan
        return view('pegawai.pesanan.index', compact('pesanan', 'mejas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe_pesanan' => 'required|in:makan_ditempat,dibawa_pulang',
            'id_meja' => 'nullable|exists:meja,id_meja',
        ]);

        $pesanan = Pesanan::create([
            'id_user' => Auth::id(),
            'id_meja' => $request->tipe_pesanan === 'makan_ditempat' ? $request->id_meja : null,
            'tipe_pesanan' => $request->tipe_pesanan,
            'total_harga' => 0,
            'status' => 'pending',
        ]);

        // Jika tipe makan di tempat, ubah status meja jadi dipesan
        if ($pesanan->id_meja) {
            $meja = Meja::find($pesanan->id_meja);
            $meja->update(['status' => 'dipesan']);
        }

        return redirect()->route('pegawai.pesanan.index')->with('success', 'Pesanan berhasil dibuat.');
    }

    public function updateStatus(Request $request, Pesanan $pesanan)
{
    $request->validate([
        'status' => 'required|in:pending,proses,selesai,batal',
    ]);

    $pesanan->update(['status' => $request->status]);

    if ($request->status === 'selesai' && $pesanan->id_meja) {
        $pesanan->meja->update(['status' => 'tersedia']);
    }

    return back()->with('success', 'Status pesanan diperbarui.');
}


    public function destroy(Pesanan $pesanan)
    {
        if ($pesanan->id_meja) {
            $pesanan->meja->update(['status' => 'tersedia']);
        }

        $pesanan->delete();

        return back()->with('success', 'Pesanan berhasil dihapus.');
    }

    public function riwayat()
{
    $user = Auth::user();

    $pesanan = Pesanan::where('id_user', $user->id)
        ->with('detailPesanan.produk') // relasi berantai
        ->orderBy('created_at', 'desc')
        ->get();

    return view('pelanggan.riwayat_pesanan', compact('pesanan'));
}

}

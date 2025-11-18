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
        $pesanan = Pesanan::with(['meja', 'detailPesanan.produk'])
                    ->orderByDesc('id_pesanan')
                    ->paginate(10);

        $mejas = Meja::where('status', 'tersedia')->get();

        return view('pegawai.pesanan.index', compact('pesanan', 'mejas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe_pesanan'   => 'required|in:makan_ditempat,dibawa_pulang',
            'id_meja'        => 'nullable|exists:meja,id_meja',
            'nama_pelanggan' => 'required|string|max:255',
            'no_wa' => 'required|string|max:20',
            'alamat'         => 'nullable|string',
        ]);

        $pesanan = Pesanan::create([
            'id_user'        => Auth::id(),
            'id_meja'        => $request->tipe_pesanan === 'makan_ditempat' ? $request->id_meja : null,
            'tipe_pesanan'   => $request->tipe_pesanan,
            'nama_pelanggan' => $request->nama_pelanggan,
            'no_wa' => $request->no_wa,
            'alamat'         => $request->tipe_pesanan === 'dibawa_pulang' ? $request->alamat : null,
            'total_harga'    => 0,
            'status'         => 'pending',
        ]);

        // ubah status meja jika makan di tempat
        if ($pesanan->id_meja) {
            $meja = Meja::find($pesanan->id_meja);
            $meja->update(['status' => 'dipesan']);
        }

        return redirect()->route('pegawai.pesanan.index')
            ->with('success', 'Pesanan berhasil dibuat.');
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
            ->with('detailPesanan.produk')
            ->orderByDesc('created_at')
            ->get();

        return view('pelanggan.riwayat_pesanan', compact('pesanan'));
    }
}

<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // ==============================
    // TAMPIL PROFIL
    // ==============================
    public function index()
    {
        $user = Auth::user();

        // ambil profil pelanggan sesuai user
        $profil = Pelanggan::where('user_id', $user->id)->first();

        return view('pelanggan.profil.index', compact('user', 'profil'));
    }

    // ==============================
    // FORM EDIT PROFIL
    // ==============================
    public function edit()
    {
        $user = Auth::user();

        // jika belum ada profil, buat kosong
        $profil = Pelanggan::firstOrCreate([
            'user_id' => $user->id
        ]);

        return view('pelanggan.profil.edit', compact('user', 'profil'));
    }

    // ==============================
    // UPDATE PROFIL
    // ==============================
    public function update(Request $request)
    {
        $request->validate([
            'nomor_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        // ambil profil berdasarkan user yg login
        $profil = Pelanggan::firstOrCreate([
            'user_id' => Auth::id(),
        ]);

        // update hanya nomor_hp & alamat
        $profil->update([
            'nomor_hp' => $request->nomor_hp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('pelanggan.profil.index')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}

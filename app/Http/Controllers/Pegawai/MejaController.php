<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Meja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MejaController extends Controller
{
    public function index()
    {
        $mejas = Meja::all();
        return view('pegawai.meja.index', compact('mejas'));
    }

    public function create()
    {
        return view('pegawai.meja.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_meja' => 'required|unique:meja,nomor_meja',
            'status' => 'required|in:tersedia,dipesan,sedang digunakan',
            'waktu_tersedia' => 'nullable|date',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // upload gambar
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('meja', 'public');
            $validated['gambar'] = $path;
        }

        Meja::create($validated);

        return redirect()->route('pegawai.meja.index')
            ->with('success', 'Meja berhasil ditambahkan');
    }

    public function show(Meja $meja)
    {
        return view('pegawai.meja.show', compact('meja'));
    }

    public function edit(Meja $meja)
    {
        return view('pegawai.meja.edit', compact('meja'));
    }

    public function update(Request $request, Meja $meja)
    {
        $validated = $request->validate([
            'nomor_meja' => [
                'required',
                Rule::unique('meja', 'nomor_meja')->ignore($meja->id_meja, 'id_meja'),
            ],
            'status' => 'required|in:tersedia,dipesan,sedang digunakan',
            'waktu_tersedia' => 'nullable|date',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // cek jika ada file baru
        if ($request->hasFile('gambar')) {
            // hapus gambar lama jika ada
            if ($meja->gambar) {
                Storage::disk('public')->delete($meja->gambar);
            }

            $path = $request->file('gambar')->store('meja', 'public');
            $validated['gambar'] = $path;
        }

        $meja->update($validated);

        return redirect()->route('pegawai.meja.index')
            ->with('success', 'Meja berhasil diperbarui');
    }

    public function destroy(Meja $meja)
    {
        if ($meja->gambar) {
            Storage::disk('public')->delete($meja->gambar);
        }

        $meja->delete();

        return redirect()->route('pegawai.meja.index')
            ->with('success', 'Data meja berhasil dihapus.');
    }
}

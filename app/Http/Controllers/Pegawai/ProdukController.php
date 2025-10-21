<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Tampilkan daftar produk
     */
    public function index()
    {
        $produks = Produk::all();
        return view('pegawai.produk.index', compact('produks'));
    }

    /**
     * Simpan produk baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'jenis' => 'required|in:makanan,minuman',
            'harga' => 'required|numeric|min:0',
            'stok' => 'nullable|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('produk', 'public');
            $validated['gambar'] = $path;
        }

        Produk::create($validated);

        return redirect()->route('pegawai.produk.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail produk
     */
    public function show(Produk $produk)
    {
        return view('pegawai.produk.show', compact('produk'));
    }

    /**
     * Tampilkan form edit produk
     */
    public function edit(Produk $produk)
    {
        return view('pegawai.produk.edit', compact('produk'));
    }

    /**
     * Update data produk
     */
    public function update(Request $request, Produk $produk)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'jenis' => 'required|in:makanan,minuman',
            'harga' => 'required|numeric|min:0',
            'stok' => 'nullable|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Jika ada gambar baru, hapus gambar lama & upload yang baru
        if ($request->hasFile('gambar')) {
            if ($produk->gambar) {
                Storage::disk('public')->delete($produk->gambar);
            }
            $path = $request->file('gambar')->store('produk', 'public');
            $validated['gambar'] = $path;
        }

        $produk->update($validated);

        return redirect()->route('pegawai.produk.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Hapus produk
     */
    public function destroy(Produk $produk)
    {
        if ($produk->gambar) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return redirect()->route('pegawai.produk.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}

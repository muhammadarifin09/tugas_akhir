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
        $mejas = Meja::orderBy('nomor_meja')->paginate(10);
        $nomorMejaTerpakai = Meja::pluck('nomor_meja')->toArray();

        return view('pegawai.meja.index', compact('mejas', 'nomorMejaTerpakai'));
    }


    public function create()
    {
        return view('pegawai.meja.create');
    }

    public function store(Request $request)
    {
            $validated = $request->validate([
            'nomor_meja' => 'required|unique:meja,nomor_meja',
            'kapasitas' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
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
        'kapasitas' => 'required|integer|min:1',
        'deskripsi' => 'nullable|string',
        'status' => 'required|in:tersedia,dipesan,sedang digunakan',
        'waktu_tersedia' => 'nullable|date',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($request->hasFile('gambar')) {
        if ($meja->gambar) {
            Storage::disk('public')->delete($meja->gambar);
        }

        $validated['gambar'] = $request->file('gambar')->store('meja', 'public');
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

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.akun.index', compact('users'));
    }

    public function create()
    {
        return view('admin.akun.create');
    }

     public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,pegawai,pelanggan'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('akun.index')->with('success', 'Akun berhasil ditambahkan!');;
    }

    public function edit(User $akun)
    {
        return view('admin.akun.edit', compact('akun'));
    }

    public function update(Request $request, User $akun)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$akun->id,
            'role' => 'required|in:admin,pegawai,pelanggan'
        ]);

        $akun->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $request->password ? Hash::make($request->password) : $akun->password,
        ]);

        return redirect()->route('akun.index')->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroy(User $akun)
    {
        $akun->delete();
        return redirect()->route('akun.index')->with('success', 'Akun berhasil dihapus.');
    }
}

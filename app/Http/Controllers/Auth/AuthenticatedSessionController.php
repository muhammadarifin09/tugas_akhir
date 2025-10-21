<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
   public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    $request->session()->regenerate();

    // Ambil role user yang login
    $role = Auth::user()->role;

    // Redirect sesuai role
    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'pegawai') {
        return redirect()->route('pegawai.dashboard');
    } elseif ($role === 'pengguna') {
        return redirect('/'); // ke beranda
    } else {
        return redirect('/'); // fallback ke beranda juga
    }
}


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

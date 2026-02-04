<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meja;

class MejaController extends Controller
{
    public function index()
    {
        $mejas = Meja::orderBy('nomor_meja')->paginate(10);

        return view('admin.meja.index', compact('mejas'));
    }

    public function show(Meja $meja)
    {
        return view('admin.meja.show', compact('meja'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meja;

class MejaController extends Controller
{
    public function index()
    {
        $meja = Meja::orderBy('nomor_meja', 'asc')->get();
        return view('meja.index', compact('meja'));
    }
}

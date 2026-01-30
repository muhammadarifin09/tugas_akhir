<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Laporan;
use Illuminate\Pagination\LengthAwarePaginator;

class LaporanController extends Controller
{
    public function index(Request $request)
{
    // Jika belum filter → kirim collection kosong
    if (!$request->tanggal_awal || !$request->tanggal_akhir) {
        if (!$request->tanggal_awal || !$request->tanggal_akhir) {
    $laporan = new LengthAwarePaginator([], 0, 10);
    return view('pegawai.laporan.index', compact('laporan'));
}
        return view('pegawai.laporan.index', compact('laporan'));
    }

    // Validasi tanggal
    if ($request->tanggal_awal > $request->tanggal_akhir) {
        return back()
            ->withInput()
            ->with('error', 'Tanggal awal tidak boleh lebih besar dari tanggal akhir');
    }

    $laporan = Pesanan::where('status', 'selesai')
        ->whereBetween('tanggal_pesanan', [
            $request->tanggal_awal.' 00:00:00',
            $request->tanggal_akhir.' 23:59:59'
        ])
        ->orderBy('tanggal_pesanan', 'desc')
        ->paginate(10);

    return view('pegawai.laporan.index', compact('laporan'));
}


public function exportPdf(Request $request)
{
    $query = Pesanan::where('status', 'selesai');

    if ($request->tanggal_awal && $request->tanggal_akhir) {
        $query->whereBetween('tanggal_pesanan', [
            $request->tanggal_awal . ' 00:00:00',
            $request->tanggal_akhir . ' 23:59:59'
        ]);
    }

    $laporan = $query->get();

    $pdf = Pdf::loadView('pegawai.laporan.pdf', compact('laporan'))
              ->setPaper('A4', 'landscape');

    return $pdf->download('laporan-pesanan.pdf');
}

public function exportCsv(Request $request)
{
    // VALIDASI TANGGAL
    if ($request->tanggal_awal && $request->tanggal_akhir) {
        if ($request->tanggal_awal > $request->tanggal_akhir) {
            return redirect()->back()
                ->with('error', 'Tanggal awal tidak boleh lebih besar dari tanggal akhir');
        }
    }

    // QUERY DATA
    $query = Pesanan::where('status', 'selesai');

    if ($request->tanggal_awal && $request->tanggal_akhir) {
        $query->whereBetween('tanggal_pesanan', [
            $request->tanggal_awal . ' 00:00:00',
            $request->tanggal_akhir . ' 23:59:59'
        ]);
    }

    $laporan = $query->orderBy('tanggal_pesanan', 'desc')->get();

    // HEADER CSV
    $headers = [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename=laporan-pesanan.csv",
    ];

    $callback = function () use ($laporan) {
        $file = fopen('php://output', 'w');

        // HEADER KOLOM
        fputcsv($file, [
            'Nama Pelanggan',
            'Tanggal Pesan',
            'Total Bayar',
            'Metode Bayar',
            'Tipe Pesanan',
            'Status'
        ]);

        // DATA
        foreach ($laporan as $item) {
            fputcsv($file, [
                $item->nama_pelanggan,
                $item->tanggal_pesanan,
                $item->total_harga,
                strtoupper($item->metode_pembayaran),
                str_replace('_', ' ', $item->tipe_pesanan),
                $item->status
            ]);
        }

        fclose($file);
    };

    return response()->streamDownload($callback, 'laporan-pesanan.csv', $headers);
}

public function arsip(Request $request)
{
    if (!$request->tanggal_awal || !$request->tanggal_akhir) {
        return back()->with('error', 'Filter tanggal terlebih dahulu');
    }

    if ($request->tanggal_awal > $request->tanggal_akhir) {
        return back()->with('error', 'Tanggal awal tidak boleh lebih besar dari tanggal akhir');
    }

    $pesanan = Pesanan::where('status', 'selesai')
        ->whereBetween('tanggal_pesanan', [
            $request->tanggal_awal . ' 00:00:00',
            $request->tanggal_akhir . ' 23:59:59'
        ])
        ->get();

    foreach ($pesanan as $item) {
        Laporan::firstOrCreate(
            ['id_pesanan' => $item->id_pesanan],
            [
                'nama_pelanggan'     => $item->nama_pelanggan,
                'tanggal_pesanan'   => $item->tanggal_pesanan,
                'total_bayar'       => $item->total_harga,
                'metode_pembayaran' => $item->metode_pembayaran,
                'tipe_pesanan'      => $item->tipe_pesanan,
                'status'            => 'selesai',
            ]
        );
    }

    return back()->with('success', 'Data laporan berhasil diarsipkan');
}


}

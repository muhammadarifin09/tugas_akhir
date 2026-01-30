@extends('layouts.pegawai')

@section('title', 'Laporan Pesanan')

@section('content')
<div class="container-fluid">

<h4 class="mb-4">Laporan Pesanan</h4>
@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-4">
        <input type="date" name="tanggal_awal" class="form-control"
               value="{{ request('tanggal_awal') }}">
    </div>
    <div class="col-md-4">
        <input type="date" name="tanggal_akhir" class="form-control"
               value="{{ request('tanggal_akhir') }}">
    </div>
    <div class="col-md-4">
        <button class="btn btn-primary w-100">
            Filter
        </button>
    </div>
</form>

<div class="d-flex gap-2 mb-3">
    <a href="{{ route('pegawai.laporan.pdf', request()->query()) }}"
       class="btn btn-danger">
        Export PDF
    </a>

    <a href="{{ route('pegawai.laporan.csv', request()->query()) }}"
       class="btn btn-success">
        Export CSV
    </a>

     <form action="{{ route('pegawai.laporan.arsip') }}"
          method="POST"
          onsubmit="return confirm('Simpan laporan ini ke arsip?')">
        @csrf
        <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
        <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
        <button class="btn btn-secondary">
            Simpan ke Arsip
        </button>
    </form>
</div>




<div class="table-responsive">
<table class="table table-bordered table-striped align-middle">
<thead class="table-dark">
<tr>
    <th>No</th>
    <th>Nama Pelanggan</th>
    <th>Tanggal Pesan</th>
    <th>Total Bayar</th>
    <th>Metode Bayar</th>
    <th>Tipe Pesanan</th>
    <th>Status</th>
</tr>
</thead>

<tbody>
@forelse ($laporan as $item)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $item->nama_pelanggan }}</td>
    <td>{{ \Carbon\Carbon::parse($item->tanggal_pesanan)->format('d-m-Y H:i') }}</td>
    <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
    <td>{{ strtoupper($item->metode_pembayaran) }}</td>
    <td>{{ str_replace('_', ' ', ucfirst($item->tipe_pesanan)) }}</td>
    <td>
        <span class="badge bg-success">
            {{ ucfirst($item->status) }}
        </span>
    </td>
</tr>
@empty
<tr>
    <td colspan="7" class="text-center text-muted">
        Silakan pilih rentang tanggal terlebih dahulu
    </td>
</tr>
@endforelse
</tbody>
</table>
</div>

{{ $laporan->links() }}
</div>
@endsection

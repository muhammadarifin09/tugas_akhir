@extends('layouts.main')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="container py-5 text-dark">
  <h2 class="text-center mb-4">📋 Riwayat Pesanan Saya</h2>

  @if ($pesanan->isEmpty())
    <p class="text-center text-muted">Belum ada pesanan yang dibuat.</p>
  @else
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle">
        <thead class="table-warning text-center">
          <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Total Harga</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pesanan as $index => $p)
            @foreach ($p->detailPesanan as $detail)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $p->created_at->format('d M Y H:i') }}</td>
                <td>{{ $detail->produk->nama_produk ?? '-' }}</td>
                <td>{{ $detail->jumlah }}</td>
                <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                <td class="text-center">
                  @switch($p->status)
                    @case('pending') <span class="badge bg-warning text-dark">Pending</span> @break
                    @case('proses') <span class="badge bg-primary">Proses</span> @break
                    @case('selesai') <span class="badge bg-success">Selesai</span> @break
                    @case('batal') <span class="badge bg-danger">Batal</span> @break
                  @endswitch
                </td>
              </tr>
            @endforeach
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>
@endsection

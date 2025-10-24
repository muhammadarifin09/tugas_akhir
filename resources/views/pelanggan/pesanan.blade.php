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
            <th>Harga Satuan</th>
            <th>Total Harga</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pesanan as $index => $p)
            @php
              $rowCount = $p->detailPesanan->count();
            @endphp

            @foreach ($p->detailPesanan as $i => $detail)
              <tr>
                {{-- Kolom nomor & tanggal hanya di baris pertama --}}
                @if ($i == 0)
                  <td rowspan="{{ $rowCount }}" class="text-center align-middle">
                    {{ ($pesanan->currentPage() - 1) * $pesanan->perPage() + $index + 1 }}
                  </td>
                  <td rowspan="{{ $rowCount }}" class="align-middle">{{ $p->created_at->format('d M Y H:i') }}</td>
                @endif

                {{-- Detail produk --}}
                <td>{{ $detail->produk->nama_produk ?? '-' }}</td>
                <td class="text-center">{{ $detail->jumlah }}</td>
                <td>Rp {{ number_format($detail->produk->harga ?? 0, 0, ',', '.') }}</td>

                {{-- Total & status hanya di baris pertama --}}
                @if ($i == 0)
                  <td rowspan="{{ $rowCount }}" class="align-middle text-end">
                    <strong>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</strong>
                  </td>
                  <td rowspan="{{ $rowCount }}" class="text-center align-middle">
                    @switch($p->status)
                      @case('pending') <span class="badge bg-warning text-dark">Pending</span> @break
                      @case('proses') <span class="badge bg-primary">Proses</span> @break
                      @case('selesai') <span class="badge bg-success">Selesai</span> @break
                      @case('batal') <span class="badge bg-danger">Batal</span> @break
                      @default <span class="badge bg-secondary">Tidak Diketahui</span>
                    @endswitch
                  </td>
                @endif
              </tr>
            @endforeach
          @endforeach
        </tbody>
      </table>
    </div>

    {{-- 🔹 Pagination --}}
    <div class="d-flex justify-content-center mt-4">
      {{ $pesanan->links('pagination::bootstrap-5') }}
    </div>
  @endif
</div>
@endsection

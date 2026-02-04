@extends('layouts.admin')

@section('title', 'Data Pesanan')

@section('content')
<div class="container-fluid">

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white fw-semibold">
            <i class="fas fa-clipboard-list me-2"></i> Daftar Pesanan
        </div>

        <div class="card-body bg-light">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Pelanggan</th>
                            <th>Tipe Pesanan</th>
                            <th>No Meja</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pesanan as $index => $item)
                            <tr>
                                <td>{{ $pesanan->firstItem() + $index }}</td>
                                <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                                <td>{{ $item->nama_pelanggan ?? '-' }}</td>

                                <td>
                                    <span class="badge {{ $item->tipe_pesanan == 'makan_ditempat' ? 'bg-success' : 'bg-info text-dark' }}">
                                        {{ $item->tipe_pesanan == 'makan_ditempat' ? 'Makan di Tempat' : 'Dibawa Pulang' }}
                                    </span>
                                </td>

                                <td>{{ $item->meja->nomor_meja ?? '-' }}</td>

                                <td class="fw-semibold">
                                    Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                                </td>

                                <td>
                                    @switch($item->status)
                                        @case('pending') <span class="badge bg-warning text-dark">Pending</span> @break
                                        @case('proses') <span class="badge bg-primary">Proses</span> @break
                                        @case('selesai') <span class="badge bg-success">Selesai</span> @break
                                        @case('batal') <span class="badge bg-danger">Batal</span> @break
                                    @endswitch
                                </td>

                                <td>
                                    <button class="btn btn-info btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#detailModal{{ $item->id_pesanan }}">
                                        Detail
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    Belum ada data pesanan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $pesanan->links() }}
        </div>
    </div>

    {{-- MODAL DETAIL PESANAN --}}
    @foreach ($pesanan as $item)
        <div class="modal fade" id="detailModal{{ $item->id_pesanan }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5>Detail Pesanan #{{ $item->id_pesanan }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <table class="table table-bordered mb-3">
                            <tr><th>Nama Pelanggan</th><td>{{ $item->nama_pelanggan }}</td></tr>
                            <tr><th>No WhatsApp</th><td>{{ $item->no_wa }}</td></tr>
                            @if($item->tipe_pesanan == 'dibawa_pulang')
                                <tr><th>Alamat</th><td>{{ $item->alamat }}</td></tr>
                            @endif
                        </table>

                        <table class="table table-bordered text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($item->detailPesanan as $no => $detail)
                                    <tr>
                                        <td>{{ $no + 1 }}</td>
                                        <td>{{ $detail->produk->nama_produk }}</td>
                                        <td>{{ $detail->jumlah }}</td>
                                        <td>Rp {{ number_format($detail->produk->harga, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <strong>Total: Rp {{ number_format($item->total_harga, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

</div>
@endsection

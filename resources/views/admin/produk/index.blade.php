@extends('layouts.admin')

@section('title', 'Data Produk')

@section('content')
<div class="container-fluid">

    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Jenis</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($produks as $index => $produk)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $produk->nama_produk }}</td>
                    <td>{{ ucfirst($produk->jenis) }}</td>
                    <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                    <td>{{ $produk->stok }}</td>
                    <td>
                        @if($produk->gambar)
                            <img src="{{ asset('storage/'.$produk->gambar) }}" width="100" alt="Gambar Produk">
                        @else
                            <em>-</em>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-info btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#modalShow{{ $produk->id_produk }}">
                            Detail
                        </button>
                    </td>
                </tr>

                {{-- Modal Show --}}
                <div class="modal fade" id="modalShow{{ $produk->id_produk }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5>Detail Produk</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Nama Produk:</strong> {{ $produk->nama_produk }}</p>
                                <p><strong>Jenis:</strong> {{ ucfirst($produk->jenis) }}</p>
                                <p><strong>Harga:</strong> Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                                <p><strong>Stok:</strong> {{ $produk->stok }}</p>
                                <p><strong>Deskripsi:</strong> {{ $produk->deskripsi ?? '-' }}</p>

                                @if($produk->gambar)
                                    <img src="{{ asset('storage/'.$produk->gambar) }}"
                                         width="300"
                                         class="mt-2"
                                         alt="Gambar Produk">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data produk</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection

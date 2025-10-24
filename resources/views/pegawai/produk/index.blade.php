@extends('layouts.pegawai')

@section('title', 'Data Produk')

@section('content')
<div class="container-fluid">

    {{-- Tombol tambah --}}
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCreate">
        + Tambah Produk
    </button>

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
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalShow{{ $produk->id_produk }}">Detail</button>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $produk->id_produk }}">Edit</button>
                        <form action="{{ route('pegawai.produk.destroy', $produk->id_produk) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</button>
                        </form>
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
                                    <img src="{{ asset('storage/'.$produk->gambar) }}" width="300" class="mt-2" alt="Gambar Produk">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modal Edit --}}
                <div class="modal fade" id="modalEdit{{ $produk->id_produk }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('pegawai.produk.update', $produk->id_produk) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5>Edit Produk</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Nama Produk</label>
                                        <input type="text" name="nama_produk" value="{{ $produk->nama_produk }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Jenis</label>
                                        <select name="jenis" class="form-control" required>
                                            <option value="makanan" {{ $produk->jenis == 'makanan' ? 'selected' : '' }}>Makanan</option>
                                            <option value="minuman" {{ $produk->jenis == 'minuman' ? 'selected' : '' }}>Minuman</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Harga</label>
                                        <input type="number" name="harga" value="{{ $produk->harga }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Stok</label>
                                        <input type="number" name="stok" value="{{ $produk->stok }}" class="form-control" min="0">
                                    </div>
                                    <div class="mb-3">
                                        <label>Deskripsi</label>
                                        <textarea name="deskripsi" class="form-control" rows="3">{{ $produk->deskripsi }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label>Gambar</label>
                                        <input type="file" name="gambar" class="form-control">
                                        @if($produk->gambar)
                                            <img src="{{ asset('storage/'.$produk->gambar) }}" width="200" class="mt-2">
                                        @endif
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                    <button type="submit" class="btn btn-success">Update</button>
                                </div>
                            </form>
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

{{-- Modal Create --}}
<div class="modal fade" id="modalCreate" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('pegawai.produk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5>Tambah Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Jenis</label>
                        <select name="jenis" class="form-control" required>
                            <option value="makanan">Makanan</option>
                            <option value="minuman">Minuman</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Harga</label>
                        <input type="number" name="harga" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Stok</label>
                        <input type="number" name="stok" class="form-control" min="0" value="0">
                    </div>
                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Gambar</label>
                        <input type="file" name="gambar" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

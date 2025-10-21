@extends('layouts.pegawai')

@section('title', 'Data Meja')

@section('content')
<div class="container-fluid">
   

    {{-- tombol tambah --}}
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCreate">
        + Tambah Meja
    </button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Meja</th>
                <th>Status</th>
                <th>Waktu Tersedia</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($mejas as $index => $meja)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $meja->nomor_meja }}</td>
                    <td>{{ $meja->status }}</td>
                    <td>{{ $meja->waktu_tersedia ?? '-' }}</td>
                    <td>
                        @if($meja->gambar)
                            <img src="{{ asset('storage/'.$meja->gambar) }}" width="150">
                        @else
                            <em>-</em>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modalShow{{ $meja->id_meja}}">Detail</button>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modalEdit{{ $meja->id_meja}}">Edit</button>
                       <form action="{{ route('pegawai.meja.destroy', $meja->id_meja) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus meja ini?')">
                                Hapus
                            </button>
                        </form>

                    </td>
                </tr>

                {{-- Modal Show --}}
                <div class="modal fade" id="modalShow{{ $meja->id_meja }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5>Detail Meja</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Nomor Meja:</strong> {{ $meja->nomor_meja }}</p>
                                <p><strong>Status:</strong> {{ $meja->status }}</p>
                                <p><strong>Waktu Tersedia:</strong> {{ $meja->waktu_tersedia ?? '-' }}</p>
                                @if($meja->gambar)
                                   <img src="{{ asset('storage/' . $meja->gambar) }}" width="400" alt="Gambar Meja">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modal Edit --}}
                <div class="modal fade" id="modalEdit{{ $meja->id_meja }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('pegawai.meja.update', $meja->id_meja) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5>Edit Meja</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Nomor Meja</label>
                                        <input type="text" name="nomor_meja" value="{{ $meja->nomor_meja }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Status</label>
                                        <select name="status" class="form-control" required>
                                            <option value="tersedia" {{ $meja->status=='tersedia' ? 'selected' : '' }}>Tersedia</option>
                                            <option value="dipesan" {{ $meja->status=='dipesan' ? 'selected' : '' }}>Dipesan</option>
                                            <option value="sedang digunakan" {{ $meja->status=='sedang digunakan' ? 'selected' : '' }}>Sedang Digunakan</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Waktu Tersedia</label>
                                        <input type="datetime-local" name="waktu_tersedia"
                                            value="{{ $meja->waktu_tersedia ? date('Y-m-d\TH:i', strtotime($meja->waktu_tersedia)) : '' }}"
                                            class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label>Gambar</label>
                                        <input type="file" name="gambar" class="form-control">
                                        @if($meja->gambar)
                                            <img src="{{ asset('storage/'.$meja->gambar) }}" width="250" class="mt-2">
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
                    <td colspan="6" class="text-center">Belum ada data meja</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Modal Create --}}
<div class="modal fade" id="modalCreate" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('pegawai.meja.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5>Tambah Meja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nomor Meja</label>
                        <input type="text" name="nomor_meja" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="tersedia">Tersedia</option>
                            <option value="dipesan">Dipesan</option>
                            <option value="sedang digunakan">Sedang Digunakan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Waktu Tersedia</label>
                        <input type="datetime-local" name="waktu_tersedia" class="form-control">
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

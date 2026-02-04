@extends('layouts.admin')

@section('title', 'Data Meja')

@section('content')
<div class="container-fluid">

    <table class="table table-bordered table-sm align-middle text-center">
        <thead class="table-light">
            <tr>
                <th style="width: 60px;">No</th>
                <th style="width: 100px;">Nomor Meja</th>
                <th style="width: 140px;">Kapasitas</th>
                <th style="width: 160px;">Status</th>
                <th style="width: 220px;">Waktu Tersedia</th>
                <th style="width: 120px;">Detail</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($mejas as $index => $meja)
                <tr>
                    <td>{{ $mejas->firstItem() + $index }}</td>
                    <td>{{ $meja->nomor_meja }}</td>
                    <td>{{ $meja->kapasitas }} orang</td>
                    <td>
                        <span class="badge
                            @if($meja->status == 'tersedia') bg-success
                            @elseif($meja->status == 'dipesan') bg-warning text-dark
                            @else bg-danger @endif">
                            {{ ucfirst($meja->status) }}
                        </span>
                    </td>
                    <td>{{ $meja->waktu_tersedia ?? '-' }}</td>
                    <td>
                        <button class="btn btn-info btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#modalShow{{ $meja->id_meja }}">
                            Detail
                        </button>
                    </td>
                </tr>

                {{-- MODAL DETAIL --}}
                <div class="modal fade" id="modalShow{{ $meja->id_meja }}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5>Detail Meja</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-start">
                                <p><strong>Nomor Meja:</strong> {{ $meja->nomor_meja }}</p>
                                <p><strong>Kapasitas:</strong> {{ $meja->kapasitas }} orang</p>
                                <p><strong>Status:</strong> {{ $meja->status }}</p>
                                <p><strong>Deskripsi:</strong> {{ $meja->deskripsi ?? '-' }}</p>
                                <p><strong>Waktu Tersedia:</strong> {{ $meja->waktu_tersedia ?? '-' }}</p>

                                @if($meja->gambar)
                                    <img src="{{ asset('storage/'.$meja->gambar) }}"
                                         class="img-fluid rounded mt-2"
                                         alt="Gambar Meja">
                                @endif
                            </div>
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

    {{ $mejas->links() }}

</div>
@endsection

@extends('layouts.pegawai')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 fw-bold"></h1>

    <!-- CARD: Daftar Pesanan -->
    <div class="card shadow border-0 mb-5">
        <div class="card-header bg-primary text-white fw-semibold d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-clipboard-list me-2"></i> Daftar Pesanan
            </div>
            <div class="text-light small">
                Menampilkan {{ $pesanan->count() }} dari {{ $pesanan->total() }} pesanan
            </div>
        </div>

        <div class="card-body bg-light">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle text-center mb-0">
                    <thead class="table-primary text-dark">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th style="width: 180px;">Tanggal</th>
                            <th style="width: 150px;">Tipe Pesanan</th>
                            <th style="width: 90px;">No. Meja</th>
                            <th style="width: 210px;">Total Harga</th>
                            <th style="width: 110px;">Status</th>
                            <th style="width: 180px;">Konfirmasi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($pesanan as $index => $item)
                            <tr>
                                <td>{{ $pesanan->firstItem() + $index }}</td>
                                <td>{{ $item->created_at->format('d M Y H:i') }}</td>

                                {{-- Kolom tipe pesanan --}}
                                <td>
                                    <span class="badge 
                                        {{ $item->tipe_pesanan == 'Makan di Tempat' ? 'bg-success' : 'bg-info text-dark' }}">
                                        {{ ucfirst($item->tipe_pesanan) }}
                                    </span>
                                </td>

                                {{-- Kolom nomor meja --}}
                                <td>{{ $item->meja->nomor_meja ?? '-' }}</td>

                                {{-- Kolom total harga --}}
                                <td class="fw-semibold">
                                    Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                                </td>

                                {{-- Kolom status --}}
                                <td>
                                    @switch($item->status)
                                        @case('pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                            @break
                                        @case('proses')
                                            <span class="badge bg-primary">Proses</span>
                                            @break
                                        @case('selesai')
                                            <span class="badge bg-success">Selesai</span>
                                            @break
                                        @case('batal')
                                            <span class="badge bg-danger">Batal</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ ucfirst($item->status) }}</span>
                                    @endswitch
                                </td>

                                {{-- Kolom aksi --}}
                                <td>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <!-- Tombol Detail -->
                                        <button type="button"
                                            class="btn btn-sm btn-info text-white shadow-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#detailModal{{ $item->id_pesanan }}">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </button>

                                        <!-- Form Ubah Status -->
                                        <form action="{{ route('pegawai.pesanan.updateStatus', $item->id_pesanan) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            <select name="status"
                                                class="form-select form-select-sm shadow-sm"
                                                onchange="this.form.submit()">
                                                <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="proses" {{ $item->status == 'proses' ? 'selected' : '' }}>Proses</option>
                                                <option value="selesai" {{ $item->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                                <option value="batal" {{ $item->status == 'batal' ? 'selected' : '' }}>Batal</option>
                                            </select>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                    Belum ada data pesanan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            @if($pesanan->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted small">
                    Menampilkan {{ $pesanan->firstItem() }} - {{ $pesanan->lastItem() }} dari {{ $pesanan->total() }} pesanan
                </div>
                
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0">
                        {{-- Previous Page Link --}}
                        @if($pesanan->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">&laquo; Sebelumnya</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $pesanan->previousPageUrl() }}" rel="prev">&laquo; Sebelumnya</a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($pesanan->getUrlRange(1, $pesanan->lastPage()) as $page => $url)
                            @if($page == $pesanan->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if($pesanan->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $pesanan->nextPageUrl() }}" rel="next">Selanjutnya &raquo;</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">Selanjutnya &raquo;</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
            @endif
        </div>
    </div>

    <!-- MODAL DETAIL PESANAN -->
    @foreach ($pesanan as $item)
        <div class="modal fade" id="detailModal{{ $item->id_pesanan }}" tabindex="-1"
            aria-labelledby="detailModalLabel{{ $item->id_pesanan }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="detailModalLabel{{ $item->id_pesanan }}">
                            Detail Pesanan #{{ $item->id_pesanan }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped text-center align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Jumlah</th>
                                        <th>Harga Satuan</th>
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
                    </div>

                    <div class="modal-footer bg-light d-flex justify-content-between">
                        <span class="fw-semibold text-muted">
                            Tipe Pesanan: {{ $item->tipe }}
                        </span>
                        <strong class="text-dark fs-6">
                            Total: Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                        </strong>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
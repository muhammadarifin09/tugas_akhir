@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">Pesan {{ $produk->nama_produk }}</h2>

    <form action="{{ route('pesan.store') }}" method="POST" class="card p-4 shadow-sm">
        @csrf
        <input type="hidden" name="id_produk" value="{{ $produk->id_produk }}">

        <div class="mb-3">
            <label class="form-label">Tipe Pesanan</label>
            <select name="tipe_pesanan" id="tipe_pesanan" class="form-select" required>
                <option value="">-- Pilih Tipe Pesanan --</option>
                <option value="makan_ditempat">Makan di Tempat</option>
                <option value="dibawa_pulang">Dibawa Pulang</option>
            </select>
        </div>

        <div class="mb-3" id="mejaField" style="display: none;">
            <label class="form-label">Pilih Meja</label>
            <select name="id_meja" class="form-select">
                <option value="">-- Pilih Meja --</option>
                @foreach($meja as $m)
                    <option value="{{ $m->id_meja }}">Meja {{ $m->nomor_meja }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Jumlah Pesanan</label>
            <input type="number" name="jumlah" class="form-control" min="1" value="1" required>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('beranda') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-success">Kirim Pesanan</button>
        </div>
    </form>
</div>

<script>
document.getElementById('tipe_pesanan').addEventListener('change', function() {
    const mejaField = document.getElementById('mejaField');
    mejaField.style.display = this.value === 'makan_ditempat' ? 'block' : 'none';
});
</script>
@endsection

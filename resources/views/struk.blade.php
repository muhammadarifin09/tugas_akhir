<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Struk Pesanan</title>

<style>
    body {
        font-family: 'Courier New', monospace;
        width: 280px;
        margin: auto;
        font-size: 14px;
        color: #000;
    }

    .center {
        text-align: center;
    }

    .title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .line {
        border-top: 1px dashed #000;
        margin: 8px 0;
    }

    table {
        width: 100%;
        font-size: 14px;
    }

    .total {
        font-size: 16px;
        font-weight: bold;
    }

    .footer {
        margin-top: 12px;
        border-top: 1px dashed #000;
        padding-top: 10px;
        font-size: 12px;
    }
</style>

</head>
<body>

<div class="center">
    <div class="title">JURAGAN 96 RESTO</div>
    <div>Jl. Raya Sungai Riam </div>
    <div>Telp: 0812-3456-7890</div>
</div>

<div class="line"></div>

<b>ID Pesanan:</b> {{ $pesanan->id_pesanan }}<br>
<b>Tanggal:</b> {{ $pesanan->created_at->format('d/m/Y H:i') }}<br>
<b>Pelanggan:</b> {{ $pesanan->nama_pelanggan }}<br>
<b>No. WA:</b> {{ $pesanan->no_wa }}<br>

@if($pesanan->tipe_pesanan == 'makan_ditempat')
<b>Meja:</b> Meja {{ $pesanan->meja->nomor_meja ?? '-' }}<br>
@else
<b>Alamat:</b> {{ $pesanan->alamat }}<br>
@endif

<div class="line"></div>

<table>
    @foreach($pesanan->detailPesanan as $item)
    <tr>
        <td colspan="2"><b>{{ $item->produk->nama_produk }}</b></td>
    </tr>
    <tr>
        <td>{{ $item->jumlah }} x {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
        <td style="text-align:right;">
            {{ number_format($item->subtotal, 0, ',', '.') }}
        </td>
    </tr>
    @endforeach
</table>

<div class="line"></div>

<table>
    <tr>
        <td><b>Total</b></td>
        <td style="text-align:right;" class="total">
            Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
        </td>
    </tr>
</table>

<div class="line"></div>

<div class="center footer">
    Terima kasih telah memesan! <br>
    *Simpan struk ini sebagai bukti pembayaran*
</div>

</body>
</html>

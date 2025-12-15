<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Struk Pesanan #{{ $pesanan->id_pesanan }}</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
</head>
<body>
  <div style="max-width:420px;margin:auto;font-family:Arial,Helvetica,sans-serif;">
    <h3 style="text-align:center">Juragan 96 Resto</h3>

    @if(!empty($pesanan->receipt_url) && (Str::endsWith($pesanan->receipt_url, ['.png', '.jpg', '.jpeg'])))
      <img src="{{ $pesanan->receipt_url }}" alt="Struk" style="width:100%;height:auto;border:1px solid #ddd;padding:6px;">
    @else
      {{-- fallback: render HTML struk --}}
      <div>No. Pesanan: {{ $pesanan->id_pesanan }}</div>
      <div>Tanggal: {{ $pesanan->created_at->format('d M Y H:i') }}</div>
      <hr/>
      @foreach($pesanan->detailPesanan as $d)
        <div style="display:flex;justify-content:space-between">
          <div>{{ $d->produk->nama_produk }} x{{ $d->jumlah }}</div>
          <div>Rp {{ number_format($d->subtotal,0,',','.') }}</div>
        </div>
      @endforeach
      <hr/>
      <div style="text-align:right;font-weight:bold">Total: Rp {{ number_format($pesanan->total_harga,0,',','.') }}</div>
    @endif
  </div>
</body>
</html>

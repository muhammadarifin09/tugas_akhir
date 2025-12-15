<!doctype html>
<html>
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    /* Ukuran untuk struk thermal (sesuaikan 280-380px) */
    body {
      font-family: "DejaVu Sans", Arial, sans-serif;
      color: #000;
      font-size: 12px;
      margin:0;
      padding:0;
      background: #fff;
    }

    .receipt {
      width: 320px;              /* ubah ke 280-320 sesuai printer */
      margin: 0 auto;
      padding: 12px;
    }

    .center { text-align:center; }
    .header .title { font-size:18px; font-weight:700; margin:6px 0 2px; }
    .small { font-size:11px; color:#333; }
    .muted { color:#666; font-size:11px; }

    .logo {
      width: 90px;
      height: auto;
      margin: 0 auto 6px;
      display:block;
    }

    .line { border-top: 1px dashed #000; margin: 8px 0; }

    table { width: 100%; border-collapse: collapse; font-size:12px; }
    td, th { padding: 2px 0; vertical-align: top; }
    .item-name { width: 58%; word-wrap: break-word; }
    .qty { width: 12%; text-align: center; }
    .price { width: 30%; text-align: right; }

    .right { text-align: right; }
    .total { font-weight:700; font-size:14px; }

    .footer { margin-top:10px; font-size:11px; text-align:center; }
    .note { font-size:10px; color:#444; margin-top:6px; }

    /* kecilkan garis bawah di footer */
    .footer .small { color:#444; font-size:10px; }

    /* make sure long names wrap */
    .item-name { word-break: break-word; white-space: normal; }
  </style>
</head>
<body>
  <div class="receipt">
    <div class="header center">
      {{-- embed logo as base64 (preferred so wkhtmltoimage can render without HTTP) --}}
      @php
        $logoPathStorage = storage_path('app/public/logo/juragan96.png');
        $logoPathPublic  = public_path('images/juragan96.png');
        $logoData = null;

        if (file_exists($logoPathStorage)) {
            $type = pathinfo($logoPathStorage, PATHINFO_EXTENSION);
            $data = file_get_contents($logoPathStorage);
            $base64 = base64_encode($data);
            $logoData = "data:image/{$type};base64,{$base64}";
        } elseif (file_exists($logoPathPublic)) {
            $type = pathinfo($logoPathPublic, PATHINFO_EXTENSION);
            $data = file_get_contents($logoPathPublic);
            $base64 = base64_encode($data);
            $logoData = "data:image/{$type};base64,{$base64}";
        }
      @endphp

      @if($logoData)
        <img src="{{ $logoData }}" alt="Juragan96" class="logo">
      @else
        <div style="height:90px;display:flex;align-items:center;justify-content:center;border:0px solid #eee;margin-bottom:6px;">
          <strong>JURAGAN 96</strong>
        </div>
      @endif

      <div class="title">JURAGAN 96 RESTO</div>
      <div class="small">Jl. Raya Sungai Riam</div>
      <div class="small">Telp: 0812-3456-7890</div>
      <div class="small muted">
        @php
          $date = $pesanan->tanggal_pesanan ?? $pesanan->created_at ?? null;
          try {
            $dateFormatted = $date ? \Carbon\Carbon::parse($date)->format('d/m/Y H:i') : '-';
          } catch (\Exception $e) {
            $dateFormatted = $date;
          }
        @endphp
        {{ $dateFormatted }}
      </div>
    </div>

    <div class="line"></div>

    <div>
      <div><strong>ID Pesanan:</strong> {{ $pesanan->id_pesanan }}</div>
      <div><strong>Pelanggan:</strong> {{ $pesanan->nama_pelanggan ?? '-' }}</div>
      <div class="small"><strong>No. WA:</strong> {{ $pesanan->no_wa ?? '-' }}</div>

      @if($pesanan->tipe_pesanan == 'makan_ditempat' || strtolower($pesanan->tipe_pesanan) == 'dine_in')
        <div class="small"><strong>Meja:</strong> Meja {{ $pesanan->meja->nomor_meja ?? '-' }}</div>
      @else
        @if(!empty($pesanan->alamat))
          <div class="small"><strong>Alamat:</strong> {{ $pesanan->alamat }}</div>
        @endif
      @endif
    </div>

    <div class="line"></div>

    <table>
      <thead>
        <tr>
          <th class="item-name">Produk</th>
          <th class="qty">Jumlah</th>
          <th class="price">Subtotal</th>
        </tr>
      </thead>
      <tbody>
        @php
          $items = $pesanan->detailPesanan ?? collect();
        @endphp

        @forelse($items as $item)
          @php
            $itemName = $item->produk->nama_produk
                        ?? $item->produk->nama
                        ?? $item->nama_produk
                        ?? $item->nama_menu
                        ?? 'Item';

            $qty = $item->jumlah ?? $item->qty ?? $item->quantity ?? 1;
            $hargaSatuan = $item->harga_satuan ?? $item->harga ?? $item->price ?? 0;
            $subtotal = $item->subtotal ?? $item->sub_total ?? ($qty * $hargaSatuan);
          @endphp

          <tr>
            <td class="item-name">{{ $itemName }}</td>
            <td class="qty">{{ $qty }}</td>
            <td class="price">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="3" class="muted">Tidak ada item</td>
          </tr>
        @endforelse
      </tbody>
    </table>

    <div class="line"></div>

    <table>
      <tr class="total">
        <td class="total">Total Harga</td>
        <td class="price total right">Rp {{ number_format($pesanan->total_harga ?? 0, 0, ',', '.') }}</td>
      </tr>
    </table>

    <div class="line"></div>

    <div class="footer">
      <div class="small">Terima kasih telah memesan!</div>
      <div class="note">Simpan struk ini sebagai bukti pembayaran</div>
    </div>
  </div>
</body>
</html>

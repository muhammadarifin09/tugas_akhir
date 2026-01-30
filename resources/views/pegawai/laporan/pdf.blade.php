<!DOCTYPE html>
<html>
<head>
    <style>
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #000; padding:6px; font-size:12px; }
        th { background:#eee; }
    </style>
</head>
<body>

<h3 align="center">Laporan Pesanan</h3>

<table>
<thead>
<tr>
    <th>No</th>
    <th>Nama Pelanggan</th>
    <th>Tanggal</th>
    <th>Total</th>
    <th>Metode</th>
    <th>Tipe</th>
</tr>
</thead>
<tbody>
@foreach($laporan as $i => $item)
<tr>
    <td>{{ $i+1 }}</td>
    <td>{{ $item->nama_pelanggan }}</td>
    <td>{{ $item->tanggal_pesanan }}</td>
    <td>Rp {{ number_format($item->total_harga,0,',','.') }}</td>
    <td>{{ strtoupper($item->metode_pembayaran) }}</td>
    <td>{{ str_replace('_',' ', $item->tipe_pesanan) }}</td>
</tr>
@endforeach
</tbody>
</table>

</body>
</html>

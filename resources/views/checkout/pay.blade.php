<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Pembayaran Pesanan</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    body{ background:#eef0f3; padding:20px; }
    .payment-card{ max-width:600px; margin:auto; border-radius:10px; }
    .btn-pay{ height:55px; font-size:18px; font-weight:600; }
  </style>
</head>
<body>

<div class="container mt-5">
  <div class="card shadow-sm payment-card">
    <div class="card-body">
      <h3 class="mb-3 text-center">Pembayaran Pesanan</h3>

      <p><strong>Nama:</strong> {{ $pesanan->nama_pelanggan }}</p>
      <p><strong>Total Pembayaran:</strong> Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>

      <p><strong>Status Pesanan:</strong> <span id="order-status">{{ $pesanan->status ?? 'menunggu_pembayaran' }}</span></p>

      <hr>

      <p class="text-muted text-center">Klik tombol di bawah untuk melanjutkan pembayaran melalui Midtrans.</p>

      <button id="pay-button" class="btn btn-success btn-lg w-100 btn-pay">Bayar Sekarang</button>

      <a href="{{ route('pelanggan.pesanan') }}" class="btn btn-secondary w-100 mt-3 btn-pay">Bayar Nanti</a>
    </div>
  </div>
</div>

<!-- Snap (sandbox). Pastikan client key di .env -->
<!-- Snap (sandbox). Pastikan client key di .env -->
<script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<script>
  // Pastikan variabel PHP tersedia; fallback null / string supaya JS selalu valid
  const snapToken = {!! json_encode(isset($snapToken) ? (string)$snapToken : null) !!};
  const idPesanan = {!! json_encode(isset($pesanan) ? $pesanan->id_pesanan : null) !!};

  (function(){
    // cek cepat: tampilkan ke console (hapus setelah aman)
    console.debug('snapToken:', snapToken);
    console.debug('idPesanan:', idPesanan);
  })();

  // tombol bayar
  document.getElementById('pay-button').onclick = function () {
    if (!snapToken) {
      alert('Snap token tidak tersedia, hubungi admin.');
      return;
    }

    snap.pay(snapToken, {
      onSuccess: function(result) {
       window.location.href = "{{ route('checkout.success', $pesanan->id_pesanan) }}?from_midtrans=1";
      },
      onPending: function(result) {
        window.location.href = "{{ route('checkout.success', $pesanan->id_pesanan) }}?from_midtrans=1";
      },
      onError: function(result) {
        alert('Terjadi kesalahan pada proses pembayaran (sandbox). Cek log server.');
      },
      onClose: function() {
        alert('Anda menutup popup tanpa menyelesaikan pembayaran.');
      }
    });
  };

  // Polling status pesanan tiap 3 detik
  (function(){
    if (!idPesanan) return;
    const statusEl = document.getElementById('order-status');
    const url = `/api/pesanan/${idPesanan}/status`;

    async function pollOnce(){
      try {
        const r = await fetch(url, { headers: { 'Accept': 'application/json' } });
        if (!r.ok) {
          // jangan berhenti polling hanya karena 1 error
          console.warn('Polling HTTP error', r.status);
          return;
        }
        const data = await r.json();
        if (!data || typeof data.status === 'undefined') return;
        if (statusEl) statusEl.textContent = data.status;
        if (data.status && data.status !== 'menunggu_pembayaran') {
          window.location.href = `/checkout/success/${idPesanan}`;
        }
      } catch (err) {
        console.warn('Polling fetch error', err);
      }
    }

    // jalankan segera lalu interval
    pollOnce();
    const interval = setInterval(pollOnce, 3000);
    // optional: clearInterval saat unload
    window.addEventListener('beforeunload', () => clearInterval(interval));
  })();
</script>


</body>
</html>

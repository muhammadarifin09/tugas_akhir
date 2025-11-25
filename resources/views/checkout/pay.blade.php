<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Pesanan</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <style>
        body {
            background: #eef0f3;
            padding: 20px;
        }

        .payment-card {
            max-width: 600px;
            margin: auto;
            border-radius: 10px;
        }

        .btn-pay {
            height: 55px;
            font-size: 18px;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="card shadow-sm payment-card">
        <div class="card-body">

            <h3 class="mb-3 text-center">Pembayaran Pesanan</h3>

            <p><strong>Nama:</strong> {{ $pesanan->nama_pelanggan }}</p>
            <p><strong>Total Pembayaran:</strong> Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>

            <hr>

            <p class="text-muted text-center">
                Klik tombol di bawah untuk melanjutkan pembayaran melalui Midtrans.
            </p>

            <button id="pay-button"
                class="btn btn-success btn-lg w-100 btn-pay">
                Bayar Sekarang
            </button>

            <a href="{{ route('keranjang') }}"
               class="btn btn-secondary w-100 mt-3 btn-pay">
                Kembali
            </a>

        </div>
    </div>
</div>

<!-- Script Snap Midtrans -->
<script
    type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
</script>

<script>
    document.getElementById('pay-button').onclick = function () {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                window.location.href = "{{ route('checkout.success', $pesanan->id_pesanan) }}";
            },
            onPending: function(result) {
                // Untuk Sandbox QRIS yang selalu pending
                window.location.href = "{{ route('checkout.success', $pesanan->id_pesanan) }}";
            },
            onError: function(result) {
                // Tetap redirect ke sukses untuk testing
                window.location.href = "{{ route('checkout.success', $pesanan->id_pesanan) }}";
            },
            onClose: function() {
                alert('Anda menutup popup tanpa menyelesaikan pembayaran.');
            }
        });
    }
</script>


</body>
</html>

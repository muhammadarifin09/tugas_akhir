<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\Pegawai\ProdukController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\MidtransController;

// =====================================
// ROUTE UTAMA
// =====================================
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/tentang', fn() => view('tentang'))->name('tentang');
Route::get('/menu-meja', [BerandaController::class, 'menuMeja'])->name('menu-meja');

require __DIR__.'/auth.php';

// =====================================
// PROFILE USER DEFAULT
// =====================================
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', fn() => view('dashboard'))->middleware(['verified'])->name('dashboard');
});

// =====================================
// ROUTE PELANGGAN
// =====================================
Route::middleware('auth')->group(function () {

    Route::prefix('pelanggan')->group(function () {

        Route::get('/profil', [\App\Http\Controllers\Pelanggan\ProfileController::class, 'index'])
            ->name('pelanggan.profil.index');
        Route::get('/profil/edit', [\App\Http\Controllers\Pelanggan\ProfileController::class, 'edit'])
            ->name('pelanggan.profil.edit');
        Route::post('/profil/update', [\App\Http\Controllers\Pelanggan\ProfileController::class, 'update'])
            ->name('pelanggan.profil.update');
    });

    Route::get('/pesanan-saya', [App\Http\Controllers\PesananPelangganController::class, 'riwayat'])
        ->name('pelanggan.pesanan');
    Route::get('/pesanan', [App\Http\Controllers\PesananPelangganController::class, 'index'])
        ->name('pelanggan.pesanan.index');
});

// =====================================
// ROUTE KERANJANG & CHECKOUT
// =====================================
Route::middleware('auth')->group(function () {

    // Keranjang
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang');
    Route::post('/keranjang/tambah', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::post('/keranjang/update', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');
    Route::delete('/keranjang/hapus-item/{id}', [KeranjangController::class, 'hapusItem'])->name('keranjang.hapus-item');
    Route::delete('/keranjang/kosongkan', [KeranjangController::class, 'kosongkan'])->name('keranjang.kosongkan');
    Route::post('/keranjang/checkout', [KeranjangController::class, 'checkout'])->name('keranjang.checkout');

    // Form checkout
    Route::get('/checkout', [KeranjangController::class, 'checkoutForm'])->name('checkout.form');

    // Checkout PROSES YANG BENAR — HANYA INI
    Route::post('/checkout/process/{id_keranjang}', [CheckoutController::class, 'process'])
        ->name('checkout.process');

    // Redirect → halaman ringkasan
    Route::get('/payment/redirect/{id_keranjang}', [CheckoutController::class, 'redirect'])
        ->name('payment.redirect');

    // Halaman sukses
    Route::get('/checkout/success/{id_pesanan}', [CheckoutController::class, 'success'])
        ->name('checkout.success');

    // Halaman pembayaran Midtrans
    Route::get('/checkout/pay/{id}', [CheckoutController::class, 'pay'])->name('checkout.pay');
});

// =====================================
// ROUTE ADMIN
// =====================================
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin', fn() => view('admin.dashboard'))->name('admin.dashboard');

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard.index');

    Route::resource('akun', AkunController::class);
});

// =====================================
// ROUTE PEGAWAI
// =====================================
Route::middleware(['auth', 'role:pegawai'])
    ->prefix('pegawai')
    ->as('pegawai.')
    ->group(function () {

        Route::get('/', fn() => view('pegawai.dashboard'))->name('dashboard');

        Route::resource('meja', App\Http\Controllers\Pegawai\MejaController::class);

        Route::resource('produk', ProdukController::class);

        Route::resource('pesanan', App\Http\Controllers\Pegawai\PesananController::class);
        Route::post('/pesanan/{pesanan}/update-status', [App\Http\Controllers\Pegawai\PesananController::class, 'updateStatus'])
            ->name('pesanan.updateStatus');
    });

// =====================================
// ROUTE AJAX
// =====================================
Route::post('/tambah-keranjang', [BerandaController::class, 'tambahKeKeranjang'])->name('tambah.keranjang');
Route::get('/cart-count', [BerandaController::class, 'getCartCount'])->name('cart.count');
Route::post('/keranjang/tambah-ajax', [KeranjangController::class, 'tambahAjax'])->name('keranjang.tambah.ajax');
Route::get('/cart-data', [BerandaController::class, 'getCartData'])->name('cart.data');

// =====================================
// MIDTRANS
// =====================================
Route::post('/midtrans/pay/{id_keranjang}', [CheckoutController::class, 'midtransPay'])
    ->name('midtrans.pay');

use App\Jobs\SendReceiptImageJob;
Route::get('/test-send-receipt/{id}', function($id) {
    SendReceiptImageJob::dispatch($id);
    return "dispatched {$id}";
});


use App\Http\Controllers\PublicReceiptController;

// public signed route untuk lihat struk (valid beberapa jam)
Route::get('/receipt/signed/{id}', [PublicReceiptController::class, 'showSigned'])
    ->name('receipt.show.signed')
    ->middleware('signed');

// optional: public route if you saved image in storage (usually accessible via /storage/...)
Route::get('/receipt/public/{id}', [PublicReceiptController::class, 'showPublic'])
    ->name('receipt.show.public');

use App\Http\Controllers\Pegawai\DashboardController;

Route::get('/pegawai/dashboard', [DashboardController::class, 'index'])
    ->name('pegawai.dashboard');


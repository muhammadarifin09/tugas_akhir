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

// =======================
// ROUTE UTAMA & BERANDA
// =======================
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/tentang', function () {
    return view('tentang');
})->name('tentang');
Route::get('/menu-meja', [BerandaController::class, 'menuMeja'])->name('menu-meja');

// =======================
// ROUTE AUTH & PROFILE
// =======================
require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    // Profile routes (default Laravel)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard default
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');
});

// =======================
// ROUTE PELANGGAN
// =======================
Route::middleware('auth')->group(function () {
    // Profile Pelanggan
    Route::prefix('pelanggan')->group(function () {
        Route::get('/profil', [\App\Http\Controllers\Pelanggan\ProfileController::class, 'index'])
            ->name('pelanggan.profil.index');
        Route::get('/profil/edit', [\App\Http\Controllers\Pelanggan\ProfileController::class, 'edit'])
            ->name('pelanggan.profil.edit');
        Route::post('/profil/update', [\App\Http\Controllers\Pelanggan\ProfileController::class, 'update'])
            ->name('pelanggan.profil.update');
    });

    // Pesanan Pelanggan
    Route::get('/pesanan-saya', [App\Http\Controllers\PesananPelangganController::class, 'riwayat'])
        ->name('pelanggan.pesanan');
    Route::get('/pesanan', [App\Http\Controllers\PesananPelangganController::class, 'index'])
        ->name('pelanggan.pesanan.index');
});

// =======================
// ROUTE PEMESANAN & KERANJANG
// =======================
Route::middleware('auth')->group(function () {
    // Halaman pesan makanan
    Route::get('/pesan', [PesanController::class, 'index'])->name('pesan');
    Route::get('/pesan-makanan', [PesanController::class, 'index'])->name('pesan.makanan');
    Route::post('/pesan/simpan', [PesanController::class, 'store'])->name('pesan.store');
    Route::post('/pesan-makanan', [PesanController::class, 'store'])->name('pesan.makanan.store');

    // Pemesanan dengan ID
    Route::prefix('pesan')->group(function() {
        Route::get('/{id}', [App\Http\Controllers\Pelanggan\PemesananController::class, 'create'])
            ->name('pesan.create');
        Route::post('/', [App\Http\Controllers\Pelanggan\PemesananController::class, 'store'])
            ->name('pesan.store');
    });

    // Keranjang
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang');
    Route::post('/keranjang/tambah', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::post('/keranjang/update', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');
    Route::delete('/keranjang/hapus-item/{id}', [KeranjangController::class, 'hapusItem'])->name('keranjang.hapus-item');
    Route::delete('/keranjang/kosongkan', [KeranjangController::class, 'kosongkan'])->name('keranjang.kosongkan');
    Route::post('/keranjang/checkout', [KeranjangController::class, 'checkout'])->name('keranjang.checkout');

    // Checkout Process
    Route::get('/checkout', [KeranjangController::class, 'checkoutForm'])->name('checkout.form');
    Route::post('/checkout', [PesanController::class, 'store'])->name('checkout');
    Route::post('/checkout/process', [PesanController::class, 'store'])->name('checkout.process');
    
    // Payment & Checkout Redirect
    Route::get('/payment/redirect/{id_keranjang}', [CheckoutController::class, 'redirect'])
        ->name('payment.redirect');
    Route::post('/checkout/process/{id_keranjang}', [CheckoutController::class, 'process'])
        ->name('checkout.process');
    Route::get('/checkout/success/{id_pesanan}', [CheckoutController::class, 'success'])
        ->name('checkout.success');

    //Route::post('/midtrans/callback', [MidtransController::class, 'callback']);

});

// =======================
// ROUTE ADMIN
// =======================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard.index');
    Route::get('/akun', [AkunController::class, 'index'])->name('akun.index');
    Route::resource('akun', AkunController::class);
});

// =======================
// ROUTE PEGAWAI
// =======================
Route::middleware(['auth', 'role:pegawai'])
    ->prefix('pegawai')
    ->as('pegawai.')
    ->group(function () {
        // Dashboard Pegawai
        Route::get('/', function () {
            return view('pegawai.dashboard');
        })->name('dashboard');

        // Meja Management
        Route::resource('meja', App\Http\Controllers\Pegawai\MejaController::class);

        // Produk Management
        Route::resource('produk', ProdukController::class);
        
        // Pesanan Management
        Route::resource('pesanan', App\Http\Controllers\Pegawai\PesananController::class);
        Route::put('pesanan/{pesanan}/status/{status}', [App\Http\Controllers\Pegawai\PesananController::class, 'updateStatus'])
            ->name('pesanan.status');
        Route::post('/pesanan/{pesanan}/update-status', [App\Http\Controllers\Pegawai\PesananController::class, 'updateStatus'])
            ->name('pesanan.updateStatus');

        // Detail Pesanan
        Route::post('detail-pesanan', [App\Http\Controllers\Pegawai\DetailPesananController::class, 'store'])
            ->name('detail.store');
    });

// =======================
// ROUTE TAMBAHAN
// =======================
Route::get('/daftar-meja', [App\Http\Controllers\MejaController::class, 'index'])->name('daftar.meja');

// =======================
// ROUTE ROLE-BASED REDIRECT
// =======================
Route::middleware(['auth'])->group(function () {
    // User role redirect
    Route::get('/user', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
});

// =======================
// ROUTE AJAX & CART (DIPINDAH KE ATAS UNTUK MENGHINDARI KONFLIK)
// =======================

// Route untuk Ajax add to cart dari BerandaController
Route::post('/tambah-keranjang', [BerandaController::class, 'tambahKeKeranjang'])
    ->name('tambah.keranjang');

// Route untuk get cart count
Route::get('/cart-count', [BerandaController::class, 'getCartCount'])
    ->name('cart.count');

// Route untuk Ajax Add to Cart dari KeranjangController
Route::post('/keranjang/tambah-ajax', [KeranjangController::class, 'tambahAjax'])
    ->name('keranjang.tambah.ajax');

// Update route existing untuk handle form biasa dan Ajax
Route::post('/keranjang/tambah', [KeranjangController::class, 'tambah'])
    ->name('keranjang.tambah');

// Route untuk get cart data
Route::get('/cart-data', [BerandaController::class, 'getCartData'])
    ->name('cart.data');


// MIDTRANS PAYMENT

Route::post('/midtrans/pay/{id_keranjang}', [CheckoutController::class, 'midtransPay'])
    ->name('midtrans.pay');

//Route::post('/midtrans/callback', [CheckoutController::class, 'midtransCallback'])
    //->name('midtrans.callback');

//Route::post('/midtrans/callback', [MidtransController::class, 'callback'])
    // ->name('midtrans.callback');

Route::get('/checkout/pay/{id}', [CheckoutController::class, 'pay'])->name('checkout.pay');



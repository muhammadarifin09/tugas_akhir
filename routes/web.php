<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\Pegawai\ProdukController;




Route::resource('akun', AkunController::class);

// routes/web.php
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/akun', [AkunController::class, 'index'])->name('akun.index');
});


// Profil Pelanggan
Route::prefix('pelanggan')->middleware('auth')->group(function () {

    Route::get('/profil', [\App\Http\Controllers\Pelanggan\ProfileController::class, 'index'])
        ->name('pelanggan.profil.index');

    Route::get('/profil/edit', [\App\Http\Controllers\Pelanggan\ProfileController::class, 'edit'])
        ->name('pelanggan.profil.edit');

    Route::post('/profil/update', [\App\Http\Controllers\Pelanggan\ProfileController::class, 'update'])
        ->name('pelanggan.profil.update');

});


// Route untuk pegawai (pastikan ada middleware auth + role pegawai)
use App\Http\Controllers\Pegawai\MejaController;

Route::middleware(['auth', 'role:pegawai'])
    ->prefix('pegawai')       // semua URL diawali /pegawai
    ->as('pegawai.')          // semua nama route diawali pegawai.
    ->group(function () {
        Route::resource('meja', MejaController::class);
    });
Route::resource('produk', App\Http\Controllers\Pegawai\ProdukController::class)
     ->names('pegawai.produk');

Route::resource('pegawai/produk', ProdukController::class)->names([
    'index' => 'pegawai.produk.index',
    'create' => 'pegawai.produk.create',
    'store' => 'pegawai.produk.store',
    'show' => 'pegawai.produk.show',
    'edit' => 'pegawai.produk.edit',
    'update' => 'pegawai.produk.update',
    'destroy' => 'pegawai.produk.destroy',
]);

Route::get('/daftar-meja', [App\Http\Controllers\MejaController::class, 'index'])->name('daftar.meja');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

// Default dashboard (bisa dipakai kalau belum ada role)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/pesan-makanan', [PesanController::class, 'index'])->name('pesan.makanan');
Route::post('/pesan-makanan', [PesanController::class, 'store'])->name('pesan.makanan.store');

use App\Http\Controllers\Pegawai\PesananController;
use App\Http\Controllers\Pegawai\DetailPesananController;

Route::prefix('pegawai')->name('pegawai.')->group(function () {
    Route::resource('pesanan', PesananController::class);
    Route::post('detail-pesanan', [DetailPesananController::class, 'store'])->name('detail.store');
    Route::put('pesanan/{pesanan}/status/{status}', [PesananController::class, 'updateStatus'])->name('pesanan.status');
    Route::post('/pesanan/{pesanan}/update-status', [PesananController::class, 'updateStatus'])
    ->name('pesanan.updateStatus');

});

use App\Http\Controllers\PesananPelangganController;

Route::middleware(['auth'])->group(function () {
    Route::get('/pesanan', [PesananPelangganController::class, 'index'])->name('pelanggan.pesanan');
    Route::get('/pesanan-saya', [PesananPelangganController::class, 'riwayat'])->name('pelanggan.pesanan');
});


// routes/web.php
Route::get('/tentang', function () {
    return view('tentang'); // atau return view('beranda') jika konten tentang ada di beranda
})->name('tentang');

use App\Http\Controllers\Pelanggan\PemesananController;

Route::prefix('pesan')->middleware('auth')->group(function() {
    Route::get('/{id}', [PemesananController::class, 'create'])->name('pesan.create');
    Route::post('/', [PemesananController::class, 'store'])->name('pesan.store');
});


Route::middleware('auth')->group(function () {
    Route::get('/pesan', [PesanController::class, 'index'])->name('pesan');
    Route::post('/pesan/simpan', [PesanController::class, 'store'])->name('pesan.store');
});



use App\Http\Controllers\BerandaController;

Route::get('/', [BerandaController::class, 'index'])->name('beranda');

Route::get('/menu-meja', [BerandaController::class, 'menuMeja'])->name('menu-meja');




// Role-based route
Route::middleware(['auth'])->group(function () {
    // Admin
    Route::get('/admin', function () {
        return view('admin.dashboard'); // bikin file resources/views/admin/dashboard.blade.php
    })->name('admin.dashboard');

    // Pegawai
    Route::get('/pegawai', function () {
        return view('pegawai.dashboard'); // bikin file resources/views/pegawai/dashboard.blade.php
    })->name('pegawai.dashboard');

    // User
    Route::get('/user', function () {
        return view('user.dashboard'); // bikin file resources/views/user/dashboard.blade.php
    })->name('user.dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

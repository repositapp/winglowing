<?php

use App\Http\Controllers\AplikasiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\OngkirController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\RekeningController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;
use UniSharp\LaravelFilemanager\Lfm;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Customer Route
Route::middleware('guest:user')->group(function () {
    Route::get('/customer/login', [CustomerAuthController::class, 'index'])->name('customer.login');
    Route::post('/customer/authentication', [CustomerAuthController::class, 'authenticate'])->name('customer.authentication');

    Route::get('/customer/register', [CustomerAuthController::class, 'register'])->name('customer.register');
    Route::post('/customer/register', [CustomerAuthController::class, 'store'])->name('customer.register.store');
});

Route::post('/customer/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');
// Beramda
Route::get('/', [HomeController::class, 'index'])->name('index');
// Daftar Produk
Route::get('/produk', [ProdukController::class, 'produkAll'])->name('produk.all');
Route::get('/produk/kategori/{id}', [ProdukController::class, 'byKategori'])->name('produk.kategori');
Route::get('/produk/diskon', [ProdukController::class, 'diskon'])->name('produk.diskon');
Route::get('/produk/populer', [ProdukController::class, 'populer'])->name('produk.populer');
// Produk Detail
Route::get('/produk/{kode_produk}', [ProdukController::class, 'show'])->name('produk.detail');

Route::middleware(['auth:user'])->group(function () {
    // Keranjang
    Route::get('/keranjang', [ProdukController::class, 'keranjangIndex'])->name('keranjang.index');
    Route::post('/keranjang/tambah', [ProdukController::class, 'addToCart'])->name('keranjang.tambah');
    Route::delete('/keranjang/hapus/{id}', [ProdukController::class, 'hapusKeranjang'])->name('keranjang.hapus');
    // Checkout
    Route::get('/checkout', [TransaksiController::class, 'checkout'])->name('checkout.index');
    Route::post('/checkout', [TransaksiController::class, 'checkoutStore'])->name('checkout.store');
    Route::get('/checkout/pay/{kode_transaksi}', [TransaksiController::class, 'checkoutPay'])->name('checkout.pay');
    Route::put('/checkout/pay/store/{kode_transaksi}', [TransaksiController::class, 'checkoutPayStore'])->name('checkout.pay.store');
    // Riwayat Transaksi
    Route::get('/transaksi', [TransaksiController::class, 'transaksiIndex'])->name('transaksi.list');
    Route::get('/transaksi/detail/{kode_transaksi}', [TransaksiController::class, 'transaksiDetail'])->name('transaksi.detail');
});

// Admin Route
Route::middleware('guest:web')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/authentication', [AuthController::class, 'authenticate'])->name('authentication');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware('auth:web')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Mater Data
    Route::resource('kategori', KategoriController::class)->except(['show']);
    Route::resource('rekening', RekeningController::class)->except(['show']);
    Route::resource('ongkir', OngkirController::class)->except(['show']);
    Route::get('/get-districts/{city_id}', [OngkirController::class, 'getDistricts']);
    Route::get('/get-villages/{district_id}', [OngkirController::class, 'getVillages']);
    // Data Produk
    Route::resource('produk', ProdukController::class)->except(['show']);
    Route::delete('/produk/gambar/{id}', [ProdukController::class, 'destroyGambar'])->name('produk.destroyGambar');
    // Transaksi
    Route::get('/transaksi/{status}', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/detail/{kode_transaksi}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::put('/transaksi/update/{kode_transaksi}', [TransaksiController::class, 'updateStatus'])->name('transaksi.update');
    Route::put('/transaksi/cancel/{kode_transaksi}', [TransaksiController::class, 'cancel'])->name('transaksi.cancel');
    Route::get('/transaksi/invoice/{kode_transaksi}', [TransaksiController::class, 'cetakInvoice'])->name('transaksi.invoice');
    // Settings
    Route::resource('aplikasi', AplikasiController::class)->except(['show', 'create', 'store', 'destroy', 'edit']);
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

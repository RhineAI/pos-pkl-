<?php

use App\Models\Satuan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\ProdukController;
<<<<<<< HEAD
use App\Http\Controllers\StokMasukController;
use App\Http\Controllers\StokKeluarController;
use App\Http\Controllers\BuyController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\ReportPenjualanController;
use App\Http\Controllers\ReportKeuntunganController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingsController;
=======
use App\Http\Controllers\SupplierController;
use App\Models\Supplier;
>>>>>>> d5761e5323ac3f5f3516ea0f2fa2d97040b5e2c4

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', fn () => redirect()->route('login'));

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('home');
    })->name('dashboard');
});

// Route kategori
Route::group(['middleware' => 'auth'], function () {
    Route::get('/kategori/data', [KategoriController::class, 'data'])->name('kategori.data');
    Route::resource('/kategori', KategoriController::class);
});
// Route satuan
Route::group(['middleware' => 'auth'], function () {
    Route::get('/satuan/data', [SatuanController::class, 'data'])->name('satuan.data');
    Route::resource('/satuan', SatuanController::class);
});
// Route data produk
Route::group(['middleware' => 'auth'], function () {
    Route::get('/produk/data', [ProdukController::class, 'data'])->name('produk.data');
    Route::resource('/produk', ProdukController::class);
});
// Route stok masuk
Route::group(['middleware' => 'auth'], function () {
    Route::get('/stokmasuk/data', [StokMasukController::class, 'data'])->name('stokmasuk.data');
    Route::resource('/stokmasuk', StokMasukController::class);
});
// Route stok keluar
Route::group(['middleware' => 'auth'], function () {
    Route::get('/stokkeluar/data', [StokKeluarController::class, 'data'])->name('stokkeluar.data');
    Route::resource('/stokkeluar', StokKeluarController::class);
});
// Route stok pembelian
Route::group(['middleware' => 'auth'], function () {
    Route::get('/pembelian/data', [BuyController::class, 'data'])->name('pembelian.data');
    Route::resource('/pembelian', BuyController::class);
});
// Route stok penjualan
Route::group(['middleware' => 'auth'], function () {
    Route::get('/penjualan/data', [SellController::class, 'data'])->name('penjualan.data');
    Route::resource('/penjualan', SellController::class);
});
// Route stok laporan penjualan
Route::group(['middleware' => 'auth'], function () {
    Route::get('/reportpenjualan/data', [ReportPenjualanController::class, 'data'])->name('reportpenjualan.data');
    Route::resource('/reportpenjualan', ReportPenjualanController::class);
});
// Route stok laporan keuntungan
Route::group(['middleware' => 'auth'], function () {
    Route::get('/reportkeuntungan/data', [ReportKeuntunganController::class, 'data'])->name('reportkeuntungan.data');
    Route::resource('/reportkeuntungan', ReportKeuntunganController::class);
});
// Route pengguna
Route::group(['middleware' => 'auth'], function () {
    Route::get('/users/data', [UserController::class, 'data'])->name('users.data');
    Route::resource('/users', UserController::class);
});
// Route pengaturan
Route::group(['middleware' => 'auth'], function () {
    Route::get('/settings/data', [SettingsController::class, 'data'])->name('settings.data');
    Route::resource('/settings', SettingsController::class);
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/supplier/data', [SupplierController::class, 'data'])->name('supplier.data');
    Route::resource('/supplier', SupplierController::class);
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

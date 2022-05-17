<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StokMasukController;
use App\Http\Controllers\StokKeluarController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PembelianDetailController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PenjualanDetailController;
use App\Http\Controllers\ReportPenjualanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;



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
    Route::post('/produk/delete-selected', [ProdukController::class, 'deleteSelected'])->name('produk.delete_selected');
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

// Route record pembelian
Route::group(['middleware' => 'auth'], function () {
    Route::get('/pembelian/data', [PembelianController::class, 'data'])->name('pembelian.data');
    Route::get('/pembelian/{id}/create', [PembelianController::class, 'create'])->name('pembelian.create');
    Route::resource('/pembelian', PembelianController::class)
    ->except('create');

// Route pembelian detail
    Route::get('/pembelian_detail/{id}/data', [PembelianDetailController::class, 'data'])->name('pembelian_detail.data');
    Route::get('/pembelian_detail/loadform/{diskon}/{total}', [PembelianDetailController::class, 'loadForm'])->name('pembelian_detail.load_form');
    Route::resource('/pembelian_detail', PembelianDetailController::class)
    ->except('create', 'show', 'edit' );
});

//  Route record penjualan
Route::group(['middleware' => 'auth'], function () {
    // Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
    // Route::get('/penjualan/{id}', [PenjualanController::class, 'show'])->name('penjualan.show');
    Route::get('/daftarpenjualan/data', [PenjualanController::class, 'data'])->name('daftarpenjualan.data');
    Route::resource('/daftarpenjualan', PenjualanController::class)->except('create');
});

// Route transaksi penjualan
Route::group(['middleware' => 'auth'], function () {
    Route::get('/transaksi/baru', [PenjualanController::class, 'create'])->name('transaksi.baru');
    Route::post('/transaksi/simpan', [PenjualanController::class, 'store'])->name('transaksi.simpan');
    Route::get('/transaksi/done', [PenjualanController::class, 'done'])->name('transaksi.done');
    Route::get('/transaksi/nota-kecil', [PenjualanController::class, 'notaKecil'])->name('transaksi.nota_kecil');
    // Route::get('/transaksi/nota-besar', [PenjualanController::class, 'notaBesar'])->name('transaksi.nota_besar');

    Route::get('/transaksi/{id}/data', [PenjualanDetailController::class, 'data'])->name('transaksi.data');
    Route::get('/transaksi/loadform/{diskon}/{total}/{diterima}', [PenjualanDetailController::class, 'loadForm'])->name('transaksi.load_form');
    Route::resource('/transaksi', PenjualanDetailController::class)->except('show');
});

// Route stok penjualan lama
// Route::group(['middleware' => 'auth'], function () {
//     Route::get('/penjualandetail/data', [PenjualanDetailController::class, 'data'])->name('penjualandetail.data');
//     Route::resource('/penjualandetail', PenjualanDetailController::class);
// });

// Route Supplier
Route::group(['middleware' => 'auth'], function () {
    Route::get('/supplier/data', [SupplierController::class, 'data'])->name('supplier.data');
    Route::resource('/supplier', SupplierController::class);
});

// Route stok laporan penjualan
Route::group(['middleware' => 'auth'], function () {
    Route::get('/reportpenjualan/data', [ReportPenjualanController::class, 'data'])->name('reportpenjualan.data');
    Route::resource('/reportpenjualan', ReportPenjualanController::class);
});
//Route pengguna
Route::group(['middleware' => 'auth'], function () {
    Route::get('/users/data', [UserController::class, 'data'])->name('users.data');
    Route::resource('/users', UserController::class);
});

// Route pengaturan
Route::group(['middleware' => 'auth'], function () {
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/setting', [SettingController::class, 'update'])->name('setting.update');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

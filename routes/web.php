<?php
use App\Http\Controllers\{
    DashboardController,
    KategoriController,
    SatuanController,
    ProdukController,
    SupplierController,
    StokMasukController,
    StokKeluarController,
    PembelianController,
    PembelianDetailController,
    PengembalianBarangController,
    PenjualanController,
    PenjualanDetailController,
    ReportPembelianController,
    ReportPenjualanController,
    UserController,
    SettingController 

};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
]);
Route::group(['middleware' => 'auth'], function () {
    // Route dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
    
    Route::group(['middleware' => 'level:1'], function () {
    // Route kategori
    Route::get('/kategori/data', [KategoriController::class, 'data'])->name('kategori.data');
    Route::resource('/kategori', KategoriController::class);

    // Route satuan
    Route::get('/satuan/data', [SatuanController::class, 'data'])->name('satuan.data');
    Route::resource('/satuan', SatuanController::class);

    // Route data produk
    Route::get('/produk/data', [ProdukController::class, 'data'])->name('produk.data');
    Route::post('/produk/delete-selected', [ProdukController::class, 'deleteSelected'])->name('produk.delete_selected');
    Route::resource('/produk', ProdukController::class);

    // Route stok masuk
    Route::get('/stokmasuk/data', [StokMasukController::class, 'data'])->name('stokmasuk.data');
    Route::resource('/stokmasuk', StokMasukController::class);

    // Route stok keluar
    Route::get('/stokkeluar/data', [StokKeluarController::class, 'data'])->name('stokkeluar.data');
    Route::resource('/stokkeluar', StokKeluarController::class);

});

Route::group(['middleware' => 'auth'], function () {
     
});

// Route record pembelian
Route::group(['middleware' => 'auth'], function () {
    Route::get('/pembelian/data', [PembelianController::class, 'data'])->name('pembelian.data');
    Route::get('/pembelian/{id}/create', [PembelianController::class, 'create'])->name('pembelian.create');
    Route::resource('/pembelian', PembelianController::class)
    ->except('create');

    Route::get('/pembelian/{id}/return', [PembelianController::class, 'return'])->name('pembelian.batalkan');
    // Route::get('/pembelian/cancel/{id}', [PembelianController::class, 'cancel'])->name('pembelian.cancel');

    // Route pembelian detail
    Route::get('/pembelian_detail/{id}/data', [PembelianDetailController::class, 'data'])->name('pembelian_detail.data');
    // Route::get('/pembeliandetail/cancel/{id}', [PembelianController::class, 'cancel'])->name('pembelian_detail.cancel');
    Route::get('/pembelian_detail/loadform/{diskon}/{total}/{diterima}', [PembelianDetailController::class, 'loadForm'])->name('pembelian_detail.load_form');
   
    Route::resource('/pembelian_detail', PembelianDetailController::class)
    ->except('create', 'show', 'edit' );

    // Route Pengembalian Barang
    Route::get('/pengembalianBarang/data', [PengembalianBarangController::class, 'data'])->name('pengembalian_barang.data');
    Route::resource('/pengembalianBarang', PengembalianBarangController::class);

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
    Route::get('/transaksi/cancel/{id}', [PenjualanController::class, 'cancel'])->name('transaksi.cancel');
    Route::get('/transaksi/nota-kecil', [PenjualanController::class, 'notaKecil'])->name('transaksi.nota_kecil');
    // Route::get('/transaksi/nota-besar', [PenjualanController::class, 'notaBesar'])->name('transaksi.nota_besar');

    Route::get('/transaksi/{id}/data', [PenjualanDetailController::class, 'data'])->name('transaksi.data');
    Route::get('/transaksi/loadform/{diskon}/{total}/{diterima}', [PenjualanDetailController::class, 'loadForm'])->name('transaksi.load_form');
    Route::resource('/transaksi', PenjualanDetailController::class)->except('show');
});


// Route Supplier
Route::group(['middleware' => 'auth'], function () {
    Route::get('/supplier/data', [SupplierController::class, 'data'])->name('supplier.data');
    Route::get('/supplier/tambah', [SupplierController::class, 'tambah'])->name('supplier.tambah');
    Route::post('/supplier/simpan-produk', [SupplierController::class, 'simpanProduk'])->name('supplier.produk');
    Route::resource('/supplier', SupplierController::class);


    // Route stok laporan pembelian
    Route::get('/reportpembelian/data/{awal}/{akhir}', [ReportPembelianController::class, 'data'])->name('reportpembelian.data');
    Route::get('/reportpembelian/pdf/{awal}/{akhir}', [ReportPembelianController::class, 'exportPDF'])->name('reportpembelian.export_pdf');
    Route::resource('/reportpembelian', ReportPembelianController::class);

    //Route pengguna
    Route::get('/users/data', [UserController::class, 'data'])->name('users.data');
    Route::resource('/users', UserController::class);

    // Route pengaturan
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::get('/setting/first', [SettingController::class, 'show'])->name('setting.show');
    Route::post('/setting', [SettingController::class, 'update'])->name('setting.update');
});

    // Route stok penjualan
    Route::get('/penjualan/data', [PenjualanController::class, 'data'])->name('penjualan.data');
    Route::resource('/penjualan', PenjualanController::class);

    // Route stok laporan penjualan
    Route::resource('/reportpenjualan', ReportPenjualanController::class);
    // Route::get('/reportpenjualan', [ReportPenjualanController::class, 'refresh'])->name('reportpenjualan.refresh');
    Route::get('/reportpenjualan/data/{awal}/{akhir}', [ReportPenjualanController::class, 'data'])->name('reportpenjualan.data');
    Route::get('/reportpenjualan/pdf/{awal}/{akhir}', [ReportPenjualanController::class, 'exportPDF'])->name('reportpenjualan.export_pdf');

    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/profile', [UserController::class, 'updateProfile'])->name('user.update_profile');

});




// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

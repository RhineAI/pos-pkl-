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
    PenjualanController,
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

    // Route stok pembelian
    Route::get('/pembelian/data', [PembelianController::class, 'data'])->name('pembelian.data');
    Route::get('/pembelian/{id}/create', [PembelianController::class, 'create'])->name('pembelian.create');
    Route::resource('/pembelian', PembelianController::class)
    ->except('create');

    // Route pembelian detail
    Route::get('/pembelian_detail/{id}/data', [PembelianDetailController::class, 'data'])->name('pembelian_detail.data');
    Route::get('/pembelian_detail/loadform/{diskon}/{total}', [PembelianDetailController::class, 'loadForm'])->name('pembelian_detail.load_form');
    Route::resource('/pembelian_detail', PembelianDetailController::class)
    ->except('create', 'show', 'edit' );

    // Route Supplier
    Route::get('/supplier/data', [SupplierController::class, 'data'])->name('supplier.data');
    Route::resource('/supplier', SupplierController::class);

    // Route stok laporan penjualan
    Route::get('/reportpembelian/data', [ReportPembelianController::class, 'data'])->name('reportpembelian.data');
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
    Route::get('/reportpenjualan/data', [ReportPenjualanController::class, 'data'])->name('reportpenjualan.data');
    Route::resource('/reportpenjualan', ReportPenjualanController::class);

    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/profile', [UserController::class, 'updateProfile'])->name('user.update_profile');

});




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

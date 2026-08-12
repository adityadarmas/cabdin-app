<?php

use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\ProsedurController;
use App\Http\Controllers\KategoriProsedurController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\UserAccessController;
use App\Http\Controllers\OperatorAkunController;
use App\Http\Controllers\DapodikJadwalController;
use App\Http\Controllers\NomorSuratSettingController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\OperatorPengajuanController;
use App\Http\Controllers\AdminPengajuanController;
use App\Http\Controllers\JenisPengajuanController;
use App\Http\Controllers\OperatorNotificationController;
use App\Http\Controllers\OperatorDashboardController;
use App\Http\Controllers\OperatorTagihanController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\KategoriPengajuanController;
use App\Http\Controllers\KategoriInformasiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ================== HALAMAN PUBLIK ==================
// Route::get('/', [LandingController::class, 'error']);
Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::get('/skalaku', [ProdukController::class, 'allindex'])->name('produk.allindex');

Route::get('/prosedur/kategori/{kategoriProsedur}', [ProsedurController::class, 'category'])->name('prosedur.category');
Route::get('/prosedur/{prosedur}', [ProsedurController::class, 'show'])->name('prosedur.show');

Route::get('/berita', [BeritaController::class, 'publicIndex'])->name('berita.all');
Route::get('/berita/{berita}', [BeritaController::class, 'show'])->name('berita.show');

Route::get('/track/{token}', [TrackingController::class, 'show'])->name('tracking.show');
Route::post('/track/{token}/refresh', [TrackingController::class, 'refresh'])->name('tracking.refresh');

// ================== DAFTAR TAMU ==================
Route::get('/tamu', [TamuController::class, 'index'])->name('tamu.index');
Route::get('/tamu/create', [TamuController::class, 'create'])->name('tamu.create');
Route::post('/tamu', [TamuController::class, 'store'])->name('tamu.store');
Route::get('/tamu/{tamu}/edit', [TamuController::class, 'edit'])->name('tamu.edit');
Route::put('/tamu/{tamu}', [TamuController::class, 'update'])->name('tamu.update');

// ================== SETUP AWAL (hanya jika belum ada admin) ==================
Route::get('/setup/init-admin', [UserAccessController::class, 'initAdmin'])->name('setup.init-admin');

// ================== GUEST ==================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');

    // Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
    // Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// ================== AUTH ==================
Route::middleware('auth')->group(function () {

    // ================== OPERATOR SEKOLAH ==================
    Route::middleware('role:operator,admin')->group(function () {
        Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
        Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    });

    Route::middleware('role:operator')->prefix('operator')->group(function () {
        Route::get('/', [OperatorDashboardController::class, 'index'])->name('operator.dashboard');
        Route::get('/notifikasi/data', [OperatorNotificationController::class, 'feed'])->name('operator.notifikasi.feed');
        Route::get('/notifikasi', [OperatorNotificationController::class, 'index'])->name('operator.notifikasi.index');
        Route::get('/tagihan', [OperatorTagihanController::class, 'index'])->name('operator.tagihan.index');
        Route::post('/tagihan/{jenisPengajuan}/konfirmasi', [OperatorTagihanController::class, 'confirm'])->name('operator.tagihan.confirm');
        Route::get('/akun', [OperatorAkunController::class, 'edit'])->name('operator.akun.edit');
        Route::put('/akun', [OperatorAkunController::class, 'update'])->name('operator.akun.update');

        Route::get('/produk', [ProdukController::class, 'operatorIndex'])->name('operator.produk.index');
        Route::get('/produk/{produk}', [ProdukController::class, 'show'])->name('operator.produk.show');
        Route::get('/produk/{produk}/edit', [ProdukController::class, 'operatorEdit'])->name('operator.produk.edit');
        Route::put('/produk/{produk}', [ProdukController::class, 'operatorUpdate'])->name('operator.produk.update');
        Route::delete('/produk/{produk}', [ProdukController::class, 'operatorDestroy'])->name('operator.produk.destroy');

        Route::get('/pengajuan/jenis/{jenisPengajuan}', [OperatorPengajuanController::class, 'jenis'])
            ->name('operator.pengajuan.jenis');
        Route::resource('pengajuan', OperatorPengajuanController::class)
            ->except(['show'])
            ->names('operator.pengajuan');
        Route::get('/pengajuan/{pengajuan}', [OperatorPengajuanController::class, 'show'])
            ->name('operator.pengajuan.show');
    });

    Route::resource('surat-masuk', SuratMasukController::class);

    // ================== SURAT KELUAR (semua role kecuali operator) ==================
    Route::middleware('role:admin,tu,staff,pimpinan')->group(function () {
        Route::resource('surat-keluar', SuratKeluarController::class)
            ->except(['show']);
    });
    Route::post('surat-masuk/{suratMasuk}/disposisi', [SuratMasukController::class, 'disposisi'])
        ->name('surat-masuk.disposisi');
    Route::post('surat-masuk/{suratMasuk}/generate-token', [SuratMasukController::class, 'generateToken'])
        ->name('surat-masuk.generate-token');
    Route::post('surat-masuk/{suratMasuk}/kirim', [SuratMasukController::class, 'kirim'])
        ->name('surat-masuk.kirim');
    Route::post('surat-masuk/{suratMasuk}/setujui', [SuratMasukController::class, 'setujui'])
        ->name('surat-masuk.setujui');
    Route::post('surat-masuk/{suratMasuk}/selesai', [SuratMasukController::class, 'selesai'])
        ->name('surat-masuk.selesai');
    Route::get('surat-masuk/{suratMasuk}/kitir', [SuratMasukController::class, 'kitir'])
        ->name('surat-masuk.kitir');
    Route::post('surat-masuk/{suratMasuk}/kitir', [SuratMasukController::class, 'updateKitir'])
        ->name('surat-masuk.kitir.update');
    Route::get('surat-masuk/{suratMasuk}/disposisi-cetak', [SuratMasukController::class, 'disposisiCetak'])
        ->name('surat-masuk.disposisi-cetak');
    Route::get('surat-masuk/{suratMasuk}/tanda-terima', [SuratMasukController::class, 'tandaTerima'])
        ->name('surat-masuk.tanda-terima');

    // ================== ADMIN ==================
    Route::middleware('role:admin')->prefix('admin')->group(function () {

        Route::get('/pengajuan', [AdminPengajuanController::class, 'index'])->name('admin.pengajuan.index');
        Route::get('/pengajuan/jenis/{jenisPengajuan}', [AdminPengajuanController::class, 'jenis'])->name('admin.pengajuan.jenis');
        Route::get('/pengajuan/export', [AdminPengajuanController::class, 'export'])->name('admin.pengajuan.export');
        Route::get('/pengajuan/{pengajuan}', [AdminPengajuanController::class, 'show'])->name('admin.pengajuan.show');
        Route::put('/pengajuan/{pengajuan}', [AdminPengajuanController::class, 'update'])->name('admin.pengajuan.update');
        Route::resource('jenis-pengajuan', JenisPengajuanController::class)->except(['show']);
        Route::resource('kategori-pengajuan', KategoriPengajuanController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::resource('kategori-informasi', KategoriInformasiController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::resource('pengumuman', PengumumanController::class)->except(['show']);

        Route::get('/register', [RegisterController::class, 'showRegister'])->name('admin.register');
        Route::post('/register', [RegisterController::class, 'register']);

        // Halaman detail publik memakai nama berita.show. Admin tidak memiliki
        // tampilan show tersendiri, sehingga route tersebut dikecualikan agar
        // route cache dapat dibuat tanpa konflik nama.
        Route::resource('berita', BeritaController::class)
            ->except(['show'])
            ->parameters(['berita' => 'berita']);

        Route::resource('users', UserAccessController::class)
            ->parameters(['users' => 'user'])
            ->names([
                'index'   => 'admin.users.index',
                'store'   => 'admin.users.store',
                'update'  => 'admin.users.update',
                'destroy' => 'admin.users.destroy',
            ]);

        Route::put('/users/{user}/update-password', [UserAccessController::class, 'updatePassword'])
            ->name('admin.users.updatePassword');

        // Detail prosedur tersedia pada halaman publik; panel admin tidak
        // membutuhkan route show terpisah.
        Route::resource('prosedur', ProsedurController::class)->except(['show']);

        Route::resource('kategori-prosedur', KategoriProsedurController::class)
            ->parameters(['kategori-prosedur' => 'kategoriProsedur'])
            ->except(['show']);

        Route::get('/dapodik-jadwal/{jenis}/edit', [DapodikJadwalController::class, 'edit'])
            ->name('dapodik-jadwal.edit');
        Route::put('/dapodik-jadwal/{jenis}', [DapodikJadwalController::class, 'update'])
            ->name('dapodik-jadwal.update');

        Route::get('/produk', [ProdukController::class, 'index'])
            ->name('produk.index')
            ->can('viewAny', App\Models\Produk::class);

        Route::get('/produk/{produk}/edit', [ProdukController::class, 'edit'])
            ->name('produk.edit')
            ->can('update', 'produk');

        Route::put('/produk/{produk}', [ProdukController::class, 'update'])
            ->name('produk.update')
            ->can('update', 'produk');

        Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])
            ->name('produk.destroy')
            ->can('delete', 'produk');

        Route::get('/nomor-surat-setting', [NomorSuratSettingController::class, 'edit'])
            ->name('admin.nomor-surat-setting.edit');
        Route::put('/nomor-surat-setting', [NomorSuratSettingController::class, 'update'])
            ->name('admin.nomor-surat-setting.update');
    });
});

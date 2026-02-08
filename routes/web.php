<?php

use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\ProsedurController;
use App\Http\Controllers\ProdukController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ================== HALAMAN UMUM ==================
Route::get('/landing', [LandingController::class, 'index'])->name('landing');
Route::get('/', [LandingController::class, 'error']);

Route::get('/produk/create', [ProdukController::class, 'create'])
    ->name('produk.create');

Route::post('/produk', [ProdukController::class, 'store'])
    ->name('produk.store');

Route::get('/all-produk', [ProdukController::class, 'allindex'])
    ->name('produk.allindex');

Route::get('/prosedur/{prosedur}', [ProsedurController::class, 'show'])
    ->name('prosedur.show');

Route::get('/berita', [BeritaController::class, 'publicIndex'])
    ->name('berita.all');

Route::get('/berita/{berita}', [BeritaController::class, 'show'])
    ->name('berita.show');
    
// ================== DAFTAR TAMU ==================

Route::get('/tamu', [TamuController::class, 'index'])->name('tamu.index');
Route::get('/tamu/create', [TamuController::class, 'create'])->name('tamu.create');
Route::post('/tamu', [TamuController::class, 'store'])->name('tamu.store');
Route::get('/tamu/{tamu}/edit', [TamuController::class, 'edit'])->name('tamu.edit');
Route::put('/tamu/{tamu}', [TamuController::class, 'update'])->name('tamu.update');
Route::resource('produk', ProdukController::class);
    
// ================== GUEST ==================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');

    Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/login');
})->name('logout');


// ================== AUTH ==================
Route::middleware('auth')->group(function () {
    Route::resource('surat-masuk', SuratMasukController::class);
    Route::post('surat-masuk/{suratMasuk}/disposisi',[SuratMasukController::class, 'disposisi'])->name('surat-masuk.disposisi');
    Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard.index');
        })->name('dashboard.index');
        
        Route::resource('berita', BeritaController::class)
            ->parameters(['berita' => 'berita']);
        
        Route::resource('prosedur', ProsedurController::class);
        
        Route::get('/admin/produk', [ProdukController::class, 'index'])
            ->name('produk.index')
            ->can('viewAny', App\Models\Produk::class);

        Route::get('/admin/produk/{produk}/edit', [ProdukController::class, 'edit'])
            ->name('produk.edit')
            ->can('update', 'produk');

        Route::put('/admin/produk/{produk}', [ProdukController::class, 'update'])
            ->name('produk.update')
            ->can('update', 'produk');

        Route::delete('/admin/produk/{produk}', [ProdukController::class, 'destroy'])
            ->name('produk.destroy')
            ->can('delete', 'produk');
    });
        
});

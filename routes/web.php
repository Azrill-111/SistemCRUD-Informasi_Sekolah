<?php
// Dikerjakan secara mandiri

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InformasiController as AdminInformasiController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\InformasiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Awal
|--------------------------------------------------------------------------
| Mengarahkan pengunjung sesuai status login dan role-nya.
*/

Route::get('/', function () {
    if (! Auth::check()) {
        return redirect()->route('login');
    }

    return Auth::user()->isAdmin()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('informasi.index');
})->name('home');

/*
|--------------------------------------------------------------------------
| Autentikasi (satu halaman login untuk admin & user)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Halaman User / Siswa (read-only)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/informasi', [InformasiController::class, 'index'])->name('informasi.index');
    Route::get('/informasi/{informasi}', [InformasiController::class, 'show'])->name('informasi.show');
});

/*
|--------------------------------------------------------------------------
| Area Admin
|--------------------------------------------------------------------------
| Middleware "auth" memastikan sudah login, middleware "admin" memastikan
| role-nya admin sehingga user/siswa tidak bisa mengakses URL ini (403).
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('informasi', AdminInformasiController::class);
    });

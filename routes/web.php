<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FasumController;
use App\Http\Controllers\Admin\RuangController;
use App\Http\Controllers\Admin\GedungController;
use App\Http\Controllers\Admin\PeriodeController;

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

Route::get('/', function () {
    return view('welcome');
});

// admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::prefix('data')->group(function () {
        // user
        Route::get('/user', [UserController::class, 'index'])->name('data.user');
        Route::post('/user', [UserController::class, 'store'])->name('user.store');
        Route::get('/user/{id}/show', [UserController::class, 'show'])->name('user.show');
        Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
        
        // gedung
        Route::get('/gedung', [GedungController::class, 'index'])->name('data.gedung');
        Route::post('/gedung', [GedungController::class, 'store'])->name('gedung.store');
        Route::get('/gedung/{id}/edit', [GedungController::class, 'edit'])->name('gedung.edit');
        Route::put('/gedung/{id}', [GedungController::class, 'update'])->name('gedung.update');
        Route::delete('/gedung/{id}', [GedungController::class, 'destroy'])->name('gedung.destroy');
        
        // fasilitas umum
        Route::get('/fasum', [FasumController::class, 'index'])->name('data.fasum');
        Route::post('/fasum', [FasumController::class, 'store'])->name('fasum.store');
        Route::get('/fasum/{id}/edit', [FasumController::class, 'edit'])->name('fasum.edit');
        Route::put('/fasum/{id}', [FasumController::class, 'update'])->name('fasum.update');
        Route::delete('/fasum/{id}', [FasumController::class, 'destroy'])->name('fasum.destroy');

        // ruang
        Route::get('/ruang', [RuangController::class, 'index'])->name('data.ruang');
        Route::post('/ruang', [RuangController::class, 'store'])->name('ruang.store');
        Route::get('/ruang/{id}/show', [RuangController::class, 'show'])->name('ruang.show');
        Route::get('/ruang/{id}/edit', [RuangController::class, 'edit'])->name('ruang.edit');
        Route::put('/ruang/{id}', [RuangController::class, 'update'])->name('ruang.update');
        Route::delete('/ruang/{id}', [RuangController::class, 'destroy'])->name('ruang.destroy');

        // periode
        Route::get('/periode', [PeriodeController::class, 'index'])->name('data.periode');
    });
});

// mahasiswa
Route::middleware(['auth', 'role:mahasiswa|dosen|tendik'])->prefix('users')->group(function () {
    Route::get('/dashboard', function () {
        return view('users.dashboard');
    })->name('users.dashboard');
});

// sarpras
Route::middleware(['auth', 'role:sarpras'])->prefix('sarpras')->group(function () {
    Route::get('/dashboard', function () {
        return view('sarpras.dashboard');
    })->name('sarpras.dashboard');
});

// teknisi
Route::middleware(['auth', 'role:teknisi'])->prefix('teknisi')->group(function () {
    Route::get('/dashboard', function () {
        return view('teknisi.dashboard');
    })->name('teknisi.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
});

require __DIR__.'/auth.php';
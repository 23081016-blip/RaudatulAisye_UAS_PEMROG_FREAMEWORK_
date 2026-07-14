<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MekanikController;
use App\Http\Controllers\KasirController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// SEMUA USER YANG LOGIN AKAN MASUK KE SINI
Route::middleware(['auth'])->group(function () {
    
    // Satu dashboard utama untuk semua akun
    Route::get('/dashboard', [AdminController::class, 'superDashboard'])->name('dashboard');
    
    // Proses Backend CRUD Sparepart
    Route::post('/super/sparepart', [AdminController::class, 'storeSparepart'])->name('super.sparepart.store');
    Route::put('/super/sparepart/{id}', [AdminController::class, 'updateSparepart'])->name('super.sparepart.update');
    Route::delete('/super/sparepart/{id}', [AdminController::class, 'destroySparepart'])->name('super.sparepart.destroy');
    
    // Proses Backend CRUD Jasa
    Route::post('/super/jasa', [AdminController::class, 'storeJasa'])->name('super.jasa.store');
    Route::put('/super/jasa/{id}', [AdminController::class, 'updateJasa'])->name('super.jasa.update');
    Route::delete('/super/jasa/{id}', [AdminController::class, 'destroyJasa'])->name('super.jasa.destroy');
    
    // Proses Backend Alur Kerja Mekanik
    Route::put('/super/servis/{id}/status/{status}', [MekanikController::class, 'updateStatus'])->name('super.servis.status');
    Route::post('/super/servis/{id}/detail', [MekanikController::class, 'tambahDetail'])->name('super.servis.detail');
    
    // Proses Backend Transaksi Kasir
    Route::post('/super/servis/{id}/bayar', [KasirController::class, 'bayar'])->name('super.servis.bayar');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
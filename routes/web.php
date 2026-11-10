<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatController;
use Illuminate\Support\Facades\Route;

// Publik
Route::get('/', function () {
    return view('home');
})->name('home');

// Semua di bawah ini wajib login (middleware auth)
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profil sendiri
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->middleware('permission:lihat profil sendiri')->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->middleware('permission:ubah profil sendiri')->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->middleware('permission:ubah profil sendiri')->name('profile.destroy');

    // Buku (Modul 1 sampai 4)
    Route::middleware('permission:lihat daftar buku')->group(function () {
        Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
        Route::get('/buku/{id}', [BukuController::class, 'show'])->name('buku.show');
    });
    Route::get('/kelola/buku', [BukuController::class, 'kelola'])
        ->middleware('permission:kelola data buku')->name('kelola.buku');

    // Dashboard per role
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->middleware('permission:akses dashboard admin')->name('admin.dashboard');
    Route::get('/petugas/dashboard', [DashboardController::class, 'petugas'])
        ->middleware('permission:akses dashboard petugas')->name('petugas.dashboard');

    // Pengguna dan role (hanya admin)
    Route::prefix('admin/users')->name('admin.users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])
            ->middleware('permission:kelola data pengguna')->name('index');
        Route::patch('/{user}/role', [UserController::class, 'updateRole'])
            ->middleware('permission:kelola role pengguna')->name('role');
        Route::delete('/{user}', [UserController::class, 'destroy'])
            ->middleware('permission:kelola data pengguna')->name('destroy');
    });

    // Peminjaman dan pengembalian
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])
        ->middleware('permission:kelola peminjaman')->name('peminjaman.index');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])
        ->middleware('permission:kelola peminjaman')->name('peminjaman.store');
    Route::patch('/peminjaman/{peminjaman}/kembali', [PeminjamanController::class, 'kembalikan'])
        ->middleware('permission:kelola pengembalian')->name('peminjaman.kembali');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])
        ->middleware('permission:lihat laporan perpustakaan')->name('laporan.index');

    // Riwayat milik sendiri
    Route::middleware('permission:lihat riwayat peminjaman sendiri')->group(function () {
        Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
        Route::get('/riwayat/{anggota}', [RiwayatController::class, 'show'])->name('riwayat.show');
    });
});

// Route Breeze: login, register, logout (memakai middleware guest dan auth)
require __DIR__.'/auth.php';
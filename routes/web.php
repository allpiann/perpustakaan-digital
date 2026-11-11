<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->middleware('permission:lihat profil sendiri')->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->middleware('permission:ubah profil sendiri')->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->middleware('permission:ubah profil sendiri')->name('profile.destroy');

    // ===== Modul 6, Soal 2 =====
    Route::get('/buku-cari', [BukuController::class, 'cari'])->name('buku.cari');
    // Route GET /buku/{buku}/hapus DIHAPUS, diganti DELETE:
    Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])
        ->whereNumber('buku')->name('buku.destroy');
    // A4 masih rentan (ditutup di Soal 4)
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])
        ->whereNumber('id')->name('peminjaman.show');
    // ===========================

    Route::middleware('permission:lihat daftar buku')->group(function () {
        Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
        Route::get('/buku/daftar', [BukuController::class, 'daftar'])->name('buku.daftar');
        Route::get('/buku/{id}', [BukuController::class, 'show'])->whereNumber('id')->name('buku.show');
    });
    Route::get('/kelola/buku', [BukuController::class, 'kelola'])
        ->middleware('permission:kelola data buku')->name('kelola.buku');

    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->middleware('permission:akses dashboard admin')->name('admin.dashboard');
    Route::get('/petugas/dashboard', [DashboardController::class, 'petugas'])
        ->middleware('permission:akses dashboard petugas')->name('petugas.dashboard');

    Route::prefix('admin/users')->name('admin.users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])
            ->middleware('permission:kelola data pengguna')->name('index');
        Route::patch('/{user}/role', [UserController::class, 'updateRole'])
            ->middleware('permission:kelola role pengguna')->name('role');
        Route::delete('/{user}', [UserController::class, 'destroy'])
            ->middleware('permission:kelola data pengguna')->name('destroy');
    });

    Route::get('/peminjaman', [PeminjamanController::class, 'index'])
        ->middleware('permission:kelola peminjaman')->name('peminjaman.index');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])
        ->middleware('permission:kelola peminjaman')->name('peminjaman.store');
    Route::patch('/peminjaman/{peminjaman}/kembali', [PeminjamanController::class, 'kembalikan'])
        ->middleware('permission:kelola pengembalian')->name('peminjaman.kembali');

    Route::get('/laporan', [LaporanController::class, 'index'])
        ->middleware('permission:lihat laporan perpustakaan')->name('laporan.index');

    Route::middleware('permission:lihat riwayat peminjaman sendiri')->group(function () {
        Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
        Route::get('/riwayat/{anggota}', [RiwayatController::class, 'show'])->name('riwayat.show');
    });
});

require __DIR__.'/auth.php';
<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->hasRole('petugas')) {
            return redirect()->route('petugas.dashboard');
        }

        return view('dashboard');
    }

    public function admin()
    {
        return view('admin.dashboard', [
            'totalBuku'       => Buku::count(),
            'totalUser'       => User::count(),
            'totalAnggota'    => Anggota::count(),
            'sedangDipinjam'  => Peminjaman::whereNull('tanggal_kembali')->count(),
        ]);
    }

    public function petugas()
    {
        return view('petugas.dashboard', [
            'totalBuku'      => Buku::count(),
            'sedangDipinjam' => Peminjaman::whereNull('tanggal_kembali')->count(),
        ]);
    }
}
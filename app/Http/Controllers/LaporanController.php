<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index', [
            'totalBuku'      => Buku::count(),
            'totalAnggota'   => Anggota::count(),
            'totalPinjam'    => Peminjaman::count(),
            'sedangDipinjam' => Peminjaman::whereNull('tanggal_kembali')->count(),
            'sudahKembali'   => Peminjaman::whereNotNull('tanggal_kembali')->count(),
            'terpopuler'     => Buku::withCount('peminjamans')
                                    ->orderByDesc('peminjamans_count')->take(5)->get(),
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        return view('peminjaman.index', [
            'peminjamans' => Peminjaman::with(['anggota', 'buku'])->latest('id')->paginate(10),
            'anggotas'    => Anggota::orderBy('nama')->get(['id', 'nama']),
            'bukus'       => Buku::orderBy('judul')->get(['id', 'judul']),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'anggota_id' => ['required', 'exists:anggotas,id'],
            'buku_id'    => ['required', 'exists:bukus,id'],
        ]);

        Peminjaman::create($data + ['tanggal_pinjam' => now()->toDateString()]);

        return back()->with('status', 'Peminjaman berhasil dicatat.');
    }

    public function kembalikan(Peminjaman $peminjaman)
    {
        if ($peminjaman->tanggal_kembali) {
            return back()->withErrors(['kembali' => 'Buku ini sudah dikembalikan.']);
        }

        $peminjaman->update(['tanggal_kembali' => now()->toDateString()]);

        return back()->with('status', 'Pengembalian berhasil dicatat.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    // Halaman /buku (Modul 4, fetch API)
    public function index()
    {
        return view('buku.index');
    }

    // Halaman /buku/{id} (detail). CEK: samakan dengan show lamamu bila berbeda
    public function show($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);

        return view('buku.show', compact('buku'));
    }

    // Modul 5: halaman kelola buku
    public function kelola()
    {
        return view('buku.index');
    }

    // ===== Modul 6, Soal 1 =====

    // Halaman daftar buku yang dirender Blade (untuk A1)
    public function daftar()
    {
        $bukus = Buku::with('kategori')->latest('id')->get();

        return view('buku.daftar', compact('bukus'));
    }

    // A2: SQL Injection (nilai judul digabung langsung ke string SQL)
    public function cari(Request $request)
    {
        $judul = $request->query('judul');

        $hasil = DB::select("SELECT * FROM bukus WHERE judul = '$judul'");

        return response()->json($hasil);
    }

    // A3: dipanggil lewat route GET /buku/{buku}/hapus
    public function destroy(Buku $buku)
    {
        $buku->delete();

        return redirect()->route('buku.daftar')->with('status', 'Buku berhasil dihapus.');
    }
}
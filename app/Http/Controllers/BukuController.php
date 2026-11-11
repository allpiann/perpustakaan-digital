<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    // Halaman /buku (Modul 4, fetch API)
    public function index()
    {
        return view('buku.index');
    }

    // Halaman /buku/{id} (detail). Samakan dengan show lamamu bila berbeda
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

    // Daftar buku yang dirender Blade
    public function daftar()
    {
        $bukus = Buku::with('kategori')->latest('id')->get();

        return view('buku.daftar', compact('bukus'));
    }

    // A2 DITAMBAL: query dengan binding (tanda ? dan array)
    public function cari(Request $request)
    {
        $judul = $request->query('judul');

        $hasil = DB::select('SELECT * FROM bukus WHERE judul = ?', [$judul]);

        return response()->json($hasil);
    }

    // A3 DITAMBAL: sekarang dipanggil lewat route DELETE
    public function destroy(Buku $buku)
    {
        try {
            $buku->delete();
        } catch (QueryException $e) {
            return redirect()->route('buku.daftar')
                ->withErrors(['hapus' => 'Buku tidak dapat dihapus karena masih memiliki data peminjaman.']);
        }

        return redirect()->route('buku.daftar')->with('status', 'Buku berhasil dihapus.');
    }
}
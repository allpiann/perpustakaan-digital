<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    private function rulesBuku(): array
    {
        return [
            'kategori_id'  => ['required', 'exists:kategoris,id'],
            'judul'        => ['required', 'string', 'min:3', 'max:150'],
            'penulis'      => ['required', 'string', 'min:3', 'max:100'],
            'tahun_terbit' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
        ];
    }

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

    // ===== Modul 6, Soal 3: tambah dan ubah (dijaga Gate kelola-buku di route) =====
    public function create()
    {
        return view('buku.form', [
            'buku'      => null,
            'kategoris' => Kategori::orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Buku::create($request->validate($this->rulesBuku()));

        return redirect()->route('buku.daftar')->with('status', 'Buku berhasil ditambahkan.');
    }

    public function edit(Buku $buku)
    {
        return view('buku.form', [
            'buku'      => $buku,
            'kategoris' => Kategori::orderBy('nama')->get(),
        ]);
    }

    public function update(Request $request, Buku $buku)
    {
        $buku->update($request->validate($this->rulesBuku()));

        return redirect()->route('buku.daftar')->with('status', 'Buku berhasil diperbarui.');
    }

    // A2 (sudah ditambal): query dengan binding
    public function cari(Request $request)
    {
        $judul = $request->query('judul');

        $hasil = DB::select('SELECT * FROM bukus WHERE judul = ?', [$judul]);

        return response()->json($hasil);
    }

    // A3 (sudah ditambal): lewat route DELETE
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
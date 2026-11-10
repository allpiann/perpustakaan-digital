<?php

namespace App\Http\Controllers;

class BukuController extends Controller
{
    private function dataBuku()
    {
        return [
            [
                'id' => 1,
                'judul' => 'Dilan 1990',
                'penulis' => 'Pidi Baiq',
                'tahun' => 2014,
                'kategori' => 'Novel'
            ],
            [
                'id' => 2,
                'judul' => 'Ayah, Ini Arahnya Ke Mana, Ya?',
                'penulis' => 'Khoirul Trian',
                'tahun' => 2024,
                'kategori' => 'Fantasi'
            ],
            [
                'id' => 3,
                'judul' => 'Seporsi Mie Ayam Sebelum Mati',
                'penulis' => 'Brian Khrisnai',
                'tahun' => 2025,
                'kategori' => 'Fantasi'
            ],
            [
                'id' => 4,
                'judul' => 'Aku Kalah, Aku Merindukanmu',
                'penulis' => 'Coretan Lena',
                'tahun' => 2024,
                'kategori' => 'Fantasi'
            ],
            [
                'id' => 5,
                'judul' => 'Bandung After Rain',
                'penulis' => 'Wulan Nur Amalia',
                'tahun' => 2024,
                'kategori' => 'Novel'
            ],
            [
                'id' => 6,
                'judul' => '0 MDPL',
                'penulis' => 'Nurwina Sari',
                'tahun' => 2025,
                'kategori' => 'Novel'
            ],
        ];
    }

    public function index()
    {
        $buku = $this->dataBuku();

        return view('buku.index', compact('buku'));
    }

    public function show($id)
    {
        $buku = collect($this->dataBuku())->firstWhere('id', $id);

        return view('buku.detail', compact('buku'));
    }
}


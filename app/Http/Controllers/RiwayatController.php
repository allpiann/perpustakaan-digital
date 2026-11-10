<?php

namespace App\Http\Controllers;

use App\Models\Anggota;

class RiwayatController extends Controller
{
    // /riwayat -> riwayat milik akun yang sedang login
    public function index()
    {
        return $this->tampil(auth()->user()->anggota);
    }

    // /riwayat/{anggota} -> hanya boleh jika anggota itu milik user yang login
    public function show(Anggota $anggota)
    {
        abort_unless($anggota->user_id === auth()->id(), 403, 'Anda tidak berhak melihat riwayat ini.');

        return $this->tampil($anggota);
    }

    private function tampil(?Anggota $anggota)
    {
        $riwayat = $anggota
            ? $anggota->peminjamans()->with('buku')->latest('id')->get()
            : collect();

        return view('riwayat.index', compact('anggota', 'riwayat'));
    }
}
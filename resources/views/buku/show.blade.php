@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')
    {{-- Penanganan Kondisi Menggunakan @if jika data tidak ditemukan --}}
    @if (!$buku)
        <div class="alert alert-danger">
            <h2>Data Buku Tidak Ditemukan!</h2>
            <p>Maaf, buku dengan ID yang Anda cari tidak ada dalam sistem kami.</p>
            <a href="{{ route('buku.index') }}" class="btn-back">&laquo; Kembali ke Daftar Buku</a>
        </div>
    @else
        <div class="detail-buku-card">
            <h2>{{ $buku['judul'] }}</h2>
            <hr>
            <p><strong>ID Buku:</strong> {{ $buku['id'] }}</p>
            <p><strong>Penulis:</strong> {{ $buku['penulis'] }}</p>
            <p><strong>Tahun Terbit:</strong> {{ $buku['tahun_terbit'] }}</p>
            <p><strong>Kategori:</strong> <span class="badge">{{ $buku['kategori'] }}</span></p>
            
            <br>
            <a href="{{ route('buku.index') }}" class="btn-back">&laquo; Kembali ke Daftar Buku</a>
        </div>
    @endif
@endsection
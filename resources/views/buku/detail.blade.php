@extends('layouts.app')

@section('title', 'Detail Buku - Perpustakaan')

@section('content')

@if ($buku)

<div class="detail-page">

    <a href="{{ route('buku.index') }}" class="back-link">
        ← Kembali ke daftar buku
    </a>

    <div class="detail-card">

        <div class="detail-cover">
            <img src="{{ asset('images/buku' . $buku['id'] . '.jpg') }}"
                 alt="{{ $buku['judul'] }}">
        </div>

        <div class="detail-info">

            <span class="book-category">
                {{ $buku['kategori'] }}
            </span>

            <h1>{{ $buku['judul'] }}</h1>

            <p class="detail-author">
                {{ $buku['penulis'] }}
            </p>

            <div class="detail-line"></div>

            <div class="detail-meta">

                <div>
                    <span>Tahun Terbit</span>
                    <strong>{{ $buku['tahun'] }}</strong>
                </div>

                <div>
                    <span>Kategori</span>
                    <strong>{{ $buku['kategori'] }}</strong>
                </div>

            </div>

        </div>

    </div>

</div>

@else

<div class="not-found">

    <h1>Buku tidak ditemukan</h1>

    <p>
        Buku yang kamu cari tidak tersedia.
    </p>

    <a href="{{ route('buku.index') }}" class="btn-primary">
        Kembali ke Daftar Buku
    </a>

</div>

@endif

@endsection
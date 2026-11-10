@extends('layouts.app')

@section('title', 'Daftar Buku - Perpustakaan')

@section('content')

<div class="page-heading">
    <span class="eyebrow">KOLEKSI</span>

    <h1>Daftar Buku</h1>

    <p>
        Jelajahi koleksi buku pilihan yang tersedia di perpustakaan.
    </p>
</div>


<div class="book-grid">

    @foreach ($buku as $item)

        <x-kartu-buku :buku="$item">

            <a href="{{ route('buku.show', $item['id']) }}" class="btn-primary">
                Lihat Detail
            </a>

        </x-kartu-buku>

    @endforeach

</div>

@endsection
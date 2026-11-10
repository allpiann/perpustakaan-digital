@props(['buku'])

<div class="book-card">

    <div class="book-cover">
        <img src="{{ asset('images/buku' . $buku['id'] . '.jpg') }}"
             alt="{{ $buku['judul'] }}">
    </div>

    <div class="book-info">

        <span class="book-category">
            {{ $buku['kategori'] }}
        </span>

        <h3>{{ $buku['judul'] }}</h3>

        <p class="author">
            {{ $buku['penulis'] }}
        </p>

        <p class="year">
            {{ $buku['tahun'] }}
        </p>

        <div class="book-action">
            {{ $slot }}
        </div>

    </div>

</div>
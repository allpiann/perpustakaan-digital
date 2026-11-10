<div class="card">
    <h3>{{ $buku['judul'] }}</h3>

    <p>Penulis: {{ $buku['penulis'] }}</p>
    <p>Tahun Terbit: {{ $buku['tahun'] }}</p>

    {{ $slot }}
</div>
<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Detail Peminjaman</h2></x-slot>
    <div class="py-12"><div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-2">
            <p>ID Peminjaman: <b>{{ $peminjaman->id }}</b></p>
            <p>Anggota: <b>{{ $peminjaman->anggota?->nama }}</b> ({{ $peminjaman->anggota?->email }})</p>
            <p>Buku: <b>{{ $peminjaman->buku?->judul }}</b></p>
            <p>Tanggal pinjam: {{ $peminjaman->tanggal_pinjam?->format('d-m-Y') }}</p>
            <p>Tanggal kembali: {{ $peminjaman->tanggal_kembali?->format('d-m-Y') ?? 'Belum kembali' }}</p>
        </div>
    </div></div>
</x-app-layout>
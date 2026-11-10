<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Laporan Perpustakaan</h2></x-slot>
    <div class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="bg-white p-4 rounded shadow"><div class="text-sm text-gray-500">Buku</div><div class="text-2xl font-bold">{{ $totalBuku }}</div></div>
            <div class="bg-white p-4 rounded shadow"><div class="text-sm text-gray-500">Anggota</div><div class="text-2xl font-bold">{{ $totalAnggota }}</div></div>
            <div class="bg-white p-4 rounded shadow"><div class="text-sm text-gray-500">Total Peminjaman</div><div class="text-2xl font-bold">{{ $totalPinjam }}</div></div>
            <div class="bg-white p-4 rounded shadow"><div class="text-sm text-gray-500">Sedang Dipinjam</div><div class="text-2xl font-bold">{{ $sedangDipinjam }}</div></div>
            <div class="bg-white p-4 rounded shadow"><div class="text-sm text-gray-500">Sudah Kembali</div><div class="text-2xl font-bold">{{ $sudahKembali }}</div></div>
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <h3 class="font-semibold mb-3">5 Buku Terpopuler</h3>
            <ol class="list-decimal ml-6">
                @foreach ($terpopuler as $b)<li>{{ $b->judul }} ({{ $b->peminjamans_count }}x dipinjam)</li>@endforeach
            </ol>
        </div>
    </div></div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Dashboard Petugas</h2></x-slot>
    <div class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-white p-4 rounded shadow"><div class="text-sm text-gray-500">Total Buku</div><div class="text-2xl font-bold">{{ $totalBuku }}</div></div>
            <div class="bg-white p-4 rounded shadow"><div class="text-sm text-gray-500">Sedang Dipinjam</div><div class="text-2xl font-bold">{{ $sedangDipinjam }}</div></div>
        </div>
        <div class="bg-white p-6 rounded shadow space-x-4">
            @can('kelola data buku')<a class="text-indigo-600 underline" href="{{ route('kelola.buku') }}">Kelola Buku</a>@endcan
            @can('kelola peminjaman')<a class="text-indigo-600 underline" href="{{ route('peminjaman.index') }}">Peminjaman dan Pengembalian</a>@endcan
            @can('lihat laporan perpustakaan')<a class="text-indigo-600 underline" href="{{ route('laporan.index') }}">Laporan</a>@endcan
        </div>
    </div></div>
</x-app-layout>
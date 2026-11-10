<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Dashboard Siswa</h2></x-slot>
    <div class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-3">
            <p>Halo, <b>{{ auth()->user()->name }}</b> (role: {{ auth()->user()->getRoleNames()->implode(', ') }})</p>
            @can('lihat daftar buku')<p><a class="text-indigo-600 underline" href="{{ route('buku.index') }}">Daftar Buku</a></p>@endcan
            @can('lihat riwayat peminjaman sendiri')<p><a class="text-indigo-600 underline" href="{{ route('riwayat.index') }}">Riwayat Peminjaman Saya</a></p>@endcan
            @can('lihat profil sendiri')<p><a class="text-indigo-600 underline" href="{{ route('profile.edit') }}">Profil Saya</a></p>@endcan
        </div>
    </div></div>
</x-app-layout>
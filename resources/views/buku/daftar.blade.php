<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Daftar Buku</h2></x-slot>
    <div class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (session('status'))<div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>@endif
        <div class="bg-white shadow-sm sm:rounded-lg p-6 overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead><tr class="text-left border-b">
                    <th class="p-2">No</th><th class="p-2">Kategori</th><th class="p-2">Judul</th>
                    <th class="p-2">Penulis</th><th class="p-2">Tahun</th><th class="p-2">Aksi</th>
                </tr></thead>
                <tbody>
                @foreach ($bukus as $b)
                    <tr class="border-b">
                        <td class="p-2">{{ $loop->iteration }}</td>
                        <td class="p-2">{{ $b->kategori?->nama }}</td>
                        {{-- A1: {!! !!} tidak melakukan escaping --}}
                        <td class="p-2">{!! $b->judul !!}</td>
                        <td class="p-2">{{ $b->penulis }}</td>
                        <td class="p-2">{{ $b->tahun_terbit }}</td>
                        <td class="p-2">
                            {{-- A3: penghapusan lewat GET --}}
                            <a class="text-red-600 underline" href="{{ route('buku.hapus', $b->id) }}">Hapus</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div></div>
</x-app-layout>
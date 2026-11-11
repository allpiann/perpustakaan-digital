<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">{{ $buku ? 'Ubah Buku' : 'Tambah Buku' }}</h2>
    </x-slot>
    <div class="py-12"><div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                <ul class="list-disc ml-5">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form method="POST" action="{{ $buku ? route('buku.update', $buku) : route('buku.store') }}"
              class="bg-white p-6 rounded shadow space-y-4">
            @csrf
            @if ($buku) @method('PUT') @endif

            <div>
                <label class="block text-sm font-bold">Kategori</label>
                <select name="kategori_id" class="border rounded w-full">
                    <option value="">-- Pilih kategori --</option>
                    @foreach ($kategoris as $k)
                        <option value="{{ $k->id }}" @selected(old('kategori_id', $buku?->kategori_id) == $k->id)>{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold">Judul</label>
                <input type="text" name="judul" value="{{ old('judul', $buku?->judul) }}" class="border rounded w-full">
            </div>
            <div>
                <label class="block text-sm font-bold">Penulis</label>
                <input type="text" name="penulis" value="{{ old('penulis', $buku?->penulis) }}" class="border rounded w-full">
            </div>
            <div>
                <label class="block text-sm font-bold">Tahun Terbit</label>
                <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $buku?->tahun_terbit) }}" class="border rounded w-full">
            </div>
            <div class="flex gap-3">
                <button class="px-4 py-2 bg-indigo-600 text-white rounded">Simpan</button>
                <a href="{{ route('buku.daftar') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Batal</a>
            </div>
        </form>
    </div></div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Peminjaman dan Pengembalian</h2></x-slot>
    <div class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))<div class="p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>@endif
        @if ($errors->any())<div class="p-3 bg-red-100 text-red-800 rounded">{{ $errors->first() }}</div>@endif

        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <h3 class="font-semibold mb-3">Catat Peminjaman Baru</h3>
            <form method="POST" action="{{ route('peminjaman.store') }}" class="flex flex-wrap gap-3 items-end">
                @csrf
                <select name="anggota_id" class="border rounded" required>
                    <option value="">-- Anggota --</option>
                    @foreach ($anggotas as $a)<option value="{{ $a->id }}">{{ $a->nama }}</option>@endforeach
                </select>
                <select name="buku_id" class="border rounded" required>
                    <option value="">-- Buku --</option>
                    @foreach ($bukus as $b)<option value="{{ $b->id }}">{{ $b->judul }}</option>@endforeach
                </select>
                <button class="px-3 py-2 bg-indigo-600 text-white rounded">Pinjamkan</button>
            </form>
        </div>

        <div class="bg-white shadow-sm sm:rounded-lg p-6 overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead><tr class="text-left border-b"><th class="p-2">Anggota</th><th class="p-2">Buku</th><th class="p-2">Tgl Pinjam</th><th class="p-2">Tgl Kembali</th><th class="p-2">Aksi</th></tr></thead>
                <tbody>
                @foreach ($peminjamans as $p)
                    <tr class="border-b">
                        <td class="p-2">{{ $p->anggota?->nama }}</td>
                        <td class="p-2">{{ $p->buku?->judul }}</td>
                        <td class="p-2">{{ $p->tanggal_pinjam?->format('d-m-Y') }}</td>
                        <td class="p-2">{{ $p->tanggal_kembali?->format('d-m-Y') ?? 'Belum kembali' }}</td>
                        <td class="p-2">
                            @can('kelola pengembalian')
                                @if (! $p->tanggal_kembali)
                                <form method="POST" action="{{ route('peminjaman.kembali', $p) }}">
                                    @csrf @method('PATCH')
                                    <button class="px-2 py-1 bg-green-600 text-white rounded">Kembalikan</button>
                                </form>
                                @endif
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-4">{{ $peminjamans->links() }}</div>
        </div>
    </div></div>
</x-app-layout>
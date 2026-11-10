<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Riwayat Peminjaman Saya</h2></x-slot>
    <div class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6 overflow-x-auto">
            @if (! $anggota)
                <p>Akun ini belum terhubung dengan data anggota.</p>
            @else
                <p class="mb-3">Anggota: <b>{{ $anggota->nama }}</b></p>
                <table class="min-w-full text-sm">
                    <thead><tr class="text-left border-b"><th class="p-2">Buku</th><th class="p-2">Tgl Pinjam</th><th class="p-2">Tgl Kembali</th></tr></thead>
                    <tbody>
                    @forelse ($riwayat as $r)
                        <tr class="border-b">
                            <td class="p-2">{{ $r->buku?->judul }}</td>
                            <td class="p-2">{{ $r->tanggal_pinjam?->format('d-m-Y') }}</td>
                            <td class="p-2">{{ $r->tanggal_kembali?->format('d-m-Y') ?? 'Belum kembali' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="p-2">Belum ada riwayat peminjaman.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            @endif
        </div>
    </div></div>
</x-app-layout>
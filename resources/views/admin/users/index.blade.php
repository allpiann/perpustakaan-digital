<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Kelola Pengguna dan Role</h2></x-slot>
    <div class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (session('status'))<div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>@endif
        @if ($errors->any())<div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ $errors->first() }}</div>@endif
        <div class="bg-white shadow-sm sm:rounded-lg p-6 overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead><tr class="text-left border-b"><th class="p-2">Nama</th><th class="p-2">Email</th><th class="p-2">Role</th><th class="p-2">Aksi</th></tr></thead>
                <tbody>
                @foreach ($users as $u)
                    <tr class="border-b">
                        <td class="p-2">{{ $u->name }}</td>
                        <td class="p-2">{{ $u->email }}</td>
                        <td class="p-2">{{ $u->getRoleNames()->implode(', ') }}</td>
                        <td class="p-2">
                            @can('kelola role pengguna')
                            <form method="POST" action="{{ route('admin.users.role', $u) }}" class="inline">
                                @csrf @method('PATCH')
                                <select name="role" class="border rounded text-sm">
                                    @foreach ($roles as $r)<option value="{{ $r }}" @selected($u->hasRole($r))>{{ $r }}</option>@endforeach
                                </select>
                                <button class="px-2 py-1 bg-indigo-600 text-white rounded">Ubah Role</button>
                            </form>
                            @endcan
                            @can('kelola data pengguna')
                            <form method="POST" action="{{ route('admin.users.destroy', $u) }}" class="inline" onsubmit="return confirm('Hapus pengguna ini?')">
                                @csrf @method('DELETE')
                                <button class="px-2 py-1 bg-red-600 text-white rounded">Hapus</button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-4">{{ $users->links() }}</div>
        </div>
    </div></div>
</x-app-layout>
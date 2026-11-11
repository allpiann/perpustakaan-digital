<?php

namespace App\Policies;

use App\Models\Peminjaman;
use App\Models\User;

class PeminjamanPolicy
{
    public function view(User $user, Peminjaman $peminjaman): bool
    {
        // admin dan petugas boleh melihat semua peminjaman
        if ($user->hasAnyRole(['admin', 'petugas'])) {
            return true;
        }

        // siswa hanya boleh melihat peminjaman miliknya sendiri
        // (dicek lewat identitas: anggota -> user_id)
        return $peminjaman->anggota?->user_id === $user->id;
    }
}
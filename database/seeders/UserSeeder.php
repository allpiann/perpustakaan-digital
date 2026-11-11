<?php

namespace Database\Seeders;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Password admin dibaca dari .env, bukan lagi 'password'
        $passwordAdmin = env('ADMIN_PASSWORD') ?: Str::random(32);

        $this->buatUser('Admin Perpustakaan', 'admin@perpus.test', 'admin', $passwordAdmin);
        $this->buatUser('Petugas Perpustakaan', 'petugas@perpus.test', 'petugas');

        $siswa1 = $this->buatUser('Siswa Satu', 'siswa@perpus.test', 'siswa');
        $siswa2 = $this->buatUser('Siswa Dua', 'siswa2@perpus.test', 'siswa');

        foreach ([$siswa1, $siswa2] as $i => $u) {
            $anggota = Anggota::updateOrCreate(
                ['user_id' => $u->id],
                ['nama' => $u->name, 'email' => $u->email, 'no_telepon' => '08123456789' . $i]
            );

            $buku = Buku::skip($i)->first();
            if ($buku) {
                Peminjaman::firstOrCreate(
                    ['anggota_id' => $anggota->id, 'buku_id' => $buku->id],
                    ['tanggal_pinjam' => now()->subDays(3)->toDateString(), 'tanggal_kembali' => null]
                );
            }
        }
    }

    private function buatUser(string $nama, string $email, string $role, string $password = 'password'): User
    {
        // updateOrCreate: akun yang sudah ada ikut diperbarui passwordnya
        $user = User::updateOrCreate(
            ['email' => $email],
            ['name' => $nama, 'password' => Hash::make($password), 'email_verified_at' => now()]
        );
        $user->syncRoles($role);

        return $user;
    }
}
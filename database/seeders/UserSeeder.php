<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // ── Admin ──────────────────────────────────────────────
        User::create([
            'name'     => 'Admin Utama',
            'username' => 'admin',
            'email'    => 'admin@example.com',
            'password' => bcrypt('password'),
            'role'     => 'admin',
            'telepon'  => '081234567890',
        ]);

        // ── Guru BK ────────────────────────────────────────────
        User::create([
            'name'     => 'Eni Kustiyorini, S.Psi',
            'username' => 'eni.bk',
            'email'    => 'eni@example.com',
            'password' => bcrypt('password'),
            'role'     => 'bk',
            'telepon'  => '089876543210',
        ]);

        User::create([
            'name'     => 'Devina Rayining Tias, S.Psi',
            'username' => 'devina.bk',
            'email'    => 'devina@example.com',
            'password' => bcrypt('password'),
            'role'     => 'bk',
            'telepon'  => '082233445566',
        ]);

        // ── Siswa ─────────────────────────────────────────────
        User::create([
            'name'     => 'Nanda Indi Lestari',
            'username' => 'nanda',
            'email'    => 'nanda@example.com',
            'password' => bcrypt('password'),
            'role'     => 'siswa',
            'nis'      => '123456',
            'kelas'    => 'XII Inovatif',
        ]);

        User::create([
            'name'     => 'Siswa Lain',
            'username' => 'siswa',
            'email'    => 'siswa@example.com',
            'password' => bcrypt('password'),
            'role'     => 'siswa',
            'nis'      => '654321',
            'kelas'    => 'XI Kreatif',
        ]);
    }
}

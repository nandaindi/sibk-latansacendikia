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
        // ── Create Roles ─────────────────────────────────────────
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'bk']);
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'siswa']);

        // ── Admin ──────────────────────────────────────────────
        $admin = User::create([
            'name'     => 'Admin Latansa',
            'username' => 'adminlatansa',
            'email'    => 'admin@latansa.com',
            'password' => bcrypt('password'),
            'telepon'  => '081234567890',
        ]);
        $admin->assignRole('admin');

        // ── Guru BK ────────────────────────────────────────────
        $bk1 = User::create([
            'name'     => 'Eni Kustiyorini, S.Psi',
            'username' => 'enilatansa',
            'email'    => 'eni@latansa.com',
            'password' => bcrypt('password'),
            'telepon'  => '089876543210',
        ]);
        $bk1->assignRole('bk');

        $bk2 = User::create([
            'name'     => 'Devina Rayining Tias, S.Psi',
            'username' => 'devinalatansa',
            'email'    => 'devina@latansa.com',
            'password' => bcrypt('password'),
            'telepon'  => '082233445566',
        ]);
        $bk2->assignRole('bk');

        // ── Siswa ─────────────────────────────────────────────
        $siswa1 = User::create([
            'name'     => 'Nanda Indi Lestari',
            'username' => 'nanda',
            'email'    => 'nanda@latansa.com',
            'password' => bcrypt('password'),
            'nis'      => '123456',
            'kelas'    => 'XII Inovatif',
        ]);
        $siswa1->assignRole('siswa');

        $siswa2 = User::create([
            'name'     => 'Siswa Lain',
            'username' => 'siswa',
            'email'    => 'siswa@latansa.com',
            'password' => bcrypt('password'),
            'nis'      => '654321',
            'kelas'    => 'XI Kreatif',
        ]);
        $siswa2->assignRole('siswa');
    }
}

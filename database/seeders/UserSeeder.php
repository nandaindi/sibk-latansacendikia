<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {

        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'bk']);
        Role::firstOrCreate(['name' => 'siswa']);

        $admin = User::updateOrCreate(
            ['username' => 'adminlatansa'],
            [
                'name' => 'Admin Latansa',
                'email' => 'admin@latansa.com',
                'password' => bcrypt('password'),
                'telepon' => '081234567890',
            ]
        );
        $admin->syncRoles(['admin']);

        $bk1 = User::updateOrCreate(
            ['username' => 'enilatansa'],
            [
                'name' => 'Eni Kustiyorini, S.Psi',
                'email' => 'eni@latansa.com',
                'password' => bcrypt('password'),
                'telepon' => '089876543210',
            ]
        );
        $bk1->syncRoles(['bk']);

        $bk2 = User::updateOrCreate(
            ['username' => 'devinalatansa'],
            [
                'name' => 'Devina Rayining Tias, S.Psi',
                'email' => 'devina@latansa.com',
                'password' => bcrypt('password'),
                'telepon' => '082233445566',
            ]
        );
        $bk2->syncRoles(['bk']);

        $siswa1 = User::updateOrCreate(
            ['username' => 'nanda'],
            [
                'name' => 'Nanda Indi Lestari',
                'email' => 'nanda@latansa.com',
                'password' => bcrypt('password'),
                'nis' => '123456',
                'kelas' => 'XII',
                'jurusan' => 'IPA 1',
            ]
        );
        $siswa1->syncRoles(['siswa']);

        $siswa2 = User::updateOrCreate(
            ['username' => 'siswa'],
            [
                'name' => 'Siswa Lain',
                'email' => 'siswa@latansa.com',
                'password' => bcrypt('password'),
                'nis' => '654321',
                'kelas' => 'XI',
                'jurusan' => 'IPS 1',
            ]
        );
        $siswa2->syncRoles(['siswa']);
    }
}

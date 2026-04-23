<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Pastikan role sudah ada
        $roles = ['admin', 'bk', 'siswa'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Ambil semua user yang memiliki role
        $users = User::all();
        foreach ($users as $user) {
            if ($user->role) {
                $user->assignRole($user->role);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse tidak diperlukan jika tujuannya menghapus role spatie
        // Tapi kita bisa membiarkannya kosong atau menghapus role mapping
    }
};

<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Konseling;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KonselingSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $nanda = User::where('username', 'nanda')->first();

        if (!$nanda) return;

        Konseling::create([
            'user_id'  => $nanda->id,
            'jenis'    => 'online',
            'tanggal'  => '2025-07-02',
            'waktu'    => '10:00',
            'link_meet'=> 'https://meet.google.com/abc-defg-hij',
            'status'   => 'disetujui',
        ]);

        Konseling::create([
            'user_id'  => $nanda->id,
            'jenis'    => 'offline',
            'tanggal'  => '2025-07-05',
            'waktu'    => '13:00',
            'status'   => 'pending',
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Laporan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LaporanSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $eni = User::where('username', 'eni.bk')->first();

        if (!$eni) return;

        Laporan::create([
            'nama_laporan' => 'Laporan Konseling Semester Ganjil',
            'author_id'    => $eni->id,
            'tanggal'      => '2025-07-02',
            'search_key'   => 'Rabu, 2 Juli 2025',
        ]);

        Laporan::create([
            'nama_laporan' => 'Rekap Kunjungan BK Juli 2025',
            'author_id'    => $eni->id,
            'tanggal'      => '2025-07-15',
            'search_key'   => 'Selasa, 15 Juli 2025',
        ]);
    }
}

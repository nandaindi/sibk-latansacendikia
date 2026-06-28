<?php

namespace App\Console\Commands;

use App\Models\Konseling;
use App\Models\Pelanggaran;
use Carbon\Carbon;
use Illuminate\Console\Command;

class TandaiJadwalKadaluarsa extends Command
{
    protected $signature   = 'jadwal:tandai-kadaluarsa';
    protected $description = 'Tandai sesi konseling dan panggilan yang jadwalnya sudah lewat sebagai tidak_hadir.';

    public function handle(): void
    {
        // Konseling disetujui yang sudah lewat 2 jam → tidak_hadir
        Konseling::where('status', 'disetujui')->get()->each(function ($sesi) {
            $jadwal = Carbon::parse($sesi->tanggal.' '.($sesi->waktu ?? '23:59'))->addHours(2);
            if (now()->greaterThan($jadwal)) {
                $sesi->update(['status' => 'tidak_hadir']);
            }
        });

        // Panggilan (Pelanggaran) menunggu yang sudah melewati hari-nya → tidak_hadir
        Pelanggaran::where('status', 'menunggu')->get()->each(function ($panggilan) {
            $jadwal = Carbon::parse($panggilan->tanggal.' '.($panggilan->waktu ?? '23:59'))->addDay();
            if (now()->greaterThan($jadwal)) {
                $panggilan->update(['status' => 'tidak_hadir']);
            }
        });

        $this->info('Selesai: jadwal kadaluarsa sudah ditandai.');
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Konseling;
use Carbon\Carbon;
use Illuminate\Console\Command;

class KonselingExpire extends Command
{
    /**
     * Signature: php artisan konseling:expire
     * Bisa dijadwalkan setiap jam via cron / Laravel Scheduler.
     */
    protected $signature = 'konseling:expire';

    protected $description = 'Tandai sesi konseling yang sudah melewati jadwalnya sebagai tidak_hadir';

    public function handle(): void
    {
        $now = Carbon::now();

        $sessions = Konseling::where('status', 'disetujui')->get();

        $count = 0;
        foreach ($sessions as $sesi) {

            $waktu = $sesi->waktu ?? '23:59';
            $jadwal = Carbon::parse($sesi->tanggal.' '.$waktu);

            if ($now->greaterThan($jadwal->addHours(2))) {
                $sesi->update(['status' => 'tidak_hadir']);
                $count++;
                $this->line("  ID {$sesi->id} → tidak_hadir (jadwal: {$jadwal})");
            }
        }

        $this->info("Selesai: {$count} sesi ditandai tidak_hadir.");
    }
}

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
    protected $signature   = 'konseling:expire';
    protected $description = 'Tandai sesi konseling yang sudah melewati jadwalnya sebagai tidak_hadir';

    public function handle(): void
    {
        $now = Carbon::now();

        // Ambil semua sesi yang disetujui tapi belum selesai
        $sessions = Konseling::where('status', 'disetujui')->get();

        $count = 0;
        foreach ($sessions as $sesi) {
            // Gabungkan tanggal + waktu menjadi satu Carbon object
            $waktu = $sesi->waktu ?? '23:59'; // kalau tidak ada waktu, pakai akhir hari
            $jadwal = Carbon::parse($sesi->tanggal . ' ' . $waktu);

            // Beri toleransi 2 jam setelah jadwal sebelum dianggap tidak hadir
            if ($now->greaterThan($jadwal->addHours(2))) {
                $sesi->update(['status' => 'tidak_hadir']);
                $count++;
                $this->line("  ID {$sesi->id} → tidak_hadir (jadwal: {$jadwal})");
            }
        }

        $this->info("Selesai: {$count} sesi ditandai tidak_hadir.");
    }
}

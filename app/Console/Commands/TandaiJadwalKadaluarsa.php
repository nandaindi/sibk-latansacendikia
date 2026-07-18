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
        $now = Carbon::now();

        // ponytail: bulk whereRaw beats ->get()->each() — no PHP loop, single query
        $konseling = Konseling::where('status', 'disetujui')
            ->whereRaw("TIMESTAMP(tanggal, IFNULL(waktu, '23:59')) < ?", [$now->subHours(2)])
            ->update(['status' => 'tidak_hadir']);

        $panggilan = Pelanggaran::whereIn('status', ['menunggu', 'diterima'])
            ->whereRaw("TIMESTAMP(tanggal, IFNULL(waktu, '23:59')) < ?", [$now->subDay()])
            ->update(['status' => 'tidak_hadir']);

        $this->info("Selesai: {$konseling} konseling, {$panggilan} panggilan ditandai tidak_hadir.");
    }
}

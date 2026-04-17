<?php

namespace App\Console\Commands;

use App\Models\Konseling;
use App\Notifications\SessionReminderNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendSessionReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengecek dan mengirimkan notifikasi 10 menit sebelum sesi konseling dimulai';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // TARGET: Waktu saat ini ditambah 10 Menit (Gunakan objek datetime lengkap)
        $targetDateTime = Carbon::now()->addMinutes(10);
        
        $targetDate = $targetDateTime->toDateString(); // Tanggal target (bisa hari ini / besok)
        $targetTime = $targetDateTime->format('H:i');   // Jam target

        // Cari sesi dengan TANGGAL dan JAM yang sesuai dengan target 10 menit ke depan
        $konselings = Konseling::where('status', 'disetujui')
            ->where('is_reminded', false)
            ->whereDate('tanggal', $targetDate)
            ->where('waktu', 'like', $targetTime . '%')
            ->get();

        foreach ($konselings as $konseling) {
            // Notif ke Anak
            if ($konseling->user) {
                $konseling->user->notify(new SessionReminderNotification($konseling));
            }
            
            // Notif ke BK
            if ($konseling->bk) {
                $konseling->bk->notify(new SessionReminderNotification($konseling));
            }

            // Tandai sudah pernah diingatkan
            $konseling->is_reminded = true;
            $konseling->save();

            $this->info("Reminder sent for session ID {$konseling->id}");
        }

        return Command::SUCCESS;
    }
}

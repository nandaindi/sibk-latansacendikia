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

        $targetDateTime = Carbon::now()->addMinutes(10);

        $targetDate = $targetDateTime->toDateString();
        $targetTime = $targetDateTime->format('H:i');

        $konselings = Konseling::where('status', 'disetujui')
            ->where('is_reminded', false)
            ->whereDate('tanggal', $targetDate)
            ->where('waktu', 'like', $targetTime.'%')
            ->get();

        foreach ($konselings as $konseling) {

            if ($konseling->user) {
                $konseling->user->notify(new SessionReminderNotification($konseling));
            }

            if ($konseling->bk) {
                $konseling->bk->notify(new SessionReminderNotification($konseling));
            }

            $konseling->is_reminded = true;
            $konseling->save();

            $this->info("Reminder sent for session ID {$konseling->id}");
        }

        return Command::SUCCESS;
    }
}

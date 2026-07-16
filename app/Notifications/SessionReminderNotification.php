<?php

namespace App\Notifications;

use App\Models\Konseling;
use Carbon\Carbon;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Messages\BroadcastMessage;

class SessionReminderNotification extends Notification implements ShouldBroadcastNow
{
    public $konseling;

    /**
     * Create a new notification instance.
     */
    public function __construct(Konseling $konseling)
    {
        $this->konseling = $konseling;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $waktu = Carbon::parse($this->konseling->waktu)->format('H:i');

        return [
            'konseling_id' => $this->konseling->id,
            'title' => 'Sesi Konseling 10 Menit Lagi!',
            'message' => 'Sesi bimbingan ('.ucfirst($this->konseling->jenis).') akan segera dimulai pada pukul '.$waktu.'.',
            'link' => '#',
            'event_type' => 'konseling_reminder',
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return (new BroadcastMessage($this->toArray($notifiable)))->onConnection('sync');
    }
}

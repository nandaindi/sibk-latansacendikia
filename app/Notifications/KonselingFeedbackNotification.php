<?php

namespace App\Notifications;

use App\Models\Konseling;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class KonselingFeedbackNotification extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    public $konseling;

    public function __construct(Konseling $konseling)
    {
        $this->konseling = $konseling;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'konseling_id' => $this->konseling->id,
            'title' => 'Siswa Mengisi Feedback',
            'message' => 'Siswa ' . ($this->konseling->user->name ?? 'Siswa') . ' telah mengisi kesimpulan dan saran konseling.',
            'link' => route('bk.detail-laporan', ['id' => $this->konseling->id]),
            'event_type' => 'konseling_status',
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return (new BroadcastMessage($this->toArray($notifiable)))->onConnection('sync');
    }
}

<?php

namespace App\Notifications;

use App\Models\Konseling;
use Carbon\Carbon;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Messages\BroadcastMessage;

class KonselingPengajuanBaruNotification extends Notification implements ShouldBroadcastNow
{
    public function __construct(public Konseling $konseling) {}

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'konseling_id' => $this->konseling->id,
            'title' => 'Pengajuan Konseling Baru',
            'message' => $this->konseling->user->name.' mengajukan konseling '.ucfirst($this->konseling->jenis).'.',
            'link' => route('bk.validasi-pengajuan', ['id' => $this->konseling->id]),
            'event_type' => 'konseling_pengajuan_baru',
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return (new BroadcastMessage($this->toArray($notifiable)))->onConnection('sync');
    }
}

<?php

namespace App\Notifications;

use App\Models\Pelanggaran;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class PanggilanDiterimaNotification extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    public $pelanggaran;

    public function __construct(Pelanggaran $pelanggaran)
    {
        $this->pelanggaran = $pelanggaran;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'pelanggaran_id' => $this->pelanggaran->id,
            'title' => 'Panggilan Dikonfirmasi',
            'message' => 'Siswa ' . ($this->pelanggaran->user->name ?? 'Siswa') . ' telah mengonfirmasi kehadiran untuk panggilan BK.',
            'link' => route('bk.panggil-siswa.detail', $this->pelanggaran->id),
            'event_type' => 'pelanggaran_status',
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return (new BroadcastMessage($this->toArray($notifiable)))->onConnection('sync');
    }
}

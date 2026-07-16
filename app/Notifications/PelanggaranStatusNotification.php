<?php

namespace App\Notifications;

use App\Models\Pelanggaran;
use Carbon\Carbon;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Messages\BroadcastMessage;

class PelanggaranStatusNotification extends Notification implements ShouldBroadcastNow
{
    public function __construct(
        public Pelanggaran $pelanggaran,
        public string $eventType = 'pelanggaran_baru'
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        $tanggal = Carbon::parse($this->pelanggaran->tanggal)->format('d/m/Y');
        $waktu = Carbon::parse($this->pelanggaran->waktu)->format('H:i');

        if ($this->eventType === 'pelanggaran_status') {
            return [
                'pelanggaran_id' => $this->pelanggaran->id,
                'title' => 'Status Panggilan Diperbarui',
                'message' => 'Panggilan BK untuk topik '.$this->pelanggaran->topik.' sudah berubah menjadi '.$this->pelanggaran->status.'.',
                'link' => route('siswa.detail-panggilan', $this->pelanggaran->id),
                'event_type' => 'pelanggaran_status',
            ];
        }

        return [
            'pelanggaran_id' => $this->pelanggaran->id,
            'title' => 'Panggilan BK',
            'message' => 'Anda mendapat panggilan BK untuk topik '.$this->pelanggaran->topik.' pada '.$tanggal.' jam '.$waktu.'.',
            'link' => route('siswa.detail-panggilan', $this->pelanggaran->id),
            'event_type' => 'pelanggaran_baru',
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return (new BroadcastMessage($this->toArray($notifiable)))->onConnection('sync');
    }
}

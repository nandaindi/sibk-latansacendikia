<?php

namespace App\Notifications;

use App\Models\Konseling;
use Carbon\Carbon;
use Illuminate\Notifications\Notification;

class KonselingStatusNotification extends Notification
{
    public $konseling;

    public $statusType;

    /**
     * Create a new notification instance.
     */
    public function __construct(Konseling $konseling, string $statusType)
    {
        $this->konseling = $konseling;
        $this->statusType = $statusType;
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
        if ($this->statusType === 'disetujui') {
            $waktu = Carbon::parse($this->konseling->waktu)->format('H:i');
            $link = $this->konseling->jenis === 'online'
                ? route('siswa.mulai-konseling')
                : route('siswa.konseling-offline');

            return [
                'konseling_id' => $this->konseling->id,
                'title' => 'Pengajuan Disetujui!',
                'message' => 'Pengajuan Anda disetujui untuk '.Carbon::parse($this->konseling->tanggal)->format('d/m/Y').' jam '.$waktu,
                'link' => $link,
                'event_type' => 'konseling_status',
            ];
        } elseif ($this->statusType === 'ditolak') {
            return [
                'konseling_id' => $this->konseling->id,
                'title' => 'Pengajuan Ditolak',
                'message' => 'Jadwal yang diajukan tidak dapat dipenuhi dengan alasan: '.$this->konseling->alasan_tolak,
                'link' => route('siswa.pengajuan-ditolak'),
                'event_type' => 'konseling_status',
            ];
        }

        return [
            'konseling_id' => $this->konseling->id,
            'title' => 'Sesi Konseling Selesai',
            'message' => 'Laporan konseling untuk sesi tanggal '.Carbon::parse($this->konseling->tanggal)->format('d/m/Y').' sudah tersedia.',
            'link' => route('siswa.detail-laporan', $this->konseling->id),
            'event_type' => 'konseling_status',
        ];
    }
}

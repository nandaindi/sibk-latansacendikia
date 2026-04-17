<?php

namespace App\Notifications;

use App\Models\Konseling;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class KonselingStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $konseling;
    public $statusType;

    /**
     * Create a new notification instance.
     */
    public function __construct(Konseling $konseling, string $statusType)
    {
        $this->konseling = $konseling;
        $this->statusType = $statusType; // 'disetujui' atau 'ditolak'
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)->greeting('Halo ' . $notifiable->name . ',');

        if ($this->statusType === 'disetujui') {
            $waktu = Carbon::parse($this->konseling->waktu)->format('H:i');
            $tanggal = Carbon::parse($this->konseling->tanggal)->format('d F Y');

            $message->subject('Hore! Pengajuan Konseling Anda Disetujui')
                    ->line('Guru BK telah menyetujui pengajuan sesi konseling Anda.')
                    ->line('Tanggal: ' . $tanggal)
                    ->line('Waktu: ' . $waktu)
                    ->line('Jenis: ' . ucfirst($this->konseling->jenis));

            if ($this->konseling->jenis === 'online' && $this->konseling->link_meet) {
                $message->line('Link Pertemuan: ' . $this->konseling->link_meet);
            }
        } elseif ($this->statusType === 'ditolak') {
            $message->subject('Maaf, Pengajuan Konseling Anda Ditolak')
                    ->line('Guru BK tidak dapat menyetujui jadwal konseling yang Anda ajukan pada saat ini.')
                    ->line('Alasan penolakan: ' . $this->konseling->alasan_tolak)
                    ->line('Jangan patah semangat, Anda dapat mencoba menjadwalkan ulang di hari lain.');
        }

        return $message->line('Terima kasih telah menggunakan layanan Bimbingan Konseling!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        if ($this->statusType === 'disetujui') {
            $waktu = \Carbon\Carbon::parse($this->konseling->waktu)->format('H:i');
            return [
                'konseling_id' => $this->konseling->id,
                'title' => 'Pengajuan Disetujui!',
                'message' => 'Pengajuan Anda disetujui untuk ' . \Carbon\Carbon::parse($this->konseling->tanggal)->format('d/m/Y') . ' jam ' . $waktu,
                'link' => '#'
            ];
        } else {
            return [
                'konseling_id' => $this->konseling->id,
                'title' => 'Pengajuan Ditolak',
                'message' => 'Jadwal yang diajukan tidak dapat dipenuhi dengan alasan: ' . $this->konseling->alasan_tolak,
                'link' => '#'
            ];
        }
    }
}

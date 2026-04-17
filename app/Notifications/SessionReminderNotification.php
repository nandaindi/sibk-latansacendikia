<?php

namespace App\Notifications;

use App\Models\Konseling;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SessionReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

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
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $waktu = \Carbon\Carbon::parse($this->konseling->waktu)->format('H:i');
        
        $message = (new MailMessage)
            ->subject('PENGINGAT: Sesi Bimbingan Konseling Dimulai 10 Menit Lagi')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Ini adalah pengingat otomatis bahwa sesi Bimbingan Konseling Anda akan dimulai dalam 10 menit.')
            ->line('Jadwal: ' . \Carbon\Carbon::parse($this->konseling->tanggal)->format('d F Y') . ' jam ' . $waktu)
            ->line('Jenis: ' . ucfirst($this->konseling->jenis));
            
        if ($this->konseling->jenis === 'online' && $this->konseling->link_meet) {
            $message->action('Bergabung ke Pertemuan (Meet)', $this->konseling->link_meet);
        } else {
            $message->line('Silakan menuju ke Ruang Bimbingan Konseling (Offline).');
        }

        return $message->line('Terima kasih!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $waktu = \Carbon\Carbon::parse($this->konseling->waktu)->format('H:i');
        return [
            'konseling_id' => $this->konseling->id,
            'title' => 'Sesi Konseling 10 Menit Lagi!',
            'message' => 'Sesi bimbingan (' . ucfirst($this->konseling->jenis) . ') akan segera dimulai pada pukul ' . $waktu . '.',
            'link' => '#' 
        ];
    }
}

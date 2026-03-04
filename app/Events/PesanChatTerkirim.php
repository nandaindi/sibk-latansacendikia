<?php

namespace App\Events;

use App\Models\PesanChat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PesanChatTerkirim implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public PesanChat $pesan)
    {
        //
    }

    /**
     * Broadcast ke private channel berdasarkan ID konseling.
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.' . $this->pesan->konseling_id),
        ];
    }

    /**
     * Data yang dikirim ke frontend via WebSocket.
     */
    public function broadcastWith(): array
    {
        return [
            'id'         => $this->pesan->id,
            'user_id'    => $this->pesan->user_id,
            'user_name'  => $this->pesan->user->name,
            'user_role'  => $this->pesan->user->role,
            'pesan'      => $this->pesan->pesan,
            'created_at' => $this->pesan->created_at->toISOString(),
        ];
    }
}

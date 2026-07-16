<?php

namespace App\Events;

use App\Models\Konseling;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SesiKonselingSelesai implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Konseling $konseling)
    {
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.' . $this->konseling->id),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->konseling->id,
            'status' => 'selesai',
        ];
    }

    public function broadcastAs(): string
    {
        return 'SesiKonselingSelesai';
    }
}

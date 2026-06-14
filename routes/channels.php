<?php

use App\Models\Konseling;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{konselingId}', function ($user, $konselingId) {
    $konseling = Konseling::find($konselingId);
    if (! $konseling) {
        return false;
    }

    if ($user->role === 'bk' && (int) $konseling->bk_id === (int) $user->id) {
        return ['id' => $user->id, 'name' => $user->name, 'role' => $user->role];
    }

    if ($user->role === 'siswa' && (int) $konseling->user_id === (int) $user->id) {
        return ['id' => $user->id, 'name' => $user->name, 'role' => $user->role];
    }

    return false;
});

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

<?php

use App\Models\Konseling;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Private channel chat.{konselingId}: hanya siswa yang bersangkutan atau
| pengguna dengan role 'bk' yang bisa join.
|
*/

Broadcast::channel('chat.{konselingId}', function ($user, $konselingId) {
    $konseling = Konseling::find($konselingId);
    if (!$konseling) return false;

    // BK hanya bisa join sesi miliknya
    if ($user->role === 'bk' && (int)$konseling->bk_id === (int)$user->id) {
        return ['id' => $user->id, 'name' => $user->name, 'role' => $user->role];
    }

    // Siswa hanya bisa join sesi miliknya
    if ($user->role === 'siswa' && (int)$konseling->user_id === (int)$user->id) {
        return ['id' => $user->id, 'name' => $user->name, 'role' => $user->role];
    }

    return false;
});

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

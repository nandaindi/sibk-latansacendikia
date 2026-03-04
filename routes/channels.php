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
    if ($user->role === 'bk' && $konseling->bk_id === $user->id) {
        return ['id' => $user->id, 'name' => $user->name, 'role' => $user->role];
    }

    // Siswa hanya bisa join sesi miliknya
    if ($user->role === 'siswa' && $konseling->user_id === $user->id) {
        return ['id' => $user->id, 'name' => $user->name, 'role' => $user->role];
    }

    return false;
});

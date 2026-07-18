<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $konseling_id
 * @property int $user_id
 * @property string $pesan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Konseling $konseling
 * @property-read \App\Models\User $user
 */
class PesanChat extends Model
{
    protected $fillable = [
        'konseling_id',
        'user_id',
        'pesan',
    ];

    public function konseling()
    {
        return $this->belongsTo(Konseling::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

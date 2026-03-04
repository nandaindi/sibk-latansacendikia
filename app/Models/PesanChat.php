<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nama_laporan
 * @property int $author_id
 * @property int|null $user_id
 * @property int|null $konseling_id
 * @property string $tanggal
 * @property string|null $search_key
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $author
 * @property-read \App\Models\User|null $user
 * @property-read \App\Models\Konseling|null $konseling
 */
class Laporan extends Model
{
    protected $fillable = [
        'nama_laporan',
        'author_id',
        'user_id',
        'konseling_id',
        'tanggal',
        'search_key',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function konseling()
    {
        return $this->belongsTo(Konseling::class, 'konseling_id');
    }
}

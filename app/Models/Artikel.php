<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $judul
 * @property string $slug
 * @property string $konten
 * @property string|null $gambar
 * @property int $penulis_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $penulis
 */
class Artikel extends Model
{
    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'gambar',
        'penulis_id',
    ];

    public function penulis()
    {
        return $this->belongsTo(User::class, 'penulis_id');
    }
}

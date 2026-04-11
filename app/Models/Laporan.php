<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

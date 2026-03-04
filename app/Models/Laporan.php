<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $fillable = [
        'nama_laporan',
        'author_id',
        'tanggal',
        'search_key',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bk_id',
        'topik',
        'tanggal',
        'waktu',
        'status',
        'catatan_pemanggilan',
        'catatan_hasil',
        'catatan_tindak_lanjut',
        'is_read',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bk()
    {
        return $this->belongsTo(User::class, 'bk_id');
    }
}

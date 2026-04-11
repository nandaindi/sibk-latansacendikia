<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konseling extends Model
{
    protected $fillable = [
        'user_id',
        'bk_id',
        'jenis',
        'problem_type',
        'tanggal',
        'waktu',
        'durasi',
        'started_at',
        'link_meet',
        'status',
        'alasan_tolak',
        'catatan_bk',
        'rtl',
        'kesimpulan_siswa',
        'saran_siswa',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'started_at' => 'datetime',
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

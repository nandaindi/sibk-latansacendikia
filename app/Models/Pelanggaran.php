<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int|null $bk_id
 * @property string $topik
 * @property string $tanggal
 * @property string|null $waktu
 * @property string $status
 * @property string|null $catatan_pemanggilan
 * @property string|null $catatan_hasil
 * @property string|null $catatan_tindak_lanjut
 * @property bool $is_read
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $entry_type   Set dynamically in BK dashboard
 * @property string|null $alert_type   Set dynamically in Siswa dashboard
 * @property-read \App\Models\User|null $user
 * @property-read \App\Models\User|null $bk
 */
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

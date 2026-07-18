<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $user_id
 * @property int|null $bk_id
 * @property string $jenis
 * @property string|null $problem_type
 * @property string|null $catatan_siswa
 * @property string $tanggal
 * @property string|null $waktu
 * @property int|null $durasi
 * @property \Illuminate\Support\Carbon|null $started_at
 * @property string|null $link_meet
 * @property string|null $status
 * @property string|null $alasan_tolak
 * @property string|null $catatan_bk
 * @property string|null $rtl
 * @property string|null $kesimpulan_siswa
 * @property string|null $saran_siswa
 * @property string|null $kepuasan_penerimaan
 * @property string|null $kepuasan_kemudahan
 * @property string|null $kepuasan_kepercayaan
 * @property string|null $kepuasan_pelayanan
 * @property bool $is_read
 * @property bool $is_reminded
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $entry_type   Set dynamically in BK dashboard
 * @property string|null $alert_type   Set dynamically in Siswa dashboard
 * @property-read \App\Models\User|null $user
 * @property-read \App\Models\User|null $bk
 * @property-read \App\Models\Laporan|null $laporan
 */
class Konseling extends Model
{
    protected $fillable = [
        'user_id',
        'bk_id',
        'jenis',
        'problem_type',
        'catatan_siswa',
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
        'kepuasan_penerimaan',
        'kepuasan_kemudahan',
        'kepuasan_kepercayaan',
        'kepuasan_pelayanan',
        'is_read',
        'is_reminded',
    ];

    protected $casts = [
        'is_read'     => 'boolean',
        'is_reminded' => 'boolean',
        'started_at'  => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bk()
    {
        return $this->belongsTo(User::class, 'bk_id');
    }

    public function laporan()
    {
        return $this->hasOne(Laporan::class, 'konseling_id');
    }

    /**
     * Cek apakah ada bentrok jadwal dua arah (BK atau Siswa sudah terjadwal di slot yang sama).
     */
    public static function cekBentrok(string $tanggal, string $waktu, int $bkId, int $userId, ?int $ignoreId = null): bool
    {
        return self::when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->where('tanggal', $tanggal)
            ->where('waktu', $waktu)
            ->whereIn('status', ['disetujui', 'dipanggil'])
            ->where(fn($q) => $q->where('bk_id', $bkId)->orWhere('user_id', $userId))
            ->exists();
    }
}

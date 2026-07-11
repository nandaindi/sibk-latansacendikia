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

<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Laporan;
use App\Models\Konseling;
use App\Models\User;

$laporans = Laporan::whereNull('konseling_id')->get();
echo "Found " . $laporans->count() . " unlinked reports.\n";

foreach ($laporans as $laporan) {
    if (str_starts_with($laporan->nama_laporan, 'Laporan Konseling: ')) {
        $namaSiswa = trim(str_replace('Laporan Konseling:', '', $laporan->nama_laporan));
        
        // Find user
        $user = User::where('name', 'like', '%' . $namaSiswa . '%')->first();
        if ($user) {
            // Find session on that date
            $konseling = Konseling::where('user_id', $user->id)
                ->whereDate('tanggal', $laporan->tanggal)
                ->first();
            
            if ($konseling) {
                $laporan->update([
                    'user_id' => $user->id,
                    'konseling_id' => $konseling->id
                ]);
                echo "Linked report {$laporan->id} to user {$user->name} and session {$konseling->id}\n";
            } else {
                // Just link user if session not found
                $laporan->update(['user_id' => $user->id]);
                echo "Linked report {$laporan->id} to user {$user->name} only\n";
            }
        }
    }
}
echo "Backfill complete.\n";

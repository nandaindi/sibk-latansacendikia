<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Laporan;
use App\Models\Konseling;
use App\Models\User;

// Reset incorrect links first if needed, or just focus on improving the search
$laporans = Laporan::all();

foreach ($laporans as $laporan) {
    if (str_starts_with($laporan->nama_laporan, 'Laporan Konseling: ')) {
        $namaSiswa = trim(str_replace('Laporan Konseling:', '', $laporan->nama_laporan));
        $user = User::where('name', 'like', '%' . $namaSiswa . '%')->first();
        
        if ($user) {
            // Find the session that was finished closest to when this report was created
            $konseling = Konseling::where('user_id', $user->id)
                ->where('status', 'selesai')
                // Within 5 minutes of each other usually
                ->whereBetween('updated_at', [
                    $laporan->created_at->subMinutes(5),
                    $laporan->created_at->addMinutes(5)
                ])
                ->first();
            
            if ($konseling) {
                $laporan->update([
                    'user_id' => $user->id,
                    'konseling_id' => $konseling->id
                ]);
                echo "Accurately linked report {$laporan->id} to {$user->name} ({$konseling->jenis}) via timestamp match.\n";
            } else {
                // Try date match as fallback but only if not already linked correctly
                if (!$laporan->konseling_id) {
                    $konseling = Konseling::where('user_id', $user->id)
                        ->whereDate('tanggal', $laporan->tanggal)
                        ->orderBy('updated_at', 'desc')
                        ->first();
                    if ($konseling) {
                         $laporan->update([
                            'user_id' => $user->id,
                            'konseling_id' => $konseling->id
                        ]);
                        echo "Linked report {$laporan->id} to {$user->name} ({$konseling->jenis}) via date fallback.\n";
                    }
                }
            }
        }
    }
}
echo "Improved backfill complete.\n";

<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$laporans = \App\Models\Laporan::all();
foreach ($laporans as $laporan) {
    echo "\nLaporan ID: " . $laporan->id . " - " . $laporan->nama_laporan . "\n";
    $query = \App\Models\Konseling::with('user')->where('status', 'selesai');
    
    if (str_starts_with($laporan->nama_laporan, 'Laporan Konseling: ')) {
        $namaSiswa = trim(str_replace('Laporan Konseling:', '', $laporan->nama_laporan));
        $query->whereHas('user', function($q) use ($namaSiswa) {
            $q->where('name', 'like', '%' . $namaSiswa . '%');
        });
        
        $createdAt = \Carbon\Carbon::parse($laporan->created_at);
        $query->whereBetween('updated_at', [
            $createdAt->copy()->subSeconds(30),
            $createdAt->copy()->addSeconds(30)
        ]);
        
        $items = $query->get();
        echo "Items count (auto): " . count($items) . "\n";
        foreach ($items as $item) {
            echo " - Konseling ID: " . $item->id . " updated at " . $item->updated_at . "\n";
        }
    } else {
        // Just fetch none?
        echo "Manual Laporan\n";
    }
}

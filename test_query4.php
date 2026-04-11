<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$laporans = \App\Models\Laporan::all();
foreach ($laporans as $laporan) {
    if (str_starts_with($laporan->nama_laporan, 'Laporan Konseling: ')) {
        $namaSiswa = trim(str_replace('Laporan Konseling:', '', $laporan->nama_laporan));
        $match = \App\Models\Konseling::where('tanggal', $laporan->tanggal)
            ->where('status', 'selesai')
            ->whereHas('user', function($q) use($namaSiswa) {
                 $q->where('name', $namaSiswa);
            })->get();
        echo "Laporan " . $laporan->id . " matched: " . count($match) . " sessions.\n";
    }
}

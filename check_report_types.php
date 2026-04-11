<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Laporan;

$data = Laporan::with('konseling')->latest()->take(10)->get()->map(function($l) {
    return [
        'laporan_id' => $l->id,
        'nama' => $l->nama_laporan,
        'linked_konseling_id' => $l->konseling_id,
        'jenis_konseling' => $l->konseling->jenis ?? 'MISSING'
    ];
});

print_r($data->toArray());

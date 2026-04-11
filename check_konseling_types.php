<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Konseling;

$stats = Konseling::select('jenis', Illuminate\Support\Facades\DB::raw('count(*) as total'))
    ->groupBy('jenis')
    ->get();

print_r($stats->toArray());

$latest = Konseling::with('user')->latest()->take(5)->get()->map(function($k) {
    return [
        'id' => $k->id,
        'user' => $k->user->name ?? '?',
        'jenis' => $k->jenis,
        'status' => $k->status
    ];
});
print_r($latest->toArray());

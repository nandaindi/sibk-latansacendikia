<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$items = \App\Models\Konseling::with('user')->where('status', 'selesai')->get();
foreach ($items as $item) {
    echo "Konseling ID: " . $item->id . " - User: " . $item->user->name . " - updated_at: " . $item->updated_at . "\n";
}

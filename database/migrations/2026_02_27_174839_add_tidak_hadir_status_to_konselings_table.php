<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {

        DB::statement("ALTER TABLE konselings MODIFY COLUMN status ENUM('pending','disetujui','ditolak','selesai','tidak_hadir','dipanggil') DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE konselings MODIFY COLUMN status ENUM('pending','disetujui','ditolak','selesai','dipanggil') DEFAULT 'pending'");
    }
};

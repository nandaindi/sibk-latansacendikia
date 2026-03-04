<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // MySQL enum tidak bisa di-alter langsung dengan Blueprint, gunakan raw statement
        DB::statement("ALTER TABLE konselings MODIFY COLUMN status ENUM('pending','disetujui','ditolak','selesai','tidak_hadir','dipanggil') DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE konselings MODIFY COLUMN status ENUM('pending','disetujui','ditolak','selesai','dipanggil') DEFAULT 'pending'");
    }
};

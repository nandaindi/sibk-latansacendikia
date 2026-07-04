<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE pelanggarans MODIFY COLUMN status ENUM('menunggu', 'diterima', 'selesai', 'tidak_hadir') DEFAULT 'menunggu'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE pelanggarans MODIFY COLUMN status ENUM('menunggu', 'selesai', 'tidak_hadir') DEFAULT 'menunggu'");
    }
};

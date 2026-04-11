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
        Schema::table('konselings', function (Blueprint $table) {
            $table->text('kesimpulan_siswa')->nullable()->after('catatan_bk');
            $table->text('saran_siswa')->nullable()->after('kesimpulan_siswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konselings', function (Blueprint $table) {
            $table->dropColumn(['kesimpulan_siswa', 'saran_siswa']);
        });
    }
};

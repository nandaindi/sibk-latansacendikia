<?php
/**
 * Migration to add 'rtl' (Rencana Tindak Lanjut) column to 'konselings' table.
 */
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
        Schema::table('konselings', function (Blueprint $blueprint) {
            $blueprint->text('rtl')->nullable()->after('catatan_bk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konselings', function (Blueprint $blueprint) {
            $blueprint->dropColumn('rtl');
        });
    }
};

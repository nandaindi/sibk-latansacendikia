<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('konselings', function (Blueprint $table) {
            $table->text('catatan_siswa')->nullable()->after('problem_type');
        });
    }

    public function down(): void
    {
        Schema::table('konselings', function (Blueprint $table) {
            $table->dropColumn('catatan_siswa');
        });
    }
};

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
            $table->string('kepuasan_penerimaan')->nullable();
            $table->string('kepuasan_kemudahan')->nullable();
            $table->string('kepuasan_kepercayaan')->nullable();
            $table->string('kepuasan_pelayanan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konselings', function (Blueprint $table) {
            $table->dropColumn([
                'kepuasan_penerimaan',
                'kepuasan_kemudahan',
                'kepuasan_kepercayaan',
                'kepuasan_pelayanan',
            ]);
        });
    }
};

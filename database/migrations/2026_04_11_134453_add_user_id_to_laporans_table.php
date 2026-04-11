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
        Schema::table('laporans', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('author_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('konseling_id')->nullable()->after('user_id')->constrained('konselings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['konseling_id']);
            $table->dropColumn(['user_id', 'konseling_id']);
        });
    }
};

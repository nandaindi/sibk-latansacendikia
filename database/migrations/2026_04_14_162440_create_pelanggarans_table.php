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
        Schema::create('pelanggarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('bk_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('topik');
            $table->date('tanggal');
            $table->string('waktu');
            $table->enum('status', ['menunggu', 'selesai', 'tidak_hadir'])->default('menunggu');
            $table->text('catatan_pemanggilan')->nullable();
            $table->text('catatan_hasil')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggarans');
    }
};

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
        Schema::table('users', function (Blueprint $table) {
            // Profil umum
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('kelas');
            $table->string('tempat_lahir')->nullable()->after('jenis_kelamin');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->text('alamat')->nullable()->after('tanggal_lahir');

            // Khusus siswa
            $table->string('nama_ortu')->nullable()->after('alamat');
            $table->string('telepon_ortu')->nullable()->after('nama_ortu');

            // Khusus guru/BK
            $table->string('nip')->nullable()->after('telepon_ortu');
            $table->string('jabatan')->nullable()->after('nip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_kelamin',
                'tempat_lahir',
                'tanggal_lahir',
                'alamat',
                'nama_ortu',
                'telepon_ortu',
                'nip',
                'jabatan',
            ]);
        });
    }
};

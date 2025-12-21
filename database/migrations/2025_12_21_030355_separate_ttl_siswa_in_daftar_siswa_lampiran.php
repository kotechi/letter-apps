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
        Schema::table('daftar_siswa_lampiran', function (Blueprint $table) {
            $table->string('tempat_lahir')->nullable()->after('nama_siswa');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->dropColumn('ttl_siswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daftar_siswa_lampiran', function (Blueprint $table) {
            $table->string('ttl_siswa')->after('nama_siswa');
            $table->dropColumn(['tempat_lahir', 'tanggal_lahir']);
        });
    }
};

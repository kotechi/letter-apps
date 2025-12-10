<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daftar_siswa_lampiran', function (Blueprint $table) {
            $table->id();
            $table->integer('no');
            $table->string('nama_siswa');
            $table->string('ttl_siswa');
            $table->string('kelas_masuk')->nullable();
            $table->string('tahun_masuk')->nullable();
            $table->string('asal_sekolah')->nullable();
            $table->string('nisn')->nullable();
            $table->foreignId('lampiran_id')->constrained('lampiran')->onDelete('cascade');
            $table->timestamps();
            
            // Indexes
            $table->index('lampiran_id');
            $table->index('nisn');
            $table->index('nama_siswa');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daftar_siswa_lampiran');
    }
};

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
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_masehi');
            $table->string('tanggal_hijriah');
            $table->string('nomor_surat');
            $table->string('lampiran')->nullable();
            $table->string('nomor_surat_saudara')->nullable();
            $table->date('tanggal_permohonan')->nullable();
            $table->string('nama_kepala_bidang')->nullable();
            $table->string('nip_kepala_bidang')->nullable();
            $table->string('file_docx')->nullable();
            $table->string('file_pdf')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('tanggal_masehi');
            $table->index('nomor_surat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
    }
};

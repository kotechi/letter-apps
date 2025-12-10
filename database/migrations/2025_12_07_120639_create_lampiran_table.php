<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lampiran', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_lampiran');
            $table->date('tanggal_lampiran');
            $table->string('nama_kabid_lampiran')->nullable();
            $table->string('nip_kabid_lampiran')->nullable();
            $table->foreignId('surat_masuk_id')->constrained('surat_masuk')->onDelete('cascade');
            $table->timestamps();
            
            // Indexes
            $table->index('surat_masuk_id');
            $table->index('nomor_lampiran');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lampiran');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->foreignId('sekolah_id')->constrained('schools')->onDelete('cascade');
            $table->foreignId('asal_sekolah_id')->nullable()->constrained('schools')->onDelete('set null');
            
            $table->string('nama');
            $table->string('kelas')->nullable();
            $table->string('nisn')->nullable();
            $table->string('nis')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('jenis_kelamin')->nullable();
            
            $table->string('nama_sekolah_tujuan');
            $table->text('alamat_sekolah_tujuan')->nullable();
            $table->string('kota_sekolah_tujuan')->nullable();
            $table->string('provinsi_sekolah_tujuan')->nullable();
            
            $table->string('asal_sekolah')->nullable();
            $table->text('alamat_sekolah_asal')->nullable();
            
            $table->string('no_surat_asal')->nullable();
            $table->string('no_surat_keterangan')->nullable();
            $table->string('nip_kepsek')->nullable();
            $table->string('nama_kepsek')->nullable();
            $table->date('tanggal_surat');
            
            $table->string('file_docx')->nullable();
            $table->string('file_pdf')->nullable();
            
            $table->text('keterangan')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('siswa_id');
            $table->index('sekolah_id');
            $table->index('tanggal_surat');
        });
    }


};
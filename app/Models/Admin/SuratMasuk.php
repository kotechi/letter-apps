<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    protected $table = 'surat_masuk';
    
    protected $fillable = [
        'tanggal_masehi',
        'tanggal_hijriah',
        'nomor_surat',
        'lampiran',
        'nomor_surat_saudara',
        'tanggal_permohonan',
        'nama_kepala_bidang',
        'nip_kepala_bidang',
        'file_docx',
        'file_pdf',
        'yth_nama_sekolah_tujuan',
        'yth_alamat_sekolah_tujuan',
        'nama_sekolah_tujuan',
    ];

    protected $casts = [
        'tanggal_masehi' => 'date',
        'tanggal_permohonan' => 'date',
    ];

    public function lampiran_list()
    {
        return $this->hasMany(Lampiran::class, 'surat_masuk_id');
    }
}

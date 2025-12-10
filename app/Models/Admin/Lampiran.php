<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Lampiran extends Model
{
    protected $table = 'lampiran';
    
    protected $fillable = [
        'nomor_lampiran',
        'tanggal_lampiran',
        'nama_kabid_lampiran',
        'nip_kabid_lampiran',
        'surat_masuk_id',
    ];

    protected $casts = [
        'tanggal_lampiran' => 'date',
    ];

    public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class, 'surat_masuk_id');
    }

    public function daftarSiswa()
    {
        return $this->hasMany(DaftarSiswaLampiran::class, 'lampiran_id');
    }
}

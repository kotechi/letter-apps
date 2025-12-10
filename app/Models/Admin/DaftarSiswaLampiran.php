<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class DaftarSiswaLampiran extends Model
{
    protected $table = 'daftar_siswa_lampiran';
    
    protected $fillable = [
        'no',
        'nama_siswa',
        'ttl_siswa',
        'kelas_masuk',
        'tahun_masuk',
        'asal_sekolah',
        'nisn',
        'lampiran_id',
    ];

    public function lampiran()
    {
        return $this->belongsTo(Lampiran::class, 'lampiran_id');
    }
}

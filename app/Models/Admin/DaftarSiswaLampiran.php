<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class DaftarSiswaLampiran extends Model
{
    protected $table = 'daftar_siswa_lampiran';
    
    protected $fillable = [
        'no',
        'nama_siswa',
        'tempat_lahir',
        'tanggal_lahir',
        'kelas_masuk',
        'tahun_masuk',
        'asal_sekolah',
        'nisn',
        'lampiran_id',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function lampiran()
    {
        return $this->belongsTo(Lampiran::class, 'lampiran_id');
    }
}

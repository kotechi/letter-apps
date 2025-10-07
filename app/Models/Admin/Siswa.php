<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';

    protected $fillable = [
        'nama',
        'kelas',
        'jenis_kelamin',
        'asal_sekolah',
        'nisn',
        'nis',
        'tempat_lahir',
        'tanggal_lahir',
    ];

    public function school()
    {
        return $this->belongsTo(School::class, 'asal_sekolah');
    }
}

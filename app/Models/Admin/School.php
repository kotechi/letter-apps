<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $table = 'schools';

    protected $fillable = [
        'nama_sekolah',
        'alamat',
        'kota',
        'provinsi',
    ];

    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'asal_sekolah_id');
    }
}
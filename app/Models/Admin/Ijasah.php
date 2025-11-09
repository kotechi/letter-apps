<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Ijasah extends Model
{
    protected $table = 'ijasahs';

    protected $fillable = [
        'nama',
        'asal_sekolah',
        'tanggal_masuk',
        'keterangan',
    ];
}

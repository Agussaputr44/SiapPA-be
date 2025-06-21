<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduans extends Model
{
    // Nama tabel
    protected $table = 'pengaduans';

    protected $fillable = [
        'namaKorban',
        'alamat',
        'aduan',
        'harapan',
        'status',
        'kategoriKekerasan',
        'pelapor',
        'evidencePaths',
    ];
}

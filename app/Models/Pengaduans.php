<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduans extends Model
{
    // Nama tabel
    protected $table = 'pengaduans';

    // Kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'namaKorban',
        'alamat',
        'aduan',
        'harapan',
        'status',
        'pelapor',
        'evidenceUrls',
        'evidencePaths',
    ];
}

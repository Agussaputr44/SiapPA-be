<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Artikels extends Model
{
    // Nama tabel
    protected $table = 'artikels';

    // Kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'judul',
        'isi',
        'tanggal',
        'foto',
    ];
}

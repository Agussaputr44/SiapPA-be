<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Artikels extends Model
{
    // Nama tabel
    protected $table = 'artikels';

    public $timestamps = true; // penting: aktifkan timestamps

    // Kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'judul',
        'isi',
        'foto',
    ];
}

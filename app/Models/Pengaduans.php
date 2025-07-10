<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="PengaduanRequest",
 *     required={"namaKorban", "alamat", "aduan", "kategoriKekerasan", "harapan"},
 *     @OA\Property(property="namaKorban", type="string", example="Siti Nurhaliza"),
 *     @OA\Property(property="alamat", type="string", example="Jl. Merdeka No. 123"),
 *     @OA\Property(property="aduan", type="string", example="Saya mengalami kekerasan."),
 *     @OA\Property(property="kategoriKekerasan", type="string", enum={"kekerasan_fisik", "kekerasan_seksual", "kekerasan_lainnya"}, example="kekerasan_fisik"),
 *     @OA\Property(property="harapan", type="string", example="Saya berharap pelaku dihukum."),
 *     @OA\Property(property="status", type="string", nullable=true, example="terkirim"),
 *     @OA\Property(property="evidencePaths", type="string", nullable=true, example="[evidence/image.jpg]")
 * )
 */
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
        'korban'
    ];

     protected $casts = [
        'evidencePaths' => 'array', 
    ];
}

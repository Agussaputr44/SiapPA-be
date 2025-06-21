<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Artikels",
 *     type="object",
 *     title="Artikel",
 *     required={"judul", "isi", "foto"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="judul", type="string", example="Judul Artikel"),
 *     @OA\Property(property="isi", type="string", example="Isi lengkap artikel..."),
 *     @OA\Property(property="foto", type="string", format="url", example="http://example.com/image.jpg"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Artikels extends Model
{
    protected $table = 'artikels';

    public $timestamps = true;

    protected $fillable = [
        'judul',
        'isi',
        'foto',
    ];
}

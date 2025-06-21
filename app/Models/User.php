<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Components(
 *     @OA\Schema(
 *         schema="User",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=1, description="ID unik pengguna"),
 *         @OA\Property(property="name", type="string", example="John Doe", description="Nama pengguna"),
 *         @OA\Property(property="email", type="string", example="john@example.com", description="Email pengguna"),
 *         @OA\Property(property="foto_profile", type="string", example="path/to/foto.jpg", description="Path atau URL foto profil", nullable=true),
 *         @OA\Property(property="created_at", type="string", format="date-time", example="2025-06-21T20:40:00Z", description="Waktu pembuatan"),
 *         @OA\Property(property="updated_at", type="string", format="date-time", example="2025-06-21T20:40:00Z", description="Waktu pembaruan")
 *     ),
 *     @OA\Schema(
 *         schema="AuthResponse",
 *         type="object",
 *         @OA\Property(property="token", type="string", example="your-auth-token", description="Token autentikasi"),
 *         @OA\Property(property="token_type", type="string", example="Bearer", description="Jenis token"),
 *         @OA\Property(property="user_data", ref="#/components/schemas/User", description="Data pengguna", nullable=true),
 *         @OA\Property(property="success", type="boolean", example=true, description="Status keberhasilan", nullable=true),
 *         @OA\Property(property="message", type="string", example="Login successful", description="Pesan sukses", nullable=true)
 *     ),
 *     @OA\Schema(
 *         schema="ErrorResponse",
 *         type="object",
 *         @OA\Property(property="message", type="string", example="Login failed, please check your credentials.", description="Pesan error"),
 *         @OA\Property(property="success", type="boolean", example=false, description="Status keberhasilan", nullable=true)
 *     ),
 *     @OA\Schema(
 *         schema="ValidationError",
 *         type="object",
 *        @OA\Property(
 * property="error",
 *   type="object",
 *  example={"email": {"0": "The email field is required."}},
 * description="Kesalahan validasi"
 *)
 * )
 * )
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'foto_profile'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}

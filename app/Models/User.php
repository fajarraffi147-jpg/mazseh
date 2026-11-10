<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'phone', 'city', 'address', 'sim_number'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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

    /**
     * Relasi ke dokumen pelanggan (KTP & SIM).
     */
    public function dokumenPelanggan(): HasOne
    {
        return $this->hasOne(DocumentPelanggan::class, 'user_id', 'id');
    }

    /**
     * Relasi ke daftar transaksi sewa mobil.
     */
    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'user_id', 'id');
    }

    /**
     * Relasi ke sesi chat AI.
     */
    public function sesiChatAi(): HasMany
    {
        return $this->hasMany(SesiChatAi::class, 'user_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SesiChatAi extends Model
{
    use HasFactory;

    protected $table = 'sesi_chat_ai';
    protected $primaryKey = 'id_sesi';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'pesan_pelanggan',
        'balasan_ai',
        'status_sesi',
        'waktu_sesi',
    ];

    protected function casts(): array
    {
        return [
            'waktu_sesi' => 'datetime',
        ];
    }

    /**
     * Relasi ke data pelanggan jika chat dalam kondisi login.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

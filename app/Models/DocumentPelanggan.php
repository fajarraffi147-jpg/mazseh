<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentPelanggan extends Model
{
    use HasFactory;

    protected $table = 'document_pelanggan';
    protected $primaryKey = 'id_dokumen';

    protected $fillable = [
        'user_id',
        'file_ktp',
        'file_sim',
        'status_verifikasi',
    ];

    /**
     * Relasi ke data pengguna pemilik dokumen.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Label status verifikasi yang mudah dibaca.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status_verifikasi) {
            'disetujui' => 'Disetujui',
            'menunggu_validasi' => 'Menunggu Validasi',
            'ditolak' => 'Ditolak',
            default => 'Belum Upload',
        };
    }

    /**
     * Kelas CSS badge untuk status verifikasi.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status_verifikasi) {
            'disetujui' => 'green',
            'menunggu_validasi' => 'amber',
            'ditolak' => 'red',
            default => 'gray',
        };
    }
}

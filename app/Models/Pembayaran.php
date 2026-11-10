<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    public $timestamps = false;

    protected $fillable = [
        'id_transaksi',
        'kasir_id',
        'jumlah_bayar',
        'status_pembayaran',
        'jumlah_refund',
        'status_refund',
        'waktu_bayar',
        'metode_pembayaran',
        'referensi_pembayaran',
        'bukti_bayar',
    ];

    protected function casts(): array
    {
        return [
            'jumlah_bayar' => 'decimal:2',
            'jumlah_refund' => 'decimal:2',
            'waktu_bayar' => 'datetime',
        ];
    }

    /**
     * Relasi ke transaksi yang dibayarkan.
     */
    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }

    /**
     * Relasi ke staf kasir yang memvalidasi pembayaran.
     */
    public function kasir(): BelongsTo
    {
        return $this->belongsTo(User::class, 'kasir_id', 'id');
    }

    /**
     * Format nominal pembayaran ke Rupiah.
     */
    public function getFormattedAmountAttribute(): string
    {
        return 'Rp' . number_format((float) $this->jumlah_bayar, 0, ',', '.');
    }

    /**
     * Label status pembayaran.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status_pembayaran) {
            'lunas' => 'Lunas',
            'pending' => 'Pending',
            'gagal' => 'Gagal',
            default => ucfirst((string) $this->status_pembayaran),
        };
    }

    /**
     * Warna badge status pembayaran.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status_pembayaran) {
            'lunas' => 'green',
            'pending' => 'amber',
            'gagal' => 'red',
            default => 'blue',
        };
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'id_mobil',
        'tanggal_mulai',
        'tanggal_selesai',
        'total_harga',
        'status_pesanan',
        'alasan_batal',
        'latitude',
        'longitude',
        'titik_jemput',
        'waktu_pesan',
        'kode_booking',
        'waktu_ambil',
        'metode_pengambilan',
        'opsi_pengemudi',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
            'waktu_pesan' => 'datetime',
            'total_harga' => 'decimal:2',
        ];
    }

    /**
     * Relasi ke penyewa / pengguna.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relasi ke mobil yang disewa.
     */
    public function mobil(): BelongsTo
    {
        return $this->belongsTo(KatalogMobil::class, 'id_mobil', 'id_mobil');
    }

    /**
     * Relasi ke data pembayaran transaksi.
     */
    public function pembayaran(): HasOne
    {
        return $this->hasOne(Pembayaran::class, 'id_transaksi', 'id_transaksi');
    }

    /**
     * Hitung durasi hari sewa.
     */
    public function getDurationDaysAttribute(): int
    {
        if (!$this->tanggal_mulai || !$this->tanggal_selesai) {
            return 1;
        }

        $start = Carbon::parse($this->tanggal_mulai);
        $end = Carbon::parse($this->tanggal_selesai);
        $diff = $start->diffInDays($end);

        return max(1, (int) $diff);
    }

    /**
     * Format total harga ke representasi Rupiah.
     */
    public function getFormattedTotalAttribute(): string
    {
        return 'Rp' . number_format((float) $this->total_harga, 0, ',', '.');
    }

    /**
     * Format status pesanan agar ramah pengguna.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status_pesanan) {
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'dikonfirmasi' => 'Dikonfirmasi',
            'dibatalkan' => 'Dibatalkan',
            default => ucfirst(str_replace('_', ' ', (string) $this->status_pesanan)),
        };
    }

    /**
     * Warna badge status pesanan.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status_pesanan) {
            'dikonfirmasi' => 'green',
            'menunggu_pembayaran' => 'amber',
            'dibatalkan' => 'red',
            default => 'blue',
        };
    }
}

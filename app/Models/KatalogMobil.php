<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KatalogMobil extends Model
{
    use HasFactory;

    protected $table = 'katalog_mobil';
    protected $primaryKey = 'id_mobil';

    protected $fillable = [
        'id_kategori',
        'plat_nomor',
        'merk_model',
        'harga_sewa',
        'status_ketersediaan',
        'versi',
        'slug',
        'tahun',
        'transmisi',
        'jumlah_kursi',
        'bahan_bakar',
        'kota',
        'foto_mobil',
        'label',
        'deskripsi',
        'fitur',
    ];

    protected function casts(): array
    {
        return [
            'fitur' => 'array',
            'harga_sewa' => 'decimal:2',
            'tahun' => 'integer',
            'jumlah_kursi' => 'integer',
            'versi' => 'integer',
        ];
    }

    /**
     * Relasi ke kategori mobil.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriMobil::class, 'id_kategori', 'id_kategori');
    }

    /**
     * Relasi ke riwayat transaksi untuk mobil ini.
     */
    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'id_mobil', 'id_mobil');
    }

    /**
     * Format harga sewa ke representasi mata uang Rupiah.
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp' . number_format((float) $this->harga_sewa, 0, ',', '.');
    }

    /**
     * Cek apakah mobil tersedia pada rentang tanggal tertentu.
     */
    public function isAvailableForDates(string $start, string $end, ?int $excludeTransaksiId = null): bool
    {
        if ($this->status_ketersediaan !== 'tersedia') {
            return false;
        }

        $conflict = $this->transaksi()
            ->whereNotIn('status_pesanan', ['dibatalkan'])
            ->when($excludeTransaksiId, function ($query, $id) {
                $query->where('id_transaksi', '!=', $id);
            })
            ->where(function ($query) use ($start, $end) {
                $query->where('tanggal_mulai', '<', $end)
                    ->where('tanggal_selesai', '>', $start);
            })
            ->exists();

        return !$conflict;
    }
}

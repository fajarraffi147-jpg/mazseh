<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriMobil extends Model
{
    use HasFactory;

    protected $table = 'kategori_mobil';
    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'nama_kategori',
    ];

    /**
     * Relasi ke katalog mobil dalam kategori ini.
     */
    public function mobil(): HasMany
    {
        return $this->hasMany(KatalogMobil::class, 'id_kategori', 'id_kategori');
    }
}

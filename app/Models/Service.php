<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    // Tidak perlu $table. Nama class "Service" otomatis ditebak jadi tabel "services".

    protected $fillable = [
        'nama',
        'icon',
        'warna',
        'kategori',
        'harga',
        'satuan',
        'keterangan',
        'status',
    ];

    public function getHargaFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.') . '/' . str_replace('per ', '', $this->satuan);
    }
}

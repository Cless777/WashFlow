<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'packages'; // Nama tabel di database

    protected $fillable = [
        'nama',
        'icon',
        'warna',
        'harga',
        'satuan',
        'estimasi_hari',
        'keterangan',
        'status',
    ];

    /**
     * Accessor: format harga jadi "Rp 7.000/kg" siap tampil di view.
     * Dipanggil di Blade cukup dengan: $paket->harga_format
     */
    public function getHargaFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.') . '/' . $this->satuan;
    }

    /**
     * Accessor: format estimasi jadi "2 Hari" siap tampil di view.
     */
    public function getEstimasiFormatAttribute(): string
    {
        return $this->estimasi_hari . ' Hari';
    }
}

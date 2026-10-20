<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'kode',
        'nama',
        'no_hp',
        'alamat',
        'total_order',
        'status',
    ];

    /**
     * Generate kode pelanggan otomatis, format: PLG001, PLG002, dst.
     * Dipanggil dari controller sebelum create().
     */
    public static function generateKode(): string
    {
        $last = self::orderByDesc('id')->first();

        if (!$last) {
            return 'PLG001';
        }

        // Ambil angka dari kode terakhir, misal "PLG006" -> 6
        $lastNumber = (int) substr($last->kode, 3);
        $nextNumber = $lastNumber + 1;

        return 'PLG' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    // TODO: setelah tabel orders dibuat, tambahkan relasi berikut
    // dan hapus kolom total_order dari database (hitung otomatis via withCount)
    //
    // public function orders()
    // {
    //     return $this->hasMany(Order::class);
    // }
}

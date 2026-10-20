<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'no_transaksi',
        'order_id',
        'jumlah_dibayar',
        'metode',
        'status',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Generate nomor transaksi otomatis, format: TRX001, TRX002, dst.
     */
    public static function generateNoTransaksi(): string
    {
        $last = self::orderByDesc('id')->first();

        if (!$last) {
            return 'TRX001';
        }

        $lastNumber = (int) substr($last->no_transaksi, 3);
        $nextNumber = $lastNumber + 1;

        return 'TRX' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }
}

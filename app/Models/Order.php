<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'no_order',
        'customer_id',
        'package_id',
        'berat',
        'total',
        'tanggal_masuk',
        'estimasi_selesai',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'estimasi_selesai' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public static function generateNoOrder(): string
    {
        $last = self::orderByDesc('id')->first();

        if (!$last) {
            return 'LA001';
        }

        $lastNumber = (int) substr($last->no_order, 2);
        $nextNumber = $lastNumber + 1;

        return 'LA' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

        public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}

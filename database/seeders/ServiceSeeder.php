<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $layanan = [
            [
                'nama' => 'Cuci Reguler',
                'kategori' => 'Cuci',
                'harga' => 7000,
                'satuan' => 'kg',
                'keterangan' => 'Cuci dan kering, estimasi 2-3 hari',
                'status' => 'Aktif',
                'icon' => 'fa-soap',
                'warna' => 'primary',
            ],
            [
                'nama' => 'Cuci Express',
                'kategori' => 'Cuci',
                'harga' => 12000,
                'satuan' => 'kg',
                'keterangan' => 'Selesai dalam 1 hari',
                'status' => 'Aktif',
                'icon' => 'fa-bolt',
                'warna' => 'warning',
            ],
            [
                'nama' => 'Setrika Saja',
                'kategori' => 'Setrika',
                'harga' => 5000,
                'satuan' => 'kg',
                'keterangan' => 'Cucian sudah bersih, hanya perlu disetrika',
                'status' => 'Aktif',
                'icon' => 'fa-tshirt',
                'warna' => 'info',
            ],
            [
                'nama' => 'Cuci + Setrika',
                'kategori' => 'Cuci & Setrika',
                'harga' => 9000,
                'satuan' => 'kg',
                'keterangan' => 'Paket lengkap cuci dan setrika',
                'status' => 'Aktif',
                'icon' => 'fa-soap',
                'warna' => 'success',
            ],
            [
                'nama' => 'Cuci Sepatu',
                'kategori' => 'Sepatu',
                'harga' => 20000,
                'satuan' => 'pasang',
                'keterangan' => 'Cuci sepatu manual, estimasi 2 hari',
                'status' => 'Aktif',
                'icon' => 'fa-shoe-prints',
                'warna' => 'secondary',
            ],
        ];

        foreach ($layanan as $item) {
            Service::create($item);
        }
    }
}
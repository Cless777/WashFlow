<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create([
            'nama' => 'admin',
            'deskripsi' => 'Mengelola operasional laundry',
            'warna_badge' => 'primary',
            'status' => true,
        ]);

        Role::create([
            'nama' => 'kasir',
            'deskripsi' => 'Mengelola transaksi kasir',
            'warna_badge' => 'primary',
            'status' => true,
        ]);

        Role::create([
            'nama' => 'owner',
            'deskripsi' => 'Pemilik usaha laundry',
            'warna_badge' => 'success',
            'status' => true,
        ]);
    }
}
<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::where('nama', 'admin')->first();

       User::updateOrCreate(
            [
                'email' => 'admin@washflow.com',
            ],
            [
                'name' => 'Muhammad Gustian Alvaro',
                'password' => Hash::make('password123'),
                'role_id' => $admin->id,
            ]
        );
    }
}
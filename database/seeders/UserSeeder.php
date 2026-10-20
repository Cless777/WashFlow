<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kasirRole = Role::where('nama', 'Kasir')->first();
        $ownerRole = Role::where('nama', 'Owner')->first();

        User::updateOrCreate([
            'email' => 'kasir@washflow.com',
        ], [
            'name' => 'Kasir',
            'password' => Hash::make('password123'),
            'role_id' => $kasirRole->id,
        ]);

        User::updateOrCreate([
            'email' => 'owner@washflow.com',
        ], [
            'name' => 'Owner',
            'password' => Hash::make('password123'),
            'role_id' => $ownerRole->id,
        ]);
    }
}

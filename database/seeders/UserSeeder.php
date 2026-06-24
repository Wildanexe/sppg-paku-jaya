<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Wildan Obit Waluyo', // Nama kamu sesuai profil
            'email' => 'ketua@sppg.com',
            'password' => Hash::make('password123'),
            'role' => 'ketua', // Role tertinggi
        ]);
    }
}

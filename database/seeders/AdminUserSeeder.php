<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // jangan lupa import User model
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Cek dulu apakah user admin sudah ada supaya gak duplikat
        $user = User::firstOrCreate(
            ['email' => 'admin@universitas.ac.id'],
            [
                'name' => 'Admin',
                'email_verified_at' => now(),
                'password' => Hash::make('admin123'), // ganti sesuai password
            ]
        );

        $user->assignRole('admin'); // assign role admin ke user ini
    }
}

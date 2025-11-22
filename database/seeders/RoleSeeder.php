<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Buat role jika belum ada
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'pegawai']);
        Role::firstOrCreate(['name' => 'mahasiswa']);

        // Assign role ke user (misal user id 1 admin)
        $user = User::find(1);
        if ($user) {
            $user->assignRole('admin');
        }
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'pegawai']);
        Role::firstOrCreate(['name' => 'mahasiswa']);

        $user = User::find(1);
        if ($user) {
            $user->assignRole('admin');
        }
    }
}
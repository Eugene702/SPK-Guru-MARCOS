<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $role = Role::create(['name' => 'Admin']);
        $user = User::create([
            'name' => 'Manajemen',
            'email' => 'manajemen@gmail.com',
            'password' => Hash::make('manajemen@gmail.com')
        ]);

        $user->assignRole($role);
    }
}

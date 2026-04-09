<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Bci Admin',
            'email' => 'webDevAdmin@bcimedia.com',
            'password' => Hash::make('bciadminpassword123!'),
            'role' => 'admin',
        ]);
    }
}
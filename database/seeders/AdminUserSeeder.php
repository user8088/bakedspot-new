<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@bakedspot.com.manahil'],
            [
                'name' => 'Admin',
                'email' => 'admin@bakedspot.com.manahil',
                'password' => Hash::make('Admin@123'),
                'role' => 'admin'
            ]
        );
    }
}

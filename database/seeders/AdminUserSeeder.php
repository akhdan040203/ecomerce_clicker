<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@clicker.com'],
            [
                'name' => 'Admin Clicker',
                'password' => \Illuminate\Support\Facades\Hash::make('password789'),
                'role' => 'admin',
                'address' => 'Admin Office'
            ]
        );
    }
}

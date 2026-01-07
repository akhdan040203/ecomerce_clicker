<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            AdminUserSeeder::class, // Added Admin Seeder
        ]);

        \App\Models\User::updateOrCreate(
            ['email' => 'test@gmail.com'],
            [
                'name' => 'User Test',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'customer',
            ]
        );
    }
}

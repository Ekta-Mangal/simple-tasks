<?php

namespace Database\Seeders;

use App\Models\App;
use Illuminate\Support\Facades\Hash;
use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Creating the Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Admin@123'),
            'role' => 'Admin',
        ]);

        // Creating a User
        User::create([
            'name' => 'Test User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('User@123'),
            'role' => 'User',
        ]);

        User::factory(20)->create();
        Task::factory(50)->create();
    }
}
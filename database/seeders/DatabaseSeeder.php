<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use App\Models\Task;
use App\Models\User;
use App\Models\UserContact;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name' => 'Ekta Mangal',
            'email' => 'ektamangal8076@gmail.com',
            'password' => Hash::make('Admin@123'),
            'role' => 'Admin',
        ]);

        UserContact::create([
            'user_id' => $user->id,
            'address1' => 'Delhi',
            'postcode' => '110032',
            'country_id' => '1',
            'phone' => '8076371375',
        ]);

        $user = User::create([
            'name' => 'Test User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('User@123'),
            'role' => 'User',
        ]);

        UserContact::create([
            'user_id' => $user->id,
            'address1' => 'Test Address',
            'postcode' => '123456',
            'country_id' => '2',
            'phone' => '0987654321',
        ]);


        User::factory(20)->create();
        Task::factory(50)->create();
    }
}
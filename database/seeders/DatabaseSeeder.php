<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Administrator',
            'email' => 'leiri@admin.com',
            'password' => Hash::make('leiri@admin'),
            'role'=>'admin',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'user',
            'email' => 'leiri@user.com',
            'password' => Hash::make('user@123'),
            'role'=>'user',
        ]);
    }
}

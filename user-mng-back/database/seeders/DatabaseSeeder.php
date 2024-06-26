<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Manager',
            'email' => 'manager@test.com',
            'password' => Hash::make('cc03e747a6afbbcbf8be7668acfebee5'),
            'isAdmin' => true
        ]);
    }
}

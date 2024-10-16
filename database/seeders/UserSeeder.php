<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'john_doe',
                'email' => 'john@example.com',
                'phone' => '123-456-7890',
                'address' => '123 Main St, Springfield, IL',
                'gender' => 'male',
                'password' => bcrypt('password123')
            ],
            [
                'username' => 'jane_smith',
                'email' => 'jane@example.com',
                'phone' => '987-654-3210',
                'address' => '456 Elm St, Springfield, IL',
                'gender' => 'female',
                'password' => bcrypt('password123')
            ],
            [
                'username' => 'alice_johnson',
                'email' => 'alice@example.com',
                'phone' => '555-555-5555',
                'address' => '789 Maple St, Springfield, IL',
                'gender' => 'female',
                'password' => bcrypt('password123')
            ],
            [
                'username' => 'bob_brown',
                'email' => 'bob@example.com',
                'phone' => '444-444-4444',
                'address' => '101 Oak St, Springfield, IL',
                'gender' => 'male',
                'password' => bcrypt('password123')
            ],
            [
                'username' => 'charlie_white',
                'email' => 'charlie@example.com',
                'phone' => '333-333-3333',
                'address' => '202 Birch St, Springfield, IL',
                'gender' => 'male',
                'password' => bcrypt('password123')
            ],
            [
                'username' => 'diana_black',
                'email' => 'diana@example.com',
                'phone' => '222-222-2222',
                'address' => '303 Pine St, Springfield, IL',
                'gender' => 'female',
                'password' => bcrypt('password123')
            ],
        ]);
    }
}
<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Http\Middleware\user;
use App\Models\Admin;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Customer::class,
            // Order::class,
            OrderSeeder::class,
            // ProductSeeder::class,
            // UserSeeder::class,
            // AdminSeeder::class
        ]);
    }
}
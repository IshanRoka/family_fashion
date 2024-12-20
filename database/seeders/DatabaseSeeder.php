<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Http\Middleware\admin as MiddlewareAdmin;
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
            // AdminSeeder::class,
            // UserSeeder::class,
            // ProductSeeder::class,
            OrderSeeder::class,
            // QAseeder::class,
        ]);
    }
}
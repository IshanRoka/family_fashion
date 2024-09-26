<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Customer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('customers')->insert([
            [
                'email' => Str::random(10) . '@example.com',
                'address' => '123 Main St, Anytown, USA',
                'name' => 'John Doe',
                'phone_number' => '555-1234'
            ],
            [
                'email' => Str::random(10) . '@example.com',
                'address' => '456 Maple Ave, Anytown, USA',
                'name' => 'Jane Smith',
                'phone_number' => '555-5678'
            ]
        ]);
    }
}

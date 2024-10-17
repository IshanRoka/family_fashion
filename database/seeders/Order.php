<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Order extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([
            [
                'total_amount' => 99.99,
                'order_status' => 'pending',
                'qty' => 2,
                'address' => '789 Oak St, Anytown, USA',
                'phone_number' => '555-9876',
                'email' => Str::random(10) . '@example.com',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'total_amount' => 49.99,
                'order_status' => 'completed',
                'qty' => 1,
                'address' => '654 Pine St, Anytown, USA',
                'phone_number' => '555-6543',
                'email' => Str::random(10) . '@example.com',
                'status' => 'N',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\QA;

class QAseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        QA::factory()->count(20)->create();
    }
}
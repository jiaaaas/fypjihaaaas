<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StatusWork;

class StatusWorksTableSeeder extends Seeder
{
    public function run(): void
    {
        StatusWork::create(['name' => 'Hybrid']);
        StatusWork::create(['name' => 'Non-Hybrid']);
    }
}


<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Department::create(['name' => 'Management']);
        \App\Models\Department::create(['name' => 'Sales and Marketing']);
        \App\Models\Department::create(['name' => 'Financial and Admin']);
        \App\Models\Department::create(['name' => 'Development Team']);
    }
}

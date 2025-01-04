<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentsTableSeeder extends Seeder
{
    public function run(): void
    {
        Department::create(['name' => 'Management']);
        Department::create(['name' => 'Sales and Marketing']);
        Department::create(['name' => 'Financial and Admin']);
        Department::create(['name' => 'Development Team']);
    }
}


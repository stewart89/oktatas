<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::create([
            'name' => 'ELTE IK - Programtervező informatikus',
            'is_optional_subject_required' => 1
        ]);

        Department::create([
            'name' => 'PPKE BTK – Anglisztika',
            'is_optional_subject_required' => 1
        ]);
    }
}

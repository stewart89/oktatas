<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentSubjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $departmentName = 'ELTE IK - Programtervező informatikus';
        $subjectNames = ['Informatika', 'Kémia', 'Biológia', 'Fizika'];

        $department = Department::where('name', $departmentName)->first();

        if ($department) {
            $subjects = Subject::whereIn('name', $subjectNames)->get();
            $department->subjects()->attach($subjects, ['type' => 'optional']);

            $subject = Subject::where('name', 'Matematika')->get();
            $department->subjects()->attach($subject, ['type' => 'required']);
        }

        $departmentName = 'PPKE BTK – Anglisztika';
        $subjectNames = ['Német', 'Francia', 'Olasz', 'Orosz', 'Spanyol', 'Történelem'];

        $department = Department::where('name', $departmentName)->first();

        if ($department) {
            $subjects = Subject::whereIn('name', $subjectNames)->get();
            $department->subjects()->attach($subjects, ['type' => 'optional']);

            //Angolt külön kezeljük
            $subject = Subject::where('name', 'Angol')->get();
            $department->subjects()->attach($subject, ['type' => 'required', 'level' => 'emelt']);
        }
    }
}

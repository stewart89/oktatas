<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            ['name' => 'Magyar nyelv és irodalom', 'required' => 1],
            ['name' => 'Történelem', 'required' => 1],
            ['name' => 'Matematika', 'required' => 1],
            ['name' => 'Informatika'],
            ['name' => 'Biológia'],
            ['name' => 'Fizika'],
            ['name' => 'Kémia'],
            ['name' => 'Angol'],
            ['name' => 'Német'],
            ['name' => 'Francia'],
            ['name' => 'Olasz'],
            ['name' => 'Orosz'],
            ['name' => 'Spanyol'],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Category;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        $student = Student::first();
        $category = Category::first();

        Enrollment::create([
            'student_id' => $student->id,
            'category_id' => $category->id,
        ]);
    }
}
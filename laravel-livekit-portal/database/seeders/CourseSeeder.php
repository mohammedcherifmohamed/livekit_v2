<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\Category;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $teacher = Teacher::first();
        $category = Category::first();

        Course::create([
            'teacher_id' => $teacher->id,
            'category_id' => $category->id,
            'title' => 'Laravel Masterclass',
            'description' => 'Complete Laravel course from beginner to advanced.',
            'room_name' => 'laravel-room-1',
            'is_active' => true,
        ]);

        Course::create([
            'teacher_id' => $teacher->id,
            'category_id' => $category->id,
            'title' => 'LiveKit Integration',
            'description' => 'Build real-time apps using LiveKit.',
            'room_name' => 'livekit-room-1',
            'is_active' => true,
        ]);
    }
}
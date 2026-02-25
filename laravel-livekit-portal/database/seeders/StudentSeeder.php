<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        Student::create([
            'name' => 'Ali Student',
            'email' => 'student1@example.com',
            'password' => Hash::make('password'),
            'status' => 'approved',
        ]);

        Student::create([
            'name' => 'Meriem Student',
            'email' => 'student2@example.com',
            'password' => Hash::make('password'),
            'status' => 'approved',
        ]);
    }
}
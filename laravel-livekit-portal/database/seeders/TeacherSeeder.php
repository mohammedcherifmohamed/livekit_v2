<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        Teacher::create([
            'name' => 'John Teacher',
            'email' => 'teacher1@example.com',
            'password' => Hash::make('password'),
            'status' => 'approved',
        ]);

        Teacher::create([
            'name' => 'Sarah Teacher',
            'email' => 'teacher2@example.com',
            'password' => Hash::make('password'),
            'status' => 'approved',
        ]);
    }
}
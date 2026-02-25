<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::updateOrCreate(
            ['slug' => Str::slug('Web Development')],
            [
                'name' => 'Web Development',
                'description' => 'Master modern web technologies including HTML, CSS, JavaScript, and Laravel.',
                'price' => 49.99,
                'image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=800&q=80',
            ]
        );

        Category::updateOrCreate(
            ['slug' => Str::slug('Cyber Security')],
            [
                'name' => 'Cyber Security',
                'description' => 'Learn the principles of network security, ethical hacking, and data protection.',
                'price' => 79.50,
                'image' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=800&q=80',
            ]
        );

        Category::updateOrCreate(
            ['slug' => Str::slug('Artificial Intelligence')],
            [
                'name' => 'Artificial Intelligence',
                'description' => 'Explore machine learning, neural networks, and the future of AI technology.',
                'price' => 99.00,
                'image' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?auto=format&fit=crop&w=800&q=80',
            ]
        );
    }
}
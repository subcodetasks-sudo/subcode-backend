<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Technology',
            ],
            [
                'name' => 'Business',
            ],
            [
                'name' => 'Health',
            ],
            [
                'name' => 'Education',
            ],
            [
                'name' => 'Sports',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
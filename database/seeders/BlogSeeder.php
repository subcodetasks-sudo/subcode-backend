<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Admin;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Admin::first();
        $category = Category::first();

        if (!$admin || !$category) {
            return;
        }

        $blogs = [
            [
                'title' => 'Welcome to Our Blog',
                'slug' => 'welcome-to-our-blog',
                'description' => '<p>This is our first blog post. We are excited to share our thoughts and insights with you.</p><p>Stay tuned for more amazing content!</p>',
                'image' => 'sample-blog-image.jpg',
                'category_id' => $category->id,
                'auther_id' => $admin->id,
                'status' => 'publish',
                'is_active' => true,
                'time_publish' => now(),
                'meta_title' => 'Welcome to Our Blog - Latest News',
                'meta_description' => 'Discover our latest blog posts and insights on various topics.',
            ],
            [
                'title' => 'The Future of Technology',
                'slug' => 'future-of-technology',
                'description' => '<p>Technology is evolving at an unprecedented pace. In this article, we explore what the future holds for technology and how it will impact our daily lives.</p><p>From artificial intelligence to quantum computing, the possibilities are endless.</p>',
                'image' => 'technology-future.jpg',
                'category_id' => $category->id,
                'auther_id' => $admin->id,
                'status' => 'publish',
                'is_active' => true,
                'time_publish' => now()->subDay(),
                'meta_title' => 'The Future of Technology - Innovation Trends',
                'meta_description' => 'Explore the latest technology trends and what the future holds for innovation.',
            ],
            [
                'title' => 'Getting Started with Web Development',
                'slug' => 'getting-started-web-development',
                'description' => '<p>Are you interested in web development? This comprehensive guide will help you get started on your journey.</p><p>We will cover the basics of HTML, CSS, and JavaScript, and provide you with resources to continue learning.</p>',
                'image' => 'web-development.jpg',
                'category_id' => $category->id,
                'auther_id' => $admin->id,
                'status' => 'draft',
                'is_active' => true,
                'time_publish' => now()->addDay(),
                'meta_title' => 'Getting Started with Web Development - Beginner Guide',
                'meta_description' => 'Learn the fundamentals of web development with our comprehensive beginner guide.',
            ],
        ];

        foreach ($blogs as $blog) {
            Blog::create($blog);
        }
    }
}
<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'John Smith',
                'comment' => 'This platform has been incredibly helpful for my business. The insights and resources provided have helped me make better decisions and grow my company significantly.',
                'image' => 'john-smith.jpg',
                'rating' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Sarah Johnson',
                'comment' => 'I love the quality of content on this platform. The articles are well-researched and provide practical value. I have learned so much from reading the posts.',
                'image' => 'sarah-johnson.jpg',
                'rating' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Michael Brown',
                'comment' => 'The technology section is outstanding. The latest trends and insights have kept me ahead of the curve in my industry. Highly recommended!',
                'image' => 'michael-brown.jpg',
                'rating' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Emily Davis',
                'comment' => 'As a developer, I find the technical articles very useful. The tutorials are clear and easy to follow. This platform has become my go-to resource for learning new technologies.',
                'image' => 'emily-davis.jpg',
                'rating' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'David Wilson',
                'comment' => 'The business insights shared here have been invaluable for my startup. The practical advice and real-world examples have helped me avoid common pitfalls.',
                'image' => 'david-wilson.jpg',
                'rating' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Lisa Anderson',
                'comment' => 'I appreciate the diverse range of topics covered. From health and wellness to technology and business, there is something for everyone. Keep up the great work!',
                'image' => 'lisa-anderson.jpg',
                'rating' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
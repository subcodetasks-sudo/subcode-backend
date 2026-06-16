<?php

namespace Database\Seeders;

use App\Models\FQ;
use Illuminate\Database\Seeder;

class FQSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'What is this platform about?',
                'answer' => 'This platform is designed to provide valuable content, insights, and resources to help you stay informed and learn new things. We cover various topics including technology, business, health, education, and more.',
            ],
            [
                'question' => 'How can I contact support?',
                'answer' => 'You can contact our support team through the contact form on our website, or send us an email at support@example.com. We typically respond within 24 hours during business days.',
            ],
            [
                'question' => 'Is the content free to access?',
                'answer' => 'Yes, most of our content is free to access. We believe in providing valuable information to everyone. Some premium content may require registration, but the basic content is available to all visitors.',
            ],
            [
                'question' => 'How often is new content published?',
                'answer' => 'We publish new content regularly, typically 2-3 times per week. You can subscribe to our newsletter to get notified when new articles are published.',
            ],
            [
                'question' => 'Can I contribute to the platform?',
                'answer' => 'We welcome contributions from our community! If you have valuable insights or content to share, please contact us through our contributor form. We review all submissions carefully.',
            ],
            [
                'question' => 'What if I find an error in the content?',
                'answer' => 'We strive for accuracy in all our content. If you find any errors or have suggestions for improvement, please contact us immediately. We appreciate your feedback and will make corrections as needed.',
            ],
        ];

        foreach ($faqs as $faq) {
            FQ::create($faq);
        }
    }
}
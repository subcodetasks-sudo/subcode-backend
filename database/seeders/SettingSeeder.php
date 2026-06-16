<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'site_name' => 'My Blog Platform',
                'site_description' => 'A comprehensive platform for sharing knowledge and insights',
                'site_email' => 'info@example.com',
                'site_phone' => '+1234567890',
                'site_address' => '123 Main Street, City, Country',
                'facebook' => 'https://facebook.com/example',
                'twitter' => 'https://twitter.com/example',
                'instagram' => 'https://instagram.com/example',
                'linkedin' => 'https://linkedin.com/company/example',
                'youtube' => 'https://youtube.com/example',
                'tiktok' => 'https://tiktok.com/@example',
                'snapchat' => 'https://snapchat.com/add/example',
                'pinterest' => 'https://pinterest.com/example',
                'whatsapp' => '+1234567890',
                'telegram' => '@example',
                'terms_conditions' => 'Terms and conditions content here...',
                'privacy_policy' => 'Privacy policy content here...',
                'refund_policy' => 'Refund policy content here...',
                'about_us' => 'About us content here...',
                'contact_info' => 'Contact information here...',
                'meta_keywords' => 'blog, technology, business, health, education',
                'meta_description' => 'A comprehensive platform for sharing knowledge and insights on various topics',
                'google_analytics' => 'GA_TRACKING_ID',
                'facebook_pixel' => 'FB_PIXEL_ID',
                'currency' => 'USD',
                'timezone' => 'UTC',
                'language' => 'en',
                'maintenance_mode' => false,
            ],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
<?php

namespace Database\Seeders;

use App\Models\SeoSetting;
use Illuminate\Database\Seeder;

class SeoSettingSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            ['page_key' => 'home', 'page_name' => ['ar' => 'الرئيسية', 'en' => 'Home', 'tr' => 'Ana Sayfa']],
            ['page_key' => 'about', 'page_name' => ['ar' => 'من نحن', 'en' => 'About Us', 'tr' => 'Hakkımızda']],
            ['page_key' => 'services', 'page_name' => ['ar' => 'خدماتنا', 'en' => 'Services', 'tr' => 'Hizmetler']],
            ['page_key' => 'projects', 'page_name' => ['ar' => 'مشاريعنا', 'en' => 'Projects', 'tr' => 'Projeler']],
            ['page_key' => 'websites', 'page_name' => ['ar' => 'مواقعنا', 'en' => 'Websites', 'tr' => 'Web Siteleri']],
            ['page_key' => 'packages', 'page_name' => ['ar' => 'الباقات', 'en' => 'Packages', 'tr' => 'Paketler']],
            ['page_key' => 'blogs', 'page_name' => ['ar' => 'المدونة', 'en' => 'Blog', 'tr' => 'Blog']],
            ['page_key' => 'contact', 'page_name' => ['ar' => 'تواصل معنا', 'en' => 'Contact', 'tr' => 'İletişim']],
            ['page_key' => 'terms', 'page_name' => ['ar' => 'الشروط والأحكام', 'en' => 'Terms & Conditions', 'tr' => 'Şartlar ve Koşullar']],
            ['page_key' => 'privacy', 'page_name' => ['ar' => 'سياسة الخصوصية', 'en' => 'Privacy Policy', 'tr' => 'Gizlilik Politikası']],
            ['page_key' => 'faqs', 'page_name' => ['ar' => 'الأسئلة الشائعة', 'en' => 'FAQs', 'tr' => 'SSS']],
            ['page_key' => 'team', 'page_name' => ['ar' => 'فريق العمل', 'en' => 'Our Team', 'tr' => 'Ekibimiz']],
        ];

        foreach ($pages as $page) {
            SeoSetting::query()->firstOrCreate(
                ['page_key' => $page['page_key']],
                ['page_name' => $page['page_name']]
            );
        }
    }
}

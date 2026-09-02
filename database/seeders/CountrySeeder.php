<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            [
                'code' => 'ae',
                'name' => [
                    'ar' => 'الإمارات',
                    'en' => 'United Arab Emirates',
                    'tr' => 'Birleşik Arap Emirlikleri',
                ],
            ],
            [
                'code' => 'eg',
                'name' => [
                    'ar' => 'مصر',
                    'en' => 'Egypt',
                    'tr' => 'Mısır',
                ],
            ],
            [
                'code' => 'tr',
                'name' => [
                    'ar' => 'تركيا',
                    'en' => 'Turkey',
                    'tr' => 'Türkiye',
                ],
            ],
            [
                'code' => 'sa',
                'name' => [
                    'ar' => 'السعودية',
                    'en' => 'Saudi Arabia',
                    'tr' => 'Suudi Arabistan',
                ],
            ],
        ];

        foreach ($countries as $country) {
            Country::query()->updateOrCreate(
                ['code' => $country['code']],
                [
                    'name' => $country['name'],
                    'is_active' => true,
                ],
            );
        }
    }
}

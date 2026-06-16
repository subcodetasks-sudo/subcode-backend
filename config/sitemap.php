<?php

return [
    'frontend_url' => rtrim(env('FRONTEND_URL', env('APP_URL', 'http://localhost')), '/'),

    'locales' => ['ar', 'en', 'tr'],

    'static_pages' => [
        ['path' => '', 'changefreq' => 'daily', 'priority' => '1.0'],
        ['path' => 'about', 'changefreq' => 'monthly', 'priority' => '0.8'],
        ['path' => 'services', 'changefreq' => 'weekly', 'priority' => '0.9'],
        ['path' => 'projects', 'changefreq' => 'daily', 'priority' => '0.9'],
        ['path' => 'websites', 'changefreq' => 'daily', 'priority' => '0.9'],
        ['path' => 'packages', 'changefreq' => 'weekly', 'priority' => '0.9'],
        ['path' => 'blogs', 'changefreq' => 'daily', 'priority' => '0.9'],
        ['path' => 'contact', 'changefreq' => 'monthly', 'priority' => '0.8'],
        ['path' => 'faqs', 'changefreq' => 'weekly', 'priority' => '0.8'],
        ['path' => 'team', 'changefreq' => 'monthly', 'priority' => '0.7'],
        ['path' => 'terms', 'changefreq' => 'yearly', 'priority' => '0.5'],
        ['path' => 'privacy', 'changefreq' => 'yearly', 'priority' => '0.5'],
    ],
];

<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@gmail.com',

                'phone' => '+1234567890',
                'password' => Hash::make('12345678'),
                'is_active' => true,
                'role' => 'super_admin',
            ],
            // [
            //     'name' => 'Content Manager',
            //     'email' => 'content@example.com',
            //     'phone' => '+1234567891',
            //     'role' => 'content_manager',
            //     'password' => Hash::make('password'),
            //     'is_active' => true,
            // ],
            // [
            //     'name' => 'Editor',
            //     'email' => 'editor@example.com',
            //     'phone' => '+1234567892',
            //     'password' => Hash::make('password'),
            //     'is_active' => true,
            // ],
        ];

        foreach ($admins as $admin) {
            Admin::create($admin);
        }
    }
}
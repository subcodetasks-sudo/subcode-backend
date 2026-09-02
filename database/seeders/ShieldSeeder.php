<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        Artisan::call('shield:generate', [
            '--all' => true,
            '--panel' => 'admin',
            '--option' => 'permissions',
            '--no-interaction' => true,
        ]);

        $admin = Admin::query()->where('email', 'admin@gmail.com')->first();

        if ($admin) {
            Artisan::call('shield:super-admin', [
                '--user' => $admin->id,
                '--panel' => 'admin',
                '--no-interaction' => true,
            ]);
        }
    }
}

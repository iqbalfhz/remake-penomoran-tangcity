<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            DepartemenSeeder::class,
            JenisSuratSeeder::class,
            PerihalSeeder::class,
            AdminUserSeeder::class,
        ]);

        // Generate Shield permissions & policies untuk semua Resources
        Artisan::call('shield:generate', [
            '--all' => true,
            '--panel' => 'admin',
            '--option' => 'policies_and_permissions',
            '--ignore-existing-policies' => true,
        ]);

        $this->call([
            PermissionSeeder::class,
        ]);
    }
}

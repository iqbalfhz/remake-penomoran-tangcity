<?php

namespace Database\Seeders;

use App\Models\Departemen;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $itDept = Departemen::where('kode', 'IT')->first();

        $admin = User::firstOrCreate(
            ['email' => 'admin@tangcity.com'],
            [
                'name'          => 'Super Admin',
                'username'      => 'admin',
                'password'      => Hash::make(env('ADMIN_PASSWORD', 'ChangeMe@2026!')),
                'departemen_id' => $itDept?->id,
            ]
        );

        $admin->assignRole('super_admin');
    }
}

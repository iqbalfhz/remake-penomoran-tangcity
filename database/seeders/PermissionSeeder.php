<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Hapus permissions lama (format snake_case) yang digantikan oleh Shield
        $oldPermissions = [
            'view_any_departemen', 'create_departemen', 'update_departemen', 'delete_departemen',
            'view_any_jenis_surat', 'create_jenis_surat', 'update_jenis_surat', 'delete_jenis_surat',
            'view_any_perihal', 'create_perihal', 'update_perihal', 'delete_perihal',
            'view_any_user', 'create_user', 'update_user', 'delete_user',
            'view_any_dokumen', 'create_dokumen', 'update_dokumen', 'delete_dokumen',
            'view_any_role', 'create_role', 'update_role', 'delete_role',
            'view_any_permission', 'create_permission', 'update_permission', 'delete_permission',
            'view_any_activity_log', 'delete_activity_log',
        ];
        Permission::whereIn('name', $oldPermissions)->delete();

        // Ambil semua permissions Shield yang sudah di-generate
        $allPermissions = Permission::all();

        // super_admin mendapat semua permission (akses penuh via database, tanpa bypass kode)
        $superAdminRole = Role::where('name', 'super_admin')->first();
        if ($superAdminRole) {
            $superAdminRole->syncPermissions($allPermissions);
        }

        // Role 'user' hanya bisa melihat & membuat dokumen
        $userRole = Role::where('name', 'user')->first();
        if ($userRole) {
            $userRole->syncPermissions(
                Permission::whereIn('name', [
                    'ViewAny:Dokumen',
                    'View:Dokumen',
                    'Create:Dokumen',
                    'Update:Dokumen',
                ])->get()
            );
        }
    }
}

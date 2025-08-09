<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Buat Permissions
        $permissions = [
            // User Management
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
            // Role Management
            'view-roles',
            'create-roles',
            'edit-roles',
            'delete-roles',
            'assign-roles-to-users',
            // Settings
            'view-settings',
            'edit-settings',
            // Profile
            'view-own-profile',
            'edit-own-profile',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 3. Buat Roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $adminRole      = Role::firstOrCreate(['name' => 'admin']);
        $userRole       = Role::firstOrCreate(['name' => 'user']);

        // 4. Berikan Permissions ke Roles
        // Role -> Admin: bisa mengelola semua data operasional
        $adminRole->givePermissionTo([
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
            'view-settings',
            'edit-settings',
            'view-own-profile',
            'edit-own-profile',
        ]);

        // Role -> User: peran dasar, hanya bisa melihat
        $userRole->givePermissionTo([
            'view-own-profile',
            'edit-own-profile',
        ]);

        // Note: super-admin tidak perlu diberi permission di sini,
        // karena kita akan menggunakan Gate::before() di AuthServiceProvider
        // yang akan memberinya semua akses secara otomatis.
    }
}

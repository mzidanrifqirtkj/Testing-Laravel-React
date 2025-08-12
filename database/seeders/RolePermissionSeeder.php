<?php
// database/seeders/RoleSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permission groups
        $permissionGroups = [
            'products' => [
                'view products',
                'create products',
                'edit products',
                'delete products',
                'manage inventory',
            ],
            'users' => [
                'view users',
                'create users',
                'edit users',
                'delete users',
                'assign roles',
            ],
            'orders' => [
                'view orders',
                'create orders',
                'edit orders',
                'delete orders',
                'process orders',
            ],
            'cart' => [
                'manage own cart',
                'view own orders',
            ],
            'system' => [
                'access admin panel',
                'view analytics',
                'manage settings',
            ],
            'shop' => [
                'view shop',
                'purchase products',
            ],
        ];

        // Create permissions
        foreach ($permissionGroups as $group => $permissions) {
            foreach ($permissions as $permission) {
                Permission::create([
                    'name' => $permission,
                    'guard_name' => 'web',
                ]);
            }
        }

        // Create roles and assign permissions

        // Super Admin Role (has all permissions)
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $superAdminRole->givePermissionTo(Permission::all());

        // Admin Role (most permissions except super admin stuff)
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'view products',
            'create products',
            'edit products',
            'delete products',
            'manage inventory',
            'view users',
            'edit users',
            'view orders',
            'create orders',
            'edit orders',
            'process orders',
            'access admin panel',
            'view analytics',
            'view shop',
            'purchase products',
            'manage own cart',
            'view own orders',
        ]);

        // User Role (customer permissions)
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo([
            'view shop',
            'purchase products',
            'manage own cart',
            'view own orders',
        ]);

        // Guest Role (minimal permissions - for reference)
        $guestRole = Role::create(['name' => 'guest']);
        $guestRole->givePermissionTo([
            'view shop',
        ]);

        // Create users and assign roles

        // Super Admin User
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
        $superAdmin->assignRole('super-admin');

        // Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
        $admin->assignRole('admin');

        // Regular User
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
        $user->assignRole('user');

        // Test User 2
        $user2 = User::create([
            'name' => 'Zidan',
            'email' => 'zidan@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
        $user2->assignRole('user');
    }
}

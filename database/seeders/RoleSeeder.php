<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $roles = [
            'super-admin',
            'national-admin',
            'province-admin',
            'regency-admin',
            'district-admin',
            'member',
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        // Create permissions (optional for now, can be added later)
        // Permission::create(['name' => 'edit articles']);
    }
}

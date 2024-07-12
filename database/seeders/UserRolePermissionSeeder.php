<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Permissions
        $permissions = [
            'create role', 'view role', 'update role', 'delete role',
            'create permission', 'view permission', 'update permission', 'delete permission',
            'view user', 'update user', 'delete user',
            'createProduct', 'viewProduct', 'updateProduct', 'DeleteProduct',
            'edit user', 'setUser', 'setPermission', 'setRole'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create Roles
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Assign permissions to roles
        $superAdminRole->givePermissionTo(Permission::all());
        $adminRole->givePermissionTo(['view role', 'view permission', 'update permission', 'view user', 'update user']);
        $userRole->givePermissionTo(['update permission', 'setUser', 'setPermission', 'setRole']);

        // Create Users
        $superAdminUser = User::firstOrCreate([
            'email' => 'admin@admin',
        ], [
            'name' => 'aomsin',
            'email' => 'admin@admin',
            'password' => Hash::make('12345678'),
            'role' => 'User',
        ]);

        $superAdminUser->assignRole($superAdminRole);

        $adminUser = User::firstOrCreate([
            'email' => 'fernzy123@gmail.com',
        ], [
            'name' => 'Ferndre',
            'email' => 'fernzy123@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'User',
        ]);

        $adminUser->assignRole($adminRole);

        $userUser = User::firstOrCreate([
            'email' => 'fernzy123sss@gmail.com',
        ], [
            'name' => 'ssss',
            'email' => 'fernzy123sss@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'User',
        ]);

        $userUser->assignRole($userRole);
    }
}

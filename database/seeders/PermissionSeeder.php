<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Admin role
        // AuthServiceProvider içindeki Gate::before rule; kodu ile tüm permissionlara otomatik erişim sağlar.
        $role1 = Role::create(['name' => 'admin']);

        // All permissions
        $permissions = [
            // posts permissions
            'list-posts',
            'create-post',
            'show-post',
            'update-post',
            'delete-post',

            // authors permissions
            'list-authors',
            'create-author',
            'show-author',
            'update-author',
            'delete-author',

            // categories permissions
            'list-categories',
            'create-category',
            'show-category',
            'update-category',
            'delete-category',

            // tags permissions
            'list-tags',
            'create-tag',
            'show-tag',
            'update-tag',
            'delete-tag',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $user = User::where('id',1)->first();
        $user->assignRole($role1);

        // -------------------------------------------------------------------------------------------------------------

        // Manager role
        $role2 = Role::create(['name' => 'editor']);

        // Manager permissions
        $permissions = [
            // posts permissions
            'list-posts',
            'create-post',
            'show-post',
            'update-post',
            'delete-post',

            // authors permissions
            'list-authors',
            'create-author',
            'show-author',
            'update-author',
            'delete-author',
        ];

        foreach ($permissions as $permission) {
            $role2->givePermissionTo($permission);
        }

        $user = User::where('id',2)->first();
        $user->assignRole($role2);

        // -------------------------------------------------------------------------------------------------------------

        // Editor role
        $role3 = Role::create(['name' => 'member']);

        // Editor permissions
        $permissions = [
            // posts permissions
            'list-posts',
            'create-post',
            'show-post',
            'update-post',
            'delete-post',
        ];

        foreach ($permissions as $permission) {
            $role3->givePermissionTo($permission);
        }

        $user = User::where('id',3)->first();
        $user->assignRole($role3);
    }
}

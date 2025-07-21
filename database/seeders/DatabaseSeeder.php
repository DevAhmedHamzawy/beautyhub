<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Str;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(1)->create();

        $admin = Admin::updateOrCreate(['id' => 1], [
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'active' => rand(0, 1),
            'remember_token' => Str::random(10),
            'deleted_at' => null
        ]);

        $role = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'admin', 'active' => 1]);

        Permission::create(['name' => 'add_admin', 'guard_name' => 'admin', 'group_name' => 'Admins']);
        $role->givePermissionTo('add_admin');
        Permission::create(['name' => 'edit_admin', 'guard_name' => 'admin', 'group_name' => 'Admins']);
        $role->givePermissionTo('edit_admin');
        Permission::create(['name' => 'delete_admin', 'guard_name' => 'admin', 'group_name' => 'Admins']);
        $role->givePermissionTo('delete_admin');
        Permission::create(['name' => 'view_admin', 'guard_name' => 'admin', 'group_name' => 'Admins']);
        $role->givePermissionTo('view_admin');
        Permission::create(['name' => 'active_admin', 'guard_name' => 'admin', 'group_name' => 'Admins']);
        $role->givePermissionTo('active_admin');
        Permission::create(['name' => 'restore_admin', 'guard_name' => 'admin', 'group_name' => 'Admins']);
        $role->givePermissionTo('restore_admin');
        Permission::create(['name' => 'add_user', 'guard_name' => 'admin', 'group_name' => 'Users']);
        $role->givePermissionTo('add_user');
        Permission::create(['name' => 'edit_user', 'guard_name' => 'admin', 'group_name' => 'Users']);
        $role->givePermissionTo('edit_user');
        Permission::create(['name' => 'delete_user', 'guard_name' => 'admin', 'group_name' => 'Users']);
        $role->givePermissionTo('delete_user');
        Permission::create(['name' => 'view_user', 'guard_name' => 'admin', 'group_name' => 'Users']);
        $role->givePermissionTo('view_user');
        Permission::create(['name' => 'active_user', 'guard_name' => 'admin', 'group_name' => 'Users']);
        $role->givePermissionTo('active_user');
        Permission::create(['name' => 'restore_user', 'guard_name' => 'admin', 'group_name' => 'Users']);
        $role->givePermissionTo('restore_user');
        Permission::create(['name' => 'add_role', 'guard_name' => 'admin', 'group_name' => 'Roles']);
        $role->givePermissionTo('add_role');
        Permission::create(['name' => 'edit_role', 'guard_name' => 'admin', 'group_name' => 'Roles']);
        $role->givePermissionTo('edit_role');
        Permission::create(['name' => 'delete_role', 'guard_name' => 'admin', 'group_name' => 'Roles']);
        $role->givePermissionTo('delete_role');
        Permission::create(['name' => 'view_role', 'guard_name' => 'admin', 'group_name' => 'Roles']);
        $role->givePermissionTo('view_role');
        Permission::create(['name' => 'active_role', 'guard_name' => 'admin', 'group_name' => 'Roles']);
        $role->givePermissionTo('active_role');
        Permission::create(['name' => 'restore_role', 'guard_name' => 'admin', 'group_name' => 'Roles']);
        $role->givePermissionTo('restore_role');
        Permission::create(['name' => 'add_category', 'guard_name' => 'admin', 'group_name' => 'Category']);
        $role->givePermissionTo('add_category');
        Permission::create(['name' => 'edit_category', 'guard_name' => 'admin', 'group_name' => 'Category']);
        $role->givePermissionTo('edit_category');
        Permission::create(['name' => 'delete_category', 'guard_name' => 'admin', 'group_name' => 'Category']);
        $role->givePermissionTo('delete_category');
        Permission::create(['name' => 'view_category', 'guard_name' => 'admin', 'group_name' => 'Category']);
        $role->givePermissionTo('view_category');
        Permission::create(['name' => 'active_category', 'guard_name' => 'admin', 'group_name' => 'Category']);
        $role->givePermissionTo('active_category');
        Permission::create(['name' => 'restore_category', 'guard_name' => 'admin', 'group_name' => 'Category']);
        $role->givePermissionTo('restore_category');
        Permission::create(['name' => 'add_home_category', 'guard_name' => 'admin', 'group_name' => 'Category']);
        $role->givePermissionTo('add_home_category');
        Permission::create(['name' => 'add_tax', 'guard_name' => 'admin', 'group_name' => 'Tax']);
        $role->givePermissionTo('add_tax');
        Permission::create(['name' => 'edit_tax', 'guard_name' => 'admin', 'group_name' => 'Tax']);
        $role->givePermissionTo('edit_tax');
        Permission::create(['name' => 'delete_tax', 'guard_name' => 'admin', 'group_name' => 'Tax']);
        $role->givePermissionTo('delete_tax');
        Permission::create(['name' => 'view_tax', 'guard_name' => 'admin', 'group_name' => 'Tax']);
        $role->givePermissionTo('view_tax');
        Permission::create(['name' => 'active_tax', 'guard_name' => 'admin', 'group_name' => 'Tax']);
        $role->givePermissionTo('active_tax');
        Permission::create(['name' => 'restore_tax', 'guard_name' => 'admin', 'group_name' => 'Tax']);
        $role->givePermissionTo('restore_tax');
        Permission::create(['name' => 'add_brand', 'guard_name' => 'admin', 'group_name' => 'Brand']);
        $role->givePermissionTo('add_brand');
        Permission::create(['name' => 'edit_brand', 'guard_name' => 'admin', 'group_name' => 'Brand']);
        $role->givePermissionTo('edit_brand');
        Permission::create(['name' => 'delete_brand', 'guard_name' => 'admin', 'group_name' => 'Brand']);
        $role->givePermissionTo('delete_brand');
        Permission::create(['name' => 'view_brand', 'guard_name' => 'admin', 'group_name' => 'Brand']);
        $role->givePermissionTo('view_brand');
        Permission::create(['name' => 'active_brand', 'guard_name' => 'admin', 'group_name' => 'Brand']);
        $role->givePermissionTo('active_brand');
        Permission::create(['name' => 'restore_brand', 'guard_name' => 'admin', 'group_name' => 'Brand']);
        $role->givePermissionTo('restore_brand');
        Permission::create(['name' => 'add_unit', 'guard_name' => 'admin', 'group_name' => 'Unit']);
        $role->givePermissionTo('add_unit');
        Permission::create(['name' => 'edit_unit', 'guard_name' => 'admin', 'group_name' => 'Unit']);
        $role->givePermissionTo('edit_unit');
        Permission::create(['name' => 'delete_unit', 'guard_name' => 'admin', 'group_name' => 'Unit']);
        $role->givePermissionTo('delete_unit');
        Permission::create(['name' => 'view_unit', 'guard_name' => 'admin', 'group_name' => 'Unit']);
        $role->givePermissionTo('view_unit');
        Permission::create(['name' => 'active_unit', 'guard_name' => 'admin', 'group_name' => 'Unit']);
        $role->givePermissionTo('active_unit');
        Permission::create(['name' => 'restore_unit', 'guard_name' => 'admin', 'group_name' => 'Unit']);
        $role->givePermissionTo('restore_unit');
        Permission::create(['name' => 'add_attribute', 'guard_name' => 'admin', 'group_name' => 'Attribute']);
        $role->givePermissionTo('add_attribute');
        Permission::create(['name' => 'edit_attribute', 'guard_name' => 'admin', 'group_name' => 'Attribute']);
        $role->givePermissionTo('edit_attribute');
        Permission::create(['name' => 'delete_attribute', 'guard_name' => 'admin', 'group_name' => 'Attribute']);
        $role->givePermissionTo('delete_attribute');
        Permission::create(['name' => 'view_attribute', 'guard_name' => 'admin', 'group_name' => 'Attribute']);
        $role->givePermissionTo('view_attribute');
        Permission::create(['name' => 'active_attribute', 'guard_name' => 'admin', 'group_name' => 'Attribute']);
        $role->givePermissionTo('active_attribute');
        Permission::create(['name' => 'restore_attribute', 'guard_name' => 'admin', 'group_name' => 'Attribute']);
        $role->givePermissionTo('restore_attribute');
        Permission::create(['name' => 'add_supplier', 'guard_name' => 'admin', 'group_name' => 'Supplier']);
        $role->givePermissionTo('add_supplier');
        Permission::create(['name' => 'edit_supplier', 'guard_name' => 'admin', 'group_name' => 'Supplier']);
        $role->givePermissionTo('edit_supplier');
        Permission::create(['name' => 'delete_supplier', 'guard_name' => 'admin', 'group_name' => 'Supplier']);
        $role->givePermissionTo('delete_supplier');
        Permission::create(['name' => 'view_supplier', 'guard_name' => 'admin', 'group_name' => 'Supplier']);
        $role->givePermissionTo('view_supplier');
        Permission::create(['name' => 'active_supplier', 'guard_name' => 'admin', 'group_name' => 'Supplier']);
        $role->givePermissionTo('active_supplier');
        Permission::create(['name' => 'restore_supplier', 'guard_name' => 'admin', 'group_name' => 'Supplier']);
        $role->givePermissionTo('restore_supplier');
        Permission::create(['name' => 'add_country', 'guard_name' => 'admin', 'group_name' => 'Country']);
        $role->givePermissionTo('add_country');
        Permission::create(['name' => 'edit_country', 'guard_name' => 'admin', 'group_name' => 'Country']);
        $role->givePermissionTo('edit_country');
        Permission::create(['name' => 'delete_country', 'guard_name' => 'admin', 'group_name' => 'Country']);
        $role->givePermissionTo('delete_country');
        Permission::create(['name' => 'view_country', 'guard_name' => 'admin', 'group_name' => 'Country']);
        $role->givePermissionTo('view_country');
        Permission::create(['name' => 'restore_country', 'guard_name' => 'admin', 'group_name' => 'Country']);
        $role->givePermissionTo('restore_country');
        Permission::create(['name' => 'view_activity_log', 'guard_name' => 'admin', 'group_name' => 'activity_logs']);
        $role->givePermissionTo('view_activity_log');

        $admin->assignRole($role);
    }
}

<?php

use App\Role;
use App\Permission;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /// Module
        $moduleId = DB::table('modules')->insertGetId([
            'display_name' => 'Profil',
            'name' => 'profile',
        ]);

        // Permissions
        DB::table('permissions')->insert([
            [
                'display_name' => 'Papar Profile',
                'name' => 'read-profile',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'display_name' => 'Kemaskini Profile',
                'name' => 'update-profile',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'display_name' => 'Kemaskini Kata Laluan',
                'name' => 'update-profile-password',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ]
        ]);

        // Assign permissions to super-admin role
        $admin = Role::findByName('super-admin');
        $admin->givePermissionTo(Permission::all());
    }
}

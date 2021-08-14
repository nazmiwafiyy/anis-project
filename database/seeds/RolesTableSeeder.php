<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Module
        $moduleId = DB::table('modules')->insertGetId([
            'name' => 'roles',
            'display_name' => 'Peranan',
        ]);

        // Permissions
        DB::table('permissions')->insert([
            [
                'display_name' => 'Cipta Peranan',
                'name' => 'create-roles',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'display_name' => 'Papar Peranan',
                'name' => 'read-roles',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'display_name' => 'Kemaskini Peranan',
                'name' => 'update-roles',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'display_name' => 'Padam Peranan',
                'name' => 'delete-roles',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
        ]);

        // Create default roles
        $superAdmin = Role::create([
            'name' => 'super-admin',
            'display_name' => 'Super Admin'
        ]);
        $admin = Role::create([
            'name' => 'admin',
            'display_name' => 'Admin'
        ]);

        $user = Role::create([
            'name' => 'user',
            'display_name' => 'Ahli Kelab JKMM'
        ]);

        $membershipBureau = Role::create([
            'name' => 'membership-bureau',
            'display_name' => 'Biro Keahlian Kelab JKMM'
        ]);

        $headDepartmentApproval = Role::create([
            'name' => 'head-department',
            'display_name' => 'Ketua Jabatan'
        ]);

        $welfareSocialBureaus = Role::create([
            'name' => 'welfare-social-bureaus',
            'display_name' => 'Biro Kebajikan dan Sosial Kelab JKMM'
        ]);

        $secretarySportsWelfare  = Role::create([
            'name' => 'secretary-sports-welfare',
            'display_name' => 'Setiausaha / Penolong Setiausha Kelab Sukan dan Kebajikan Kelab JKMM'
        ]);

        $treasurer = Role::create([
            'name' => 'treasurer',
            'display_name' => 'Bendahari / Penolong Bendahari Kelab JKMM'
        ]);

        // Assign permissions
        $superAdmin = Role::findByName('super-admin');
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::findByName('admin');
        $admin->givePermissionTo(['read-roles']);
    }
}

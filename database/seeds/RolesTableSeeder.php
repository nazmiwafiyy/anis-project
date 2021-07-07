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
            'display_name' => 'Pengguna biasa'
        ]);

        $headDepartmentApproval = Role::create([
            'name' => 'approval-head-department',
            'display_name' => 'Meluluskan(Ketua Jabatan)'
        ]);

        $welfareSocialBureaus = Role::create([
            'name' => 'approval-welfare-social-bureaus',
            'display_name' => 'Meluluskan(Biro Kebajikan dan Sosial)'
        ]);

        $secretarySportsWelfare  = Role::create([
            'name' => 'approval-secretary-sports-welfare',
            'display_name' => 'Meluluskan(Setiausaha / Penolong Setiausha Kelab Sukan dan Kebajikan JKMM)'
        ]);

        $treasurer = Role::create([
            'name' => 'approval-treasurer',
            'display_name' => 'Meluluskan(Bendahari / Penolong Bendahari)'
        ]);

        // Assign permissions
        $superAdmin = Role::findByName('super-admin');
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::findByName('admin');
        $admin->givePermissionTo(['read-roles']);
    }
}

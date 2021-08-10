<?php

use App\Role;
use App\Permission;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
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
            'display_name' => 'Permohonan',
            'name' => 'application',
        ]);

        // Permissions
        DB::table('permissions')->insert([
            [
                'display_name' => 'Cipta Permohonan',
                'name' => 'create-application',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'display_name' => 'Papar Permohonan',
                'name' => 'read-application',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            // [
            //     'display_name' => 'Kemaskini Permohonan',
            //     'name' => 'update-application',
            //     'guard_name' => 'web',
            //     'module_id' => $moduleId
            // ],
            [
                'display_name' => 'Padam Permohonan',
                'name' => 'delete-application',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'display_name' => 'Meluluskan(Ketua Jabatan)',
                'name' => 'approval-head-department',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'display_name' => 'Meluluskan(Biro Kebajikan dan Sosial)',
                'name' => 'approval-welfare-social-bureaus',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'display_name' => 'Meluluskan(Setiausaha / Penolong Setiausha Kelab Sukan dan Kebajikan JKMM)',
                'name' => 'approval-secretary-sports-welfare',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'display_name' => 'Meluluskan(Bendahari / Penolong Bendahari)',
                'name' => 'approval-treasurer',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'display_name' => 'Meluluskan(Papar)',
                'name' => 'read-approval',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'display_name' => 'Meluluskan(Padam)',
                'name' => 'delete-approval',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
        ]);

        // Assign permissions
        $superAdmin = Role::findByName('super-admin');
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::findByName('admin');
        $admin->givePermissionTo(['create-application','read-application','delete-application','read-approval']);

        $user = Role::findByName('user');
        $user->givePermissionTo(['create-application','read-application','delete-application']);

        $headDepartmentApproval = Role::findByName('approval-head-department');
        $headDepartmentApproval->givePermissionTo('approval-head-department','read-approval');

        $welfareSocialBureaus = Role::findByName('approval-welfare-social-bureaus');
        $welfareSocialBureaus->givePermissionTo('approval-welfare-social-bureaus','read-approval');

        $secretarySportsWelfare = Role::findByName('approval-secretary-sports-welfare');
        $secretarySportsWelfare->givePermissionTo('approval-secretary-sports-welfare','read-approval');

        $treasurer = Role::findByName('approval-treasurer');
        $treasurer->givePermissionTo('approval-treasurer','read-approval');
    }
}

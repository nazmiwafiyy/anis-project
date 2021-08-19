<?php

use App\Role;
use App\Permission;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
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
            'display_name' => 'Laporan',
            'name' => 'report',
        ]);

        // Permissions
        DB::table('permissions')->insert([
            [
                'display_name' => 'Pengguna Sistem',
                'name' => 'users-report',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'display_name' => 'Permohonan Disahkan',
                'name' => 'confirmed-application-report',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'display_name' => 'Permohonan Tidak Disahkan',
                'name' => 'unconfirmed-application-report',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'display_name' => 'Permohonan Disokong',
                'name' => 'supported-application-report',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'display_name' => 'Permohonan Tidak Disokong',
                'name' => 'unsupported-application-report',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'display_name' => 'Permohonan Diluluskan',
                'name' => 'approved-application-report',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'display_name' => 'Permohonan Tidak Diluluskan',
                'name' => 'rejected-application-report',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'display_name' => 'Permohonan Telah menerima Bayaran',
                'name' => 'paid-application-report',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
        ]);

        // Assign permissions
        $superAdmin = Role::findByName('super-admin');
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::findByName('admin');
        $admin->givePermissionTo(['users-report','confirmed-application-report','unconfirmed-application-report','supported-application-report','unsupported-application-report','approved-application-report','rejected-application-report','paid-application-report']);
        
        $membershipBureau = Role::findByName('membership-bureau');
        $membershipBureau->givePermissionTo('users-report');

        $headDepartment = Role::findByName('head-department');
        $headDepartment->givePermissionTo('confirmed-application-report','unconfirmed-application-report');

        $welfareSocialBureaus = Role::findByName('welfare-social-bureaus');
        $welfareSocialBureaus->givePermissionTo('supported-application-report','unsupported-application-report');

        $secretarySportsWelfare = Role::findByName('secretary-sports-welfare');
        $secretarySportsWelfare->givePermissionTo('approved-application-report','rejected-application-report');

        $treasurer = Role::findByName('treasurer');
        $treasurer->givePermissionTo('paid-application-report');
    }
}

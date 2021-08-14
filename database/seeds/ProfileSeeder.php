<?php

use App\Role;
use App\Profile;
use Faker\Factory;
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

        $admin = Role::findByName('admin');
        $admin->givePermissionTo(['read-profile','update-profile','update-profile-password']);
        
        $user = Role::findByName('user');
        $user->givePermissionTo(['read-profile','update-profile','update-profile-password']);

        
        $headDepartmentApproval = Role::findByName('head-department');
        $headDepartmentApproval->givePermissionTo(['read-profile','update-profile','update-profile-password']);

        $welfareSocialBureaus = Role::findByName('welfare-social-bureaus');
        $welfareSocialBureaus->givePermissionTo(['read-profile','update-profile','update-profile-password']);

        $secretarySportsWelfare = Role::findByName('secretary-sports-welfare');
        $secretarySportsWelfare->givePermissionTo(['read-profile','update-profile','update-profile-password']);

        $treasurer = Role::findByName('treasurer');
        $treasurer->givePermissionTo(['read-profile','update-profile','update-profile-password']);

        $faker = Factory::create('ms_MY');
        foreach (Profile::all()->except(1) as $profile) {
            $profile->fullname = $faker->name('male');
            $profile->identity_no = $faker->myKadNumber('male',true);
            $profile->phone_no = $faker->mobileNumber(false,false);
            $profile->position_id = DB::table('positions')->inRandomOrder()->first()->id;
            $profile->department_id =  DB::table('departments')->inRandomOrder()->first()->id;
            $profile->save();
        }
    }
}

<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersTableSeeder extends Seeder
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
            'name' => 'users',
            'display_name' => 'Pengguna',
        ]);

        // Permissions
        DB::table('permissions')->insert([
            [
                'name' => 'read-users',
                'display_name' => 'Papar Pengguna',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'create-users',
                'display_name' => 'Cipta Pengguna',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'update-users',
                'display_name' => 'Kemaskini Pengguna',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'delete-users',
                'display_name' => 'Padam Pengguna',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ]
        ]);

        // Assign permissions to admin role
        $admin = Role::findByName('super-admin');
        $admin->givePermissionTo(Permission::all());


        // Create default super-admin
        $superAdmin = \App\User::create([
            'name' => 'Super Admin',
            'email' => 'su@localhost.com',
            'password' => bcrypt('password'),
            'avatar' => 'avatar.png'
        ]);
        $superAdmin->assignRole('super-admin');
        $avatar = Avatar::create($superAdmin->name)->getImageObject()->encode('png');
        Storage::disk('public')->put('avatars/'.$superAdmin->id.'/avatar.png', (string) $avatar);
        $superAdminProfile = \App\Profile::create([
            'fullname' => 'System Super Admin',
            'user_id'  => $superAdmin->id
        ]);

        // Create demo admin
        $admin = \App\User::create([
            'name' => 'Demo Admin',
            'email' => 'admin@localhost.com',
            'password' => bcrypt('password'),
            'avatar' => 'avatar.png'
        ]);
        $admin->assignRole('admin');
        $avatar = Avatar::create($admin->name)->getImageObject()->encode('png');
        Storage::disk('public')->put('avatars/'.$admin->id.'/avatar.png', (string) $avatar);
        $adminProfile = \App\Profile::create([
            'fullname' => 'Test Admin',
            'user_id'  => $admin->id
        ]);

        // Create demo user
        $user = \App\User::create([
            'name' => 'Demo User',
            'email' => 'user@localhost.com',
            'password' => bcrypt('password'),
            'avatar' => 'avatar.png'
        ]);
        $user->assignRole('user');
        $avatar = Avatar::create($user->name)->getImageObject()->encode('png');
        Storage::disk('public')->put('avatars/'.$user->id.'/avatar.png', (string) $avatar);
        $userProfile = \App\Profile::create([
            'fullname' => 'Test User',
            'user_id'  => $user->id
        ]);

        // Create demo user
        $approval_1 = \App\User::create([
            'name' => 'Demo Kelulusan 1',
            'email' => 'approval_1@localhost.com',
            'password' => bcrypt('password'),
            'avatar' => 'avatar.png'
        ]);
        $approval_1->assignRole(['user','approval-head-department']);
        $avatar = Avatar::create($approval_1->name)->getImageObject()->encode('png');
        Storage::disk('public')->put('avatars/'.$approval_1->id.'/avatar.png', (string) $avatar);
        $approval1Profile = \App\Profile::create([
            'fullname' => 'Test Kelulusan 1',
            'user_id'  => $approval_1->id
        ]);

        // Create demo user
        $approval_2 = \App\User::create([
            'name' => 'Demo Kelulusan 2',
            'email' => 'approval_2@localhost.com',
            'password' => bcrypt('password'),
            'avatar' => 'avatar.png'
        ]);
        $approval_2->assignRole(['user','approval-welfare-social-bureaus']);
        $avatar = Avatar::create($approval_2->name)->getImageObject()->encode('png');
        Storage::disk('public')->put('avatars/'.$approval_2->id.'/avatar.png', (string) $avatar);
        $approval2Profile = \App\Profile::create([
            'fullname' => 'Test Kelulusan 2',
            'user_id'  => $approval_2->id
        ]);

        $approval_3 = \App\User::create([
            'name' => 'Demo Kelulusan 3',
            'email' => 'approval_3@localhost.com',
            'password' => bcrypt('password'),
            'avatar' => 'avatar.png'
        ]);
        $approval_3->assignRole(['user','approval-secretary-sports-welfare']);
        $avatar = Avatar::create($approval_3->name)->getImageObject()->encode('png');
        Storage::disk('public')->put('avatars/'.$approval_3->id.'/avatar.png', (string) $avatar);
        $approval3Profile = \App\Profile::create([
            'fullname' => 'Test Kelulusan 3',
            'user_id'  => $approval_3->id
        ]);

        $approval_4 = \App\User::create([
            'name' => 'Demo Kelulusan 4',
            'email' => 'approval_4@localhost.com',
            'password' => bcrypt('password'),
            'avatar' => 'avatar.png'
        ]);
        $approval_4->assignRole(['user','approval-treasurer']);
        $avatar = Avatar::create($approval_4->name)->getImageObject()->encode('png');
        Storage::disk('public')->put('avatars/'.$approval_4->id.'/avatar.png', (string) $avatar);
        $approval4Profile = \App\Profile::create([
            'fullname' => 'Test Kelulusan 4',
            'user_id'  => $approval_4->id
        ]);
    }
}

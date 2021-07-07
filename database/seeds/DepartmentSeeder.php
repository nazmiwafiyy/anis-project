<?php

use App\Role;
use App\Department;
use App\Permission;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = Department::defaultDepartments();

        foreach ($departments as $department) {
            Department::firstOrCreate([
                'name' => $department['name'],
            ], [
                'description' => $department['description'],
            ]);
        }

        // Module
        $moduleId = DB::table('modules')->insertGetId([
            'display_name' => 'Bahagian / Unit',
            'name' => 'department',
        ]);

        // Permissions
        DB::table('permissions')->insert([
            [
                'display_name' => 'Cipta Bahagian / Unit',
                'name' => 'create-department',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'display_name' => 'Papar Bahagian / Unit',
                'name' => 'read-department',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'display_name' => 'Kemaskini Bahagian / Unit',
                'name' => 'update-department',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'display_name' => 'Padam Bahagian / Unit',
                'name' => 'delete-department',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
        ]);

        // Assign permissions
        $superAdmin = Role::findByName('super-admin');
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::findByName('admin');
        $admin->givePermissionTo(['create-department','read-department','update-department']);
    }
}

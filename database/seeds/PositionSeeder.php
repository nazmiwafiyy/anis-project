<?php

use App\Role;
use App\Position;
use App\Permission;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = Position::defaultPositions();

        foreach ($positions as $position) {
            Position::firstOrCreate([
                'name' => $position['name'],
            ], [
                'description' => $position['description'],
            ]);
        }

        // Module
        $moduleId = DB::table('modules')->insertGetId([
            'display_name' => 'Jawatan',
            'name' => 'position',
        ]);

        // Permissions
        DB::table('permissions')->insert([
            [
                'display_name' => 'Cipta Jawatan',
                'name' => 'create-position',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'display_name' => 'Papar Jawatan',
                'name' => 'read-position',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'display_name' => 'Kemaskini Jawatan',
                'name' => 'update-position',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'display_name' => 'Padam Jawatan',
                'name' => 'delete-position',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
        ]);

        // Assign permissions
        $superAdmin = Role::findByName('super-admin');
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::findByName('admin');
        $admin->givePermissionTo(['create-position','read-position','update-position','delete-position']);


    }
}

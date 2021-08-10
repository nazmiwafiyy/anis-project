<?php

use App\Role;
use App\Type;
use App\Permission;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = Type::defaultTypes();

        foreach ($types as $type) {
            Type::firstOrCreate([
                'name' => $type['name'],
            ], [
                'limit' => $type['limit'],
                'slug' => $type['slug'],
            ]);
        }

        // Module
        $moduleId = DB::table('modules')->insertGetId([
            'name' => 'type',
            'display_name' => 'Perkara',
        ]);

         // Permissions
        DB::table('permissions')->insert([
            [
                'display_name' => 'Papar Perkara',
                'name' => 'read-type',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'display_name' => 'Kemaskini Perkara',
                'name' => 'update-type',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
        ]);

        // Assign permissions
        $superAdmin = Role::findByName('super-admin');
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::findByName('admin');
        $admin->givePermissionTo(['read-type','update-type']);
    }
}

<?php

use App\Department;
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
    }
}

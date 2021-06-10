<?php

use App\Type;
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
    }
}

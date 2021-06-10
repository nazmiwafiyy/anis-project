<?php

use App\Position;
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
    }
}
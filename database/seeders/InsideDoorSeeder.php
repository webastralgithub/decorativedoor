<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsideDoorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $type_of_door = [
            ['name' => 'SINGLE DOOR (SGL)', 'category_id' => 8],
            ['name' => 'PAIR (PR)', 'category_id' => 8],
        ];
    
        $additional_locations = [
            ['name' => 'BEDROOM', 'category_id' => 8],
            ['name' => 'WASHROOM', 'category_id' => 8],
            ['name' => 'CLOSET', 'category_id' => 8],
            ['name' => 'ENTRY CLOSET', 'category_id' => 8],
            ['name' => 'PANTRY', 'category_id' => 8],
            ['name' => 'SPICE KITCHEN', 'category_id' => 8],
            ['name' => 'POWDER ROOM', 'category_id' => 8],
            ['name' => 'UNDER STAIRS', 'category_id' => 8],
            ['name' => 'AC ROOM', 'category_id' => 8],
            ['name' => 'MECHANICAL ROOM', 'category_id' => 8],
            ['name' => 'BOILER', 'category_id' => 8],
            ['name' => 'LAUNDRY', 'category_id' => 8],
            ['name' => 'DEN', 'category_id' => 8],
            ['name' => 'OFFICE', 'category_id' => 8],
        ];

        $jamb = [
            ['name' => '4 1/2', 'category_id' => 8],
            ['name' => '6 1/2 ', 'category_id' => 8],
            ['name' => '4 3/4 ', 'category_id' => 8],
            ['name' => '6 3/4 ', 'category_id' => 8],
            ['name' => '7 1/4 ', 'category_id' => 8],
            ['name' => '8 1/2 ', 'category_id' => 8],
            ['name' => '5 1/4', 'category_id' => 8],
            ['name' => '4 7/8', 'category_id' => 8],
        ];
        
        $left = [
            ['name' => 'OPEN IN O/IN', 'category_id' => 8],
            ['name' => 'OPEN OUT O/O', 'category_id' => 8],
        ];
        $right = [
            ['name' => 'OPEN IN O/IN', 'category_id' => 8],
            ['name' => 'OPEN OUT O/O', 'category_id' => 8],
        ];
        DB::table('type_of_doors')->insert($type_of_door);
        DB::table('location_of_doors')->insert($additional_locations);
        DB::table('jambs')->insert($jamb);
        DB::table('lefts')->insert($left);
        DB::table('rights')->insert($right);
    }
}

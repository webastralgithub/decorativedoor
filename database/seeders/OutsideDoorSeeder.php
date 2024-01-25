<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OutsideDoorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $type_of_door = [
            ['name' => 'PR (DOUBLE DOOR)', 'category_id' => 3],
            ['name' => 'SD (1 SIDELIGHT + 1 DOOR)', 'category_id' => 3],
            ['name' => 'SDS (2 SIDELIGHT + 1 DOOR)', 'category_id' => 3],
            ['name' => 'SDDS (2 SIDELIGHTS + 2 DOOR)', 'category_id' => 3],
            ['name' => 'ONLY DOOR', 'category_id' => 3],
        ];
        $additional_locations = [
            ['name' => 'MAIN ENTRY', 'category_id' => 3],
            ['name' => 'GARAGE TO HOUSE', 'category_id' => 3],
            ['name' => 'GARAGE TO OUT', 'category_id' => 3],
            ['name' => 'MAIN BACK DECK', 'category_id' => 3],
            ['name' => 'TOP FRONT', 'category_id' => 3],
            ['name' => 'BASEMENT', 'category_id' => 3],
            ['name' => 'MASTER TO OUT', 'category_id' => 3],
            ['name' => 'KITCHEN TO OUT', 'category_id' => 3],
            ['name' => 'KITCHEN TO OUT', 'category_id' => 3],
        ];

        $jamb = [
            ['name' => '4 1/2', 'category_id' => 3],
            ['name' => '6 1/2 ', 'category_id' => 3],
            ['name' => '4 3/4 ', 'category_id' => 3],
            ['name' => '6 3/4 ', 'category_id' => 3],
            ['name' => '7 1/4 ', 'category_id' => 3],
            ['name' => '8 1/2 ', 'category_id' => 3],
            ['name' => '9 1/4', 'category_id' => 3],
        ];
        
        $left = [
            ['name' => 'OPEN IN O/IN', 'category_id' => 3],
            ['name' => 'OPEN OUT O/O', 'category_id' => 3],
        ];
        $right = [
            ['name' => 'OPEN IN O/IN', 'category_id' => 3],
            ['name' => 'OPEN OUT O/O', 'category_id' => 3],
        ];
        $category = [
            ['name' => 'WEATHER STRIP (WS)', 'category_id' => 3],
            ['name' => 'DOUBLE DRILL ', 'category_id' => 3],
            ['name' => 'METAL SILL (MS) ', 'category_id' => 3],
            ['name' => 'SINGLE DRILL ', 'category_id' => 3],
            ['name' => 'BRICK MOULDINGS (BM)', 'category_id' => 3],
            ['name' => 'ROLLERS', 'category_id' => 3],
            ['name' => 'PEEP LENS ', 'category_id' => 3],
        ];

        DB::table('type_of_doors')->insert($type_of_door);
        DB::table('location_of_doors')->insert($additional_locations);
        DB::table('jambs')->insert($jamb);
        DB::table('lefts')->insert($left);
        DB::table('rights')->insert($right);
        DB::table('variant_categories')->insert($category);
    }
}

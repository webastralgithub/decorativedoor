<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'PENDING_ORDER_CONFIRMATION'],
            ['name' => 'COMPLETE'],
            ['name' => 'FAILED'],
            ['name' => 'READY_TO_PRODUCTION'],
            ['name' => 'READY_TO_DELIVER'],
            ['name' => 'DISPATCHED'],
        ];

        // Insert data into the 'order_statuses' table
        DB::table('order_statuses')->insert($statuses);
    }
}

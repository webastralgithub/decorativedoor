<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define data to be inserted
        $statuses = [
            ['name' => 'PENDING'],
            ['name' => 'PAID'],
            ['name' => 'FAILED'],
            ['name' => 'REFUNDED'],
            // Add more payment statuses as needed
        ];

        // Insert data into the 'payment_statuses' table
        DB::table('payment_statuses')->insert($statuses);
    }
}

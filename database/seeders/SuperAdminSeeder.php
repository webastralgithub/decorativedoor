<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating Super Admin User
        $superAdmin = User::create([
            'name' => 'Office admin',
            'email' => 'officeadmin@mailinator.com',
            'password' => Hash::make('officeadmin@123')
        ]);
        $superAdmin->assignRole('Super Admin');

        // Creating Admin User
        $admin = User::create([
            'name' => 'Sales Person',
            'email' => 'sales@mailinator.com',
            'password' => Hash::make('sales@123')
        ]);
        $admin->assignRole('Sales Person');

        // Creating Product Manager User
        $productManager = User::create([
            'name' => 'Assembler',
            'email' => 'assembler@mailinator.com',
            'password' => Hash::make('assembler@123')
        ]);
        $productManager->assignRole('Assembler');

         // Creating Product Manager User
         $productManager = User::create([
            'name' => 'Accountant',
            'email' => 'accountant@mailinator.com',
            'password' => Hash::make('accountant@123')
        ]);
        $productManager->assignRole('Accountant');

        // Creating Product Manager User
        $productManager = User::create([
            'name' => 'Delivery',
            'email' => 'delivery@homedecor.com',
            'password' => Hash::make('delivery@123')
        ]);
        $productManager->assignRole('Delivery User');
        
    }
}

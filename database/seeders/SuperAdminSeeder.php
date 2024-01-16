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
            'name' => 'Javed Ur Rehman',
            'email' => 'superadmin@mailinator.com',
            'password' => Hash::make('superadmin@mailinator')
        ]);
        $superAdmin->assignRole('Super Admin');

        // Creating Admin User
        $admin = User::create([
            'name' => 'Syed Ahsan Kamal',
            'email' => 'sales@mailinator.com',
            'password' => Hash::make('sales@mailinator')
        ]);
        $admin->assignRole('Sales Person');

        // Creating Product Manager User
        $productManager = User::create([
            'name' => 'Abdul Muqeet',
            'email' => 'assembler@mailinator.com',
            'password' => Hash::make('assembler@mailinator')
        ]);
        $productManager->assignRole('Assembler');

         // Creating Product Manager User
         $productManager = User::create([
            'name' => 'Abdul Muqeet',
            'email' => 'accountant@mailinator.com',
            'password' => Hash::make('accountant@mailinator')
        ]);
        $productManager->assignRole('Accountant');

        // Creating Product Manager User
        $productManager = User::create([
            'name' => 'Abdul Muqeet',
            'email' => 'delivery@homedecor.com',
            'password' => Hash::make('delivery@homedecor')
        ]);
        $productManager->assignRole('Delivery User');
        
    }
}

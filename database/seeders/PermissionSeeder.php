<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'create-role',
            'edit-role',
            'delete-role',
            'create-user',
            'edit-user',
            'delete-user',
            'create-product',
            'edit-product',
            'delete-product',
            'create-category',
            'edit-category',
            'delete-category',
            'create-order',
            'edit-order',
            'delete-order',
            'view-order',
            'download-invoice',
            'order-status-complete',
            'order-status-pending-order-confirmation',
            'order-status-failed',
            'order-status-ready-to-production',
            'order-status-deliver',
            'order-status-dispatch',
            'change-order-status',
            'make-payment',
            'add-signature',
            'show-quantity-listing',
            'admin-access'
        ];

        // Looping and Inserting Array's Permissions into Permission Table
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}

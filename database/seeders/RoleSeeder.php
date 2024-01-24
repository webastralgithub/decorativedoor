<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);
        $salePerson = Role::create(['name' => 'Sales Person']);
        $accountant = Role::create(['name' => 'Accountant']);
        $assembler = Role::create(['name' => 'Product Assembler']);
        $orderCoordinator = Role::create(['name' => 'Order Coordinator']);
        $deliveryUser = Role::create(['name' => 'Delivery User']);
        Role::create(['name' => 'Customer']);

        $admin->givePermissionTo([
            'All',
        ]);
        $superAdmin->givePermissionTo([
            'All',
        ]);

        $accountant->givePermissionTo([
            'view-order',
            'order-status-failed',
            'order-status-ready-to-production',
            'order-status-deliver',
            'change-order-status',
            'make-payment',
            'change_sales_person',
            'change_assembler_user',
            'change_delivery_user',
            'change_user_address',
            'order_price',
            'admin-access'
        ]);

        $orderCoordinator->givePermissionTo([
            'create-order',
            'edit-order',
            'delete-order',
            'view-order',
            'order-status-complete',
            'order-status-pending-order-confirmation',
            'order-status-failed',
            'order-status-ready-to-production',
            'order-status-deliver',
            'order-status-dispatch',
            'change-order-status',
            'order_price',
            'admin-access'
        ]);
        $salePerson->givePermissionTo([
            'view-order', 'order_price', 'admin-access'
        ]);
        $deliveryUser->givePermissionTo([
            'edit-order',
            'view-order',
            'order-status-ready-to-production',
            'order-status-deliver',
            'change-order-status',
            'add-signature',
            'show-quantity-listing', 'admin-access'
        ]);
        $assembler->givePermissionTo([
            'view-order', 'order-status-ready-to-production', 'order-status-deliver',
            'change-order-status', 'admin-access'
        ]);
    }
}

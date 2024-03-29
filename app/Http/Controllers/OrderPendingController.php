<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;

class OrderPendingController extends Controller
{
    public function __invoke(Request $request)
    {
        $orders = Order::where('order_status', OrderStatus::PENDING_ORDER_CONFIRMATION)
            ->latest()
            ->get();

        return view('admin.orders.pending-orders', [
            'orders' => $orders
        ]);
    }
}

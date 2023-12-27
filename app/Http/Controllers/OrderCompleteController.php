<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;

class OrderCompleteController extends Controller
{
    public function __invoke(Request $request)
    {
        $orders = Order::where('order_status', OrderStatus::COMPLETE)
            ->latest()
            ->get();

        return view('admin.orders.complete-orders', [
            'orders' => $orders
        ]);
    }
}

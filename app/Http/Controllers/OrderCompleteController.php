<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderCompleteController extends Controller
{
    public function __invoke(Request $request)
    {
        $orders = Order::where('order_status', 1)
            ->latest()
            ->get();

        return view('admin.orders.complete-orders', [
            'orders' => $orders
        ]);
    }
}

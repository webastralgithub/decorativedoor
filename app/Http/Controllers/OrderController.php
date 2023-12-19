<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->get();

        return view('admin.orders.index', [
            'orders' => $orders
        ]);
    }

    public function create()
    {
        $products = Product::with(['categories'])->get();
        $customers = User::all(['id', 'name']);

        // $carts = Cart::content();

        return view('admin.orders.create', [
            'products' => $products,
            'customers' => $customers,
            // 'carts' => $carts,
        ]);
    }

    public function store(OrderStoreRequest $request)
    {
        $order = Order::create($request->all());

        // Create Order Details
        // $contents = Cart::content();
        // $oDetails = [];

        // foreach ($contents as $content) {
        //     $oDetails['order_id'] = $order['id'];
        //     $oDetails['product_id'] = $content->id;
        //     $oDetails['quantity'] = $content->qty;
        //     $oDetails['unitcost'] = $content->price;
        //     $oDetails['total'] = $content->subtotal;
        //     $oDetails['created_at'] = Carbon::now();

        //     OrderDetails::insert($oDetails);
        // }

        // // Delete Cart Sopping History
        // Cart::destroy();

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Order has been created!');
    }

    public function show(Order $order)
    {
        $order->loadMissing(['user', 'details'])->get();

        return view('admin.orders.show', [
            'order' => $order
        ]);
    }

    public function update(Order $order, Request $request)
    {
        // TODO refactoring

        // Reduce the stock
        $products = OrderDetails::where('order_id', $order)->get();

        foreach ($products as $product) {
            Product::where('id', $product->product_id)
                //->update(['stock' => DB::raw('stock-'.$product->quantity)]);
                ->update(['quantity' => DB::raw('quantity-' . $product->quantity)]);
        }

        $order->update([
            'order_status' => OrderStatus::COMPLETE
        ]);

        return redirect()
            ->route('admin.orders.complete')
            ->with('success', 'Order has been completed!');
    }

    public function destroy(Order $order)
    {
        $order->delete();
    }

    public function downloadInvoice($order)
    {
        // TODO: Need refactor
        //dd($order);

        //$order = Order::with('customer')->where('id', $order_id)->first();
        $order = Order::with(['customer', 'details'])
            ->where('id', $order)
            ->first();

        return view('admin.orders.print-invoice', [
            'order' => $order,
        ]);
    }
}

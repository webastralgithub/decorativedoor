<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
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

        $products = Product::findOrFail($request->id);
        $oDetails = [];

        foreach ($products as $content) {
            $oDetails['order_id'] = $order['id'];
            $oDetails['product_id'] = $content->product_id;
            $oDetails['quantity'] = $content->quantity;
            $oDetails['unitcost'] = $content->buying_price;
            $oDetails['total'] = $content->buying_price;
            $oDetails['created_at'] = Carbon::now();

            OrderDetails::insert($oDetails);
        }

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Order has been created!');
    }
    public function updateStatus(Request $request)
    {
        $orderId = $request->order_id;
        $orders = Order::findOrFail($orderId)->update(['order_status' => $request->new_status]);
        return response()->json(['success' => 'Order status has been updated!']);
    }

    public function show(Order $order)
    {
        $order->loadMissing(['user', 'details'])->get();
        // dd($order);
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
            'order_status' => 1
        ]);

        return redirect()
            ->route('orders.complete')
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

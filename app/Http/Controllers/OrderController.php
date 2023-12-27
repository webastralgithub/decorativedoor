<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\OrderStatus;
use App\Models\PaymentStatus;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-order|edit-order|delete-order', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-order', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-order', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-order', ['only' => ['destroy']]);
    }

    public function index()
    {
        $orders = Order::latest()->get();
       
        return view('admin.orders.index', [
            'orders' => $orders,
            'sales_users' => User::role('Sales Person')->get(),
            'delivery_users' => User::role('Delivery User')->get(),
            'assembler_users' => User::role('Product Assembler')->get(),
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
        $order = Order::findOrFail($orderId)->where('payment_status', PaymentStatus::PAID)->first();
        if (!isset($order) && empty($order)) {
            return response()->json(['error' => 'Order Payment is not done yet!']);
        }
        Order::findOrFail($orderId)->update(['order_status' => $request->new_status]);
        return response()->json(['success' => 'Order status has been updated!']);
    }

    public function updatePaymentMethod(Request $request)
    {
        $orderId = $request->order_id;
        Order::findOrFail($orderId)->update(['order_status' => OrderStatus::READY_TO_ASSEMBLE, 'payment_status' => PaymentStatus::PAID, 'payment_type' => $request->method]);
        return response()->json(['success' => 'Payment method has been updated!']);
    }

    public function show(Order $order)
    {
        $order->loadMissing(['user', 'details'])->get();
        // dd($order);
        return view('admin.orders.show', [
            'order' => $order,
            'order_statuses' => OrderStatus::all()
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

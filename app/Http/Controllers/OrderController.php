<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\OrderStatus;
use App\Models\PaymentStatus;
use App\Models\DeliveryUser;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-order|edit-order|delete-order|view-order', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-order', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-order', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-order', ['only' => ['destroy']]);
    }

    public function index()
    {
        if (auth()->user()->hasRole('Product Assembler')) {
            // $orders = Order::where('assembler_user_id', Auth::user()->id)->whereIn('order_status', [OrderStatus::READY_TO_ASSEMBLE, OrderStatus::READY_TO_DELIVER])->latest()->get();
            $orders = Order::whereHas('details', function ($query) {
                $query->orWhereIn('order_status', [OrderStatus::READY_TO_ASSEMBLE, OrderStatus::READY_TO_DELIVER]);
            })
                ->where('assembler_user_id', Auth::user()->id)
                ->whereIn('order_status', [OrderStatus::READY_TO_ASSEMBLE, OrderStatus::READY_TO_DELIVER])
                ->latest()
                ->get();
            $order_statuses = OrderStatus::whereIn('id', [4, 5])->get();
        } else if (auth()->user()->hasRole('Delivery User')) {
            $orders = Order::whereHas('details', function ($query) {
                $query->whereIn('order_status', [OrderStatus::READY_TO_DELIVER, OrderStatus::DISPATCHED]);
            })
                ->where('delivery_user_id', Auth::user()->id)
                ->whereIn('order_status', [OrderStatus::READY_TO_DELIVER, OrderStatus::DISPATCHED])
                ->latest()
                ->get();
            $order_statuses = OrderStatus::whereIn('id', [5, 6])->get();
        } else if (auth()->user()->hasRole('Accountant')) {
            $orders = Order::whereIn('order_status', [OrderStatus::READY_TO_ASSEMBLE, OrderStatus::FAILED, OrderStatus::IN_PROGRESS])->latest()->get();
            $order_statuses = OrderStatus::whereIn('id', [1, 3, 4])->get();
        } else {
            $orders = Order::latest()->get();
            $order_statuses = OrderStatus::all();
        }

        return view('admin.orders.index', [
            'orders' => $orders,
            'sales_users' => User::role('Sales Person')->get(),
            'accountant_users' => User::role('Accountant')->get(),
            'delivery_users' => User::role('Delivery User')->get(),
            'assembler_users' => User::role('Product Assembler')->get(),
            'order_statuses' => $order_statuses,
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

    public function updateProductStatus(Request $request)
    {
        $itemId = $request->item_id;
        $orderDetails = OrderDetails::findOrFail($itemId);
        if (!isset($orderDetails) && empty($orderDetails)) {
            return response()->json(['error' => 'Order is not valid!']);
        }
        // OrderDetails::findOrFail($itemId)->update(['order_status' => $request->new_status]);

        if ($orderDetails->order->details->count() == 1) {
            $orderDetails->order->update(['order_status' => $request->new_status]);
            $orderDetails->update(['order_status' => $request->new_status]);

            return response()->json(['success' => 'Order status updated successfully']);
        } else {
            $orderDetails->update(['order_status' => $request->new_status]);
            return response()->json(['success' => 'Order status updated successfully']);
        }


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
        if (auth()->user()->hasRole('Product Assembler')) {
            $access_status = [4, 5];
        } else if (auth()->user()->hasRole('Delivery User')) {
            $access_status = [5, 6];
        } else if (auth()->user()->hasRole('Accountant')) {
            $access_status = [1, 3, 4];
        } else {
            $access_status = [1, 2, 3, 4, 5, 6];
        }
        $order_statuses = OrderStatus::all();
        return view('admin.orders.show', [
            'order' => $order,
            'order_statuses' => $order_statuses,
            'access_status' => $access_status
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

    public function assign_user(Request $request)
    {

        switch ($request->type) {
            case "sales person":
                $key = "user_id";
                $value = $request->userid;
                break;
            case "accountant":
                $key = "accountant_user_id";
                $value = $request->userid;
                break;
            case "assembler":
                $key = "assembler_user_id";
                $value = $request->userid;
                break;
            case "delivery":
                $key = "delivery_user_id";
                $value = $request->userid;
                break;
        }

        $order = Order::whereId($request->orderid)->update([$key => $value]);
        if ($order) {
            return response()->json(['success' => 'Assigned successfully']);
        }
    }


    public function assembler_order()
    {
        if (auth()->user()->hasRole('Product Assembler')) {
            // $orders = Order::where('assembler_user_id', Auth::user()->id)->whereIn('order_status', [OrderStatus::READY_TO_ASSEMBLE, OrderStatus::READY_TO_DELIVER])->latest()->get();
            $orders = Order::whereHas('details', function ($query) {
                $query->orWhereIn('order_status', [OrderStatus::READY_TO_ASSEMBLE, OrderStatus::READY_TO_DELIVER]);
            })
                ->where('assembler_user_id', Auth::user()->id)
                ->whereIn('order_status', [OrderStatus::READY_TO_ASSEMBLE, OrderStatus::READY_TO_DELIVER])
                ->latest()
                ->get();
            $order_statuses = OrderStatus::whereIn('id', [4, 5])->get();
        } else {
            $orders = Order::latest()->get();
            $order_statuses = OrderStatus::all();
        }

        return view('admin.orders.assembler-order-index', [
            'orders' => $orders,
            'sales_users' => User::role('Sales Person')->get(),
            'accountant_users' => User::role('Accountant')->get(),
            'delivery_users' => User::role('Delivery User')->get(),
            'assembler_users' => User::role('Product Assembler')->get(),
            'order_statuses' => $order_statuses,
        ]);
    }
    public function delivery_user(Request $request)
    {
        $order = Order::whereId($request->orderid)->first();
        return view('admin.orders.delivery-user');
    }

    public function delivery_user_save(Request $request)
    {
        if ($request->has('images') && is_array($request->images)) {
            foreach ($request->images as $key => $image) {
                $imgName = Carbon::now()->timestamp . $key . '.' . $image->extension();
                $image->storeAs('public/products', $imgName);
            }
        }
    
        $signatureData = $request->input('signature');
    
        $signature = new DeliveryUser();
        $signature->signature_data = $signatureData;
        $signature->save();
    
        return response()->json(['message' => 'Signature saved successfully']);
    }
         
}

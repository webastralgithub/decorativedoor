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
use App\Models\Note;
use App\Models\DeliverQuantity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;
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
            'coordinators' => User::role('Order Coordinator')->get(),
            'customers' => User::role('Customer')->get(),
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
            $oDetails['unitcost'] = $content->selling_price;
            $oDetails['total'] = $content->selling_price;
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

    public function updateQuantityStatus(Request $request)
    {

        $validator = validator($request->all(), [
            'delivery_quantity' => [
                'required',
                'numeric',
                'min:1',
                'max:' . $request->input('order_quantity'),
            ],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ]);
        }
        $itemId = $request->item_id;
        $orderDetails = OrderDetails::findOrFail($itemId);
        if (!isset($orderDetails) && empty($orderDetails)) {
            return response()->json(['error' => 'Order is not valid!']);
        }
        // OrderDetails::findOrFail($itemId)->update(['order_status' => $request->new_status]);

        if ($orderDetails->order->details->count() == 1) {
            $orderDetails->order->update(['order_status' => $request->new_status]);
            $orderDetails->update(['order_status' => $request->new_status]);
            DeliverQuantity::create(['order_id' => $request->orderId, 'item_id' => $itemId, 'order_quantity' => $request->order_quantity, 'deliver_quantity' => $request->delivery_quantity]);
            //return response()->json(['success' => 'Order status updated successfully']);
        } else {
            $orderDetails->update(['order_status' => $request->new_status]);
            DeliverQuantity::create(['order_id' => $request->orderId, 'item_id' => $itemId, 'order_quantity' => $request->order_quantity, 'deliver_quantity' => $request->delivery_quantity]);
            //return response()->json(['success' => 'Order status updated successfully']);
        }
        return response()->json(['success' => 'Quantity Added successfully!']);
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


    public function updateorderProductStatus(Request $request)
    {
        $itemId = $request->order_id;
        $orderDetails = OrderDetails::where('order_id', $itemId)->get();
        if (!isset($orderDetails) && empty($orderDetails)) {
            return response()->json(['error' => 'Order is not valid!']);
        }
        // dd($orderDetails);

        foreach ($orderDetails as $item) {
            $order_id = $item->order_id;
            OrderDetails::where('order_id', $order_id)->update(['order_status' => $request->new_status]);
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

    // public function downloadInvoice($order)
    // {
    //     $order = Order::with(['customer', 'details'])
    //         ->where('id', $order)
    //         ->first();

    //     $recentSignature = DeliveryUser::where('order_id', $order->id)->first();
    //     return view('admin.orders.print-invoice', [
    //         'order' => $order,
    //         'recentSignature' => $recentSignature,
    //     ]);
    // }

    public function downloadInvoice($order_id)
    {
        $order = Order::with(['customer', 'details'])
            ->where('id', $order_id)
            ->first();

        $recentSignature = DeliveryUser::where('order_id', $order->id)->first();

        $pdf = PDF::loadView('admin.orders.print-invoice', compact("order","recentSignature"));
        return $pdf->download('invoice.pdf');
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
            $orders = Order::with(['details', 'notes', 'deliverorder'])->whereHas('details', function ($query) {
                $query->orWhereIn('order_status', [OrderStatus::READY_TO_ASSEMBLE, OrderStatus::READY_TO_DELIVER]);
            })
                ->where('assembler_user_id', Auth::user()->id)
                ->whereIn('order_status', [OrderStatus::READY_TO_ASSEMBLE, OrderStatus::READY_TO_DELIVER])
                ->latest()
                ->get();
            $order_statuses = OrderStatus::whereIn('id', [4, 5])->get();

            $access_status = [4, 5];
        } else {
            $orders = Order::with(['details', 'notes', 'deliverorder'])->latest()->get();
            $order_statuses = OrderStatus::all();
            $access_status = [1, 2, 3, 4, 5, 6];
        }

        return view('admin.orders.assembler-order-index', [
            'orders' => $orders,
            'sales_users' => User::role('Sales Person')->get(),
            'coordinators' => User::role('Order Coordinator')->get(),
            'customers' => User::role('customer')->get(),
            'accountant_users' => User::role('Accountant')->get(),
            'delivery_users' => User::role('Delivery User')->get(),
            'assembler_users' => User::role('Product Assembler')->get(),
            'order_statuses' => $order_statuses,
            'access_status' => $access_status
        ]);
    }


    public function add_assembler_note(Request $request)
    {
        Note::create($request->all());
        return response()->json(['message' => 'Note saved successfully']);
    }


    public function delivery_user($id)
    {
        $recentSignature = DeliveryUser::latest()->first();
        $images =  DeliveryUser::where('order_id', $id)->get();
        $order = Order::find($id);
        return view('admin.orders.delivery-user', compact('order','recentSignature','images'));
    }

    public function delivery_user_save(Request $request)
    {
        $request->validate([
            'images.*' => 'image|mimes:jpeg,png|max:2048',
        ]);

        $signatureData = $request->input('signature');
      
        if(!empty($request->signature)){
        $signatureImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $signatureData));
        $signatureImageName = Carbon::now()->timestamp . '_signature.png';
        file_put_contents(storage_path('app/public/signatures/' . $signatureImageName), $signatureImage);
        }
        else{
            $signatureImageName =DeliveryUser::where('order_id',$request->order_id)->latest()->first();
            $signatureImageName = $signatureImageName->signature;
        }
        $imagePaths = [];
        if ($request->has('images') && is_array($request->images)) {
            foreach ($request->images as $key => $image) {
                $imgName = Carbon::now()->timestamp . $key . '.' . $image->extension();
                $image->storeAs('public/images', $imgName);
                $imagePaths[] = 'public/images/' . $imgName;
            }
        }

        $deliveryUser = new DeliveryUser();
        $deliveryUser->order_id = $request->order_id;
        $deliveryUser->signature = $signatureImageName;
        $deliveryUser->images = json_encode($imagePaths);
        $deliveryUser->save();

        $recentSignature = DeliveryUser::latest()->first();
        $order = Order::find($request->order_id);
        View::share(['recentSignature' => $recentSignature, 'order' => $order]);
    
        return back()->with(['success' => 'Signature and images saved successfully']);
    }
    public function get_existing_notes(Request $request)
    {
        $orderId = $request->input('order_id');

        $notes = Note::where('order_id', $orderId)
            ->select('note', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($note) {
                return [
                    'note' => $note->note,
                    'created_at' => $note->created_at->format('d-m-Y'),
                ];
            });

        return response()->json(['notes' => $notes]);
    }
}

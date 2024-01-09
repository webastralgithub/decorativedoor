<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Nette\Utils\Random;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = session()->get('cart');
        // dd($cart);
        // print_r($cart);
        $orderId = '';
        if (!empty($cart)) {
            $totalProducts = 0;
            $totalPrice = 0;
            foreach (session('cart') as $id => $details) {
                $totalProducts += (int)$details['quantity'];
                $totalPrice += $details['quantity'] * (!empty($details['variant_price']) ? $details['variant_price'] : $details['price']);
            }

            if(empty(session()->get('assign_customer'))){
                return redirect()->back()->with('success', 'Please assign the customer firstly!');
            }
           
            $productsArr = [
                'user_id' => (session()->get('assign_customer')) ? session()->get('assign_customer') : 0,
                'order_date' => Carbon::now(),
                'order_status' => OrderStatus::IN_PROGRESS,
                'total_products' => $totalProducts,
                'sub_total' => $totalPrice,
                'vat' => 0,
                'total' => $totalPrice,
                'invoice_no' => Random::generate(10),
                'payment_type' => 'demo',
                'sales_person' => (Auth::check()) ? Auth::user()->id : 0,
                'pay' => 0,
                'due' => 0,
            ];
            
            $order = Order::create($productsArr);
            if ($order)
                foreach ($cart as $key => $product) {
                    $selectedVariant = null;
                    $productData = null;
                    if (!empty($product['variant_data']) && count($product['variant_data']) > 0) {
                        $firstKey = array_key_first($product['variant_data']);
                        $selectedVariant = $product['variant_data'][$firstKey];
                        $productData =  ProductVariant::find($product['product_id']);
                    } else {
                        $productData =  Product::find($product['product_id']);
                    }

                    OrderDetails::create([
                        'order_id' => $order->id,
                        'product_id' => $product['product_id'],
                        'variant_id' => (!empty($selectedVariant)) ? $selectedVariant['id'] : 0,
                        'quantity' => $product['quantity'],
                        'total' => (!empty($selectedVariant)) ? ($product['quantity'] * $selectedVariant['price']) : ($product['quantity'] * $productData->buying_price),
                        'unitcost' => (!empty($selectedVariant)) ? $selectedVariant['price'] : $productData->buying_price,
                    ]);
                }
            session()->forget('cart');
            $orderId = '#' . $order->order_id;
        }
        // dd($order);
        return view('frontend.thank-you', compact('orderId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

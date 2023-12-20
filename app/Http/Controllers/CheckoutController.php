<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = session()->get('cart');
        // dd($cart);
        if (!empty($cart)) {
            $totalProducts = 0;
            $totalPrice = 0;
            foreach (session('cart') as $id => $details) {
                $totalProducts += (int)$details['quantity'];
                $totalPrice += $details['variant_price'];
            }
            $productsArr = [
                'user_id' => (Auth::check()) ? Auth::user()->id : 3,
                'order_date' => Carbon::now(),
                'order_status' => 1,
                'total_products' => $totalProducts,
                'sub_total' => $totalPrice,
                'vat' => 0,
                'total' => $totalPrice,
                'invoice_no' => '',
                'payment_type' => 'demo',
                'pay' => 1,
                'due' => 0,
            ];
            $order = Order::create($productsArr);
            if ($order)
                foreach ($cart as $key => $product) {
                    $selectedVariant = null;
                    if (!empty($product['variant'])) {
                        $selectedVariant = json_decode($product['variant'], true);
                    }
                    $product =  ProductVariant::find($product['product_id']);

                    OrderDetails::create([
                        'order_id' => $order->id,
                        'product_id' => $product['product_id'],
                        'variant_id' => (!empty($selectedVariant)) ? $selectedVariant['id'] : 0,
                        'quantity' => $product->quantity,
                        'total' => (!empty($selectedVariant)) ? $selectedVariant['buying_price'] : 0,
                        'unitcost' => 0
                    ]);
                }
            session()->forget('cart');
        }
        return view('frontend.thank-you');
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

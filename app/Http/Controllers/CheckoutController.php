<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Product;
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
        // $cart = session()->get('cart');
        // $productsArr = [];
        // if (!empty($cart)) {
        //     foreach ($cart as $key => $product) {
        //         $product =  Product::find($product->product_id);
        //         $cartElement = [
        //             'user_id' => isset(Auth::user()->id) ? Auth::user()->id : 1,
        //             'order_date' => Carbon::now(),
        //             'order_status' => OrderStatus::PENDING,
        //             'total_products' => '',
        //             'sub_total' => $product->buying_price,
        //             'vat' => '',
        //             'total' => $product->buying_price,
        //             'invoice_no' => '',
        //             'payment_type' => '',
        //             'pay' => '',
        //             'due' => '',
        //         ];
        //         array_merge($cartElement, $productsArr);
        //     }
        //     Order::createMany($productsArr);
        // }

        // session()->flash('success', 'Cart updated successfully');
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

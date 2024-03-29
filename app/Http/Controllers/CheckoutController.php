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
        $orderId = '';
        if (!empty($cart)) {
            $totalProducts = 0;
            $totalPrice = 0;
            foreach (session('cart') as $id => $details) {
                $totalProducts += (int)$details['quantity'];
                $totalPrice += $details['quantity'] * (!empty($details['selling_price']) ? $details['selling_price'] : $details['price']);
            }

            if (empty(session()->get('assign_customer'))) {
                return redirect('customer')->with('success', 'Customer not Assign!');
            }

            $productsArr = [
                'user_id' => (session()->get('assign_customer')) ? session()->get('assign_customer') : 0,
                'order_date' => Carbon::now(),
                'order_status' => OrderStatus::PENDING_ORDER_CONFIRMATION,
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
                        $productData =  ProductVariant::find($product['product_id']);
                        //$selectedVariant = $product['variant_data'][$firstKey];
                        foreach ($product['variant_data']  as $key => $selectedVariant) {
                            OrderDetails::create([
                                'order_id' => $order->id,
                                'product_id' => $product['product_id'],
                                'variant_id' => (!empty($selectedVariant)) ? $selectedVariant['id'] : 0,
                                'quantity' => $selectedVariant['quantity'],
                                'discount' => (!empty($selectedVariant['discount_price'])) ? $selectedVariant['quantity'] * $selectedVariant['discount_price'] : 0,
                                'total' => (!empty($selectedVariant)) ? ($product['quantity'] * $selectedVariant['price']) : ($product['quantity'] * $productData->selling_price),
                                'unitcost' => (!empty($selectedVariant)) ? $selectedVariant['price'] : $productData->selling_price,
                                "typeofdoor_id" => (!empty($product['doortype'])) ? $product['doortype'] : 0,
                                "jamb_id" => (!empty($product['doorjamb'])) ? $product['doorjamb'] : 0,
                                "locationofdoor_id" => (!empty($product['doorlocation'])) ? $product['doorlocation'] : 0,
                                "variant_category_id" => (!empty($product['variant_category_id'])) ? $product['variant_category_id'] : 0,
                                "left_id" => (!empty($product['doorleft'])) ? $product['doorleft'] : 0,
                                "right_id" => (!empty($product['doorright'])) ? $product['doorright'] : 0,
                            ]);
                        }
                    } else {
                        $productData =  Product::find($product['product_id']);

                        OrderDetails::create([
                            'order_id' => $order->id,
                            'product_id' => $product['product_id'],
                            'variant_id' => (!empty($selectedVariant)) ? $selectedVariant['id'] : 0,
                            'quantity' => $product['quantity'],
                            'discount' => (!empty($product['discount_price'])) ? $product['discount_price'] * $product['quantity'] : 0,
                            'total' => (!empty($selectedVariant)) ? ($selectedVariant['quantity'] * $selectedVariant['price']) : ($product['quantity'] * $productData->selling_price),
                            'unitcost' => (!empty($selectedVariant)) ? $selectedVariant['price'] : $productData->selling_price,
                            "typeofdoor_id" => (!empty($product['doortype'])) ? $product['doortype'] : 0,
                            "jamb_id" => (!empty($product['doorjamb'])) ? $product['doorjamb'] : 0,
                            "locationofdoor_id" => (!empty($product['doorlocation'])) ? $product['doorlocation'] : 0,
                            "variant_category_id" => (!empty($product['variant_category_id'])) ? $product['variant_category_id'] : 0,
                            "left_id" => (!empty($product['doorleft'])) ? $product['doorleft'] : 0,
                            "right_id" => (!empty($product['doorright'])) ? $product['doorright'] : 0,
                        ]);
                    }

                    // OrderDetails::create([
                    //     'order_id' => $order->id,
                    //     'product_id' => $product['product_id'],
                    //     'variant_id' => (!empty($selectedVariant)) ? $selectedVariant['id'] : 0,
                    //     'quantity' => $product['quantity'],
                    //     'discount' => (!empty($selectedVariant['discount_price'])) ? $selectedVariant['discount_price'] : 0,
                    //     'total' => (!empty($selectedVariant)) ? ($product['quantity'] * $selectedVariant['price']) : ($product['quantity'] * $productData->selling_price),
                    //     'unitcost' => (!empty($selectedVariant)) ? $selectedVariant['price'] : $productData->selling_price,
                    // ]);
                }
            session()->forget('cart');
            session()->forget('discount');
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

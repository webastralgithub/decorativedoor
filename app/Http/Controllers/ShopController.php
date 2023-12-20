<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::all();
        $allcategory = Category::with(['children'])->get();
        return view('frontend.shop', compact('allcategory', 'products'));
    }

    public function product_details($slug)
    {
        $allcategory = Category::with(['children'])->get();
        $product = Product::where('slug', $slug)->first();
        $addOnProducts = Product::where('id', '!=', $product->id)->get();
        if (empty($product)) {
            return abort(404);
        }
        return view('frontend.product-details', compact('addOnProducts', 'allcategory', 'product'));
    }

    public function addToCart(Request $request)
    {
        /*
          [
            "_token" => "aR28sRJE3Zd4zIfZn75QcnC2ZdadoAQqBI4PkCVp"
            "_method" => "POST"
            "variant" => "{"id":1,"product_id":1,"option_type":"[\n  {\n    \"index\": 1,\n    \"tagNames\": [\n      \"red\"\n    ],\n    \"variantType\": \"color\"\n  },\n  {\n    \"index\": 2,\n    \"tagNames\": [\n      \"s\",\n      \"m\"\n    ],\n    \"variantType\": \"size\"\n  }\n]","name":"red\/S","value":"Red","code":"Red12","quantity":11,"buying_price":20,"notes":"Testtt","created_at":"2023-12-15T12:02:31.000000Z","updated_at":"2023-12-15T12:02:31.000000Z"} ◀"
            "product_id" => "1"
            ]
         */
        $productId = @$request->product_id;

        $product = Product::findOrFail($productId);
        if (!empty($product->variants) && !empty($request->variant)) {
            $selectedVariant = json_decode($request->variant, true);

            $cart[$productId] = [
                "name" => $product->title,
                "product_id" => $product->id,
                "quantity" => !empty($request->quantity) ? $request->quantity : 1,
                "price" => $product->buying_price,
                "image" => $product->image,
                // "variant_id" => (!empty($selectedVariant['id'])) ? $selectedVariant['id'] : 0,
                // "variant_price" => 0

            ];
            $cart[$productId]['variant_data'][$selectedVariant['id']]["quantity"] = !empty($request->quantity) ? $request->quantity : 1;
            $cart[$productId]['variant_data'][$selectedVariant['id']]["name"] = $selectedVariant['name'];
            $cart[$productId]['variant_data'][$selectedVariant['id']]["price"] = (!empty($request->quantity) ? $request->quantity : 1) * $selectedVariant['buying_price'];
            $pricevariant = array_values($cart[$productId]['variant_data']);
            $variant_prices = [];
            foreach ($pricevariant as $price) {
                $variant_prices[] = $price['price'];
            }
            $price = array_sum($variant_prices);
            $cart[$productId]['variant_price'] = $price;
        } else {
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity']++;
            } else {
                $cart[$productId] = [
                    "name" => $product->title,
                    "product_id" => $product->id,
                    "quantity" => !empty($request->quantity) ? $request->quantity : 1,
                    "price" => (!empty($request->quantity) ? $request->quantity : 1) * $product->buying_price,
                    "image" => $product->image,
                    "variant_id" => 0,
                    "variant_price" => (!empty($request->quantity) ? $request->quantity : 1) * $product->buying_price
                ];
            }
        }
        session()->put('cart', $cart);

        // $cart = session()->get('cart', []);
        // if (isset($cart[$id])) {
        //     $cart[$id]['quantity']++;
        // } else {
        //     $cart[$id] = [
        //         "name" => $product->title,
        //         "product_id" => $product->id,
        //         "quantity" => 1,
        //         "price" => $product->buying_price,
        //         "image" => $product->image,
        //         "variant_price" => 0

        //     ];
        // }

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function update_cart(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }

    public function addOn(Request $request)
    {
        $productPrice = DB::table('products')->where('id', $request->pid)->first();
        $variant = DB::table('product_variants')->whereId($request->id)->first();
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->pid]['variant_id'][($request->id)]["quantity"] = $request->quantity;
            $cart[$request->pid]['variant_id'][($request->id)]["name"] = $variant->name;
            $cart[$request->pid]['variant_id'][($request->id)]["price"] = $request->quantity * $variant->buying_price;
            $pricevariant = array_values($cart[$request->pid]['variant_id']);
            $variant_prices = [];
            foreach ($pricevariant as $price) {
                $variant_prices[] = $price['price'];
            }
            $price = array_sum($variant_prices);
            $cart[$request->pid]['variant_price'] = $price;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }

    public function remove_cart(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }

    public function cart()
    {
        return view('frontend.cart');
    }

    public function category($slug)
    {
        $category =  Category::where('slug', $slug)->first();
        $products = Product::all();
        $allcategory = Category::with(['children'])->get();
        if (empty($category)) {
            return abort(404);
        }
        return view('frontend.category', compact('category', 'products', 'allcategory'));
    }

    public function checkout(Request $request)
    {
    }

    public function get_price(Request $request)
    {
        $product = DB::table('product_variants')->where(['product_id' => $request->pid])->whereRaw('LOWER(name) COLLATE utf8mb4_general_ci = ?', [strtolower($request->str)])->first();
        if (!$product)
            $product = DB::table('product_variants')->where(['product_id' => $request->pid])->first();
        return $product;
    }
}

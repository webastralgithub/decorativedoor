<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use DB;

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
        $allcategory = Category::with(['children'])->get();
        return view('frontend.shop', compact('allcategory'));
    }

    public function product_details($slug)
    {
        $allcategory = Category::where('slug', $slug)->with(['children'])->get();
        // $product =Product::with('variants')->find($slug);
        $product = Product::with('variants')->where('slug', $slug)->first();
        return view('frontend.product-details', compact('allcategory', 'product'));
    }

    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->buying_price,
                "image" => $product->image,
                "variant_price" => 0

            ];
        }
        session()->put('cart', $cart);
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
        return view('frontend.category', compact('category', 'products', 'allcategory'));
    }
}

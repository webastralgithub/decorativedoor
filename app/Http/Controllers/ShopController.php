<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use App\Mail\ShareProductMail;
use Illuminate\Support\Facades\Mail;
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
        if(isset($_GET['min']) && isset($_GET['max'])){
            $min = $_GET['min'];
            $max = $_GET['max'];
           // dd($max);
            $products = Product::where('selling_price', '>=', $min)
                   ->where('selling_price', '<=', $max)
                   ->get();
        }else{
            $products = Product::all();
        }
        
        $allcategory = Category::with(['children'])->get();
        return view('frontend.shop', compact('allcategory', 'products'));
    }

    public function product_details($slug)
    {
        $product = Product::with(['image'])->where('slug', $slug)->first();
        if (empty($product)) {
            return abort(404);
        }
        $productimages = ProductImage::where('product_id', $product->id)->get();
        $allcategory = Category::with(['children'])->get();
        $addOnProducts = Product::where('id', '!=', $product->id)->get();
        return view('frontend.product-details', compact('addOnProducts', 'productimages', 'allcategory', 'product'));
    }

    public function addToCart(Request $request)
    {
        $cart = (!session()->has('cart')) ? session()->get('cart', []) : session()->get('cart');
    
        $discount = session()->get('discount');

        
        $productId = @$request->product_id;
          if(!empty($discount[$productId])){
            $discount_ammount = $discount[$productId]['discount_ammount'];
          }else{
            $discount_ammount = 0;
          }
        $product = Product::findOrFail($productId);
       
        if (count($product->variants) > 0 && !empty($product->variants) && !empty($request->variant)) {
            $selectedVariant = json_decode($request->variant, true);
            if (isset($cart[$productId]) && isset($cart[$productId]['variant_data'][$selectedVariant['id']])) {
                $cart[$productId]['quantity'] += $request->quantity;
                $cart[$productId]['variant_data'][$selectedVariant['id']]["quantity"] += $request->quantity;
            } else {
                if (!isset($cart[$productId]))
                    $cart[$productId] = [
                        "name" => $product->title,
                        "product_id" => $product->id,
                        "quantity" => !empty($request->quantity) ? $request->quantity : 1,
                        "price" => $product->selling_price,
                        "image" => $product->image,
                        "discount_price" => ($discount_ammount) ? $discount_ammount : 0,
                        // "variant_id" => (!empty($selectedVariant['id'])) ? $selectedVariant['id'] : 0,
                        // "variant_price" => 0

                    ];
                // if (!empty($selectedVariant))
                $cart[$productId]['variant_data'][$selectedVariant['id']]["quantity"] = !empty($request->quantity) ? $request->quantity : 1;
            }
            // if (!empty($selectedVariant)) {
            $cart[$productId]['variant_data'][$selectedVariant['id']]["id"] = $selectedVariant['id'];
            $cart[$productId]['variant_data'][$selectedVariant['id']]["name"] = $selectedVariant['name'];
            $cart[$productId]['variant_data'][$selectedVariant['id']]["price"] = $selectedVariant['selling_price'];
            $cart[$productId]['variant_data'][$selectedVariant['id']]["discount_price"] = $discount_ammount;
            $pricevariant = array_values($cart[$productId]['variant_data']);
            $variant_prices = [];
            foreach ($pricevariant as $price) {
                $variant_prices[] = $price['price'];
            }
            $price = array_sum($variant_prices);
            // }
            $cart[$productId]['variant_price'] = $price || $product->selling_price;
        } else {
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += $request->quantity;
            } else {
                $cart[$productId] = [
                    "name" => $product->title,
                    "product_id" => $product->id,
                    "quantity" => !empty($request->quantity) ? $request->quantity : 1,
                    "price" => $product->selling_price,
                    "discount_price" => $discount_ammount,
                    "image" => $product->image,
                    "variant_data" => [],
                    // "variant_price" => $product->selling_price
                ];
            }
        }
        session()->put('cart', $cart);

        session()->forget('discount');

        $total = [];
        $discount = [];
        foreach((array) session('cart') as $id => $details){
            if(isset($details['variant_price'])){
                if(isset($details['variant_data'])){
                    foreach($details['variant_data'] as $variantId => $subVariant){
                        $discount[] = $subVariant['discount_price']; 
                        $total[] = $subVariant['price'] * $subVariant['quantity'];
                    }
                }
            }
            if(empty($details['variant_data'])){
                $total[] = $details['price'] * $details['quantity'];
                $discount[] = (isset($details['discount_price'])) ? $details['discount_price'] : 0;                            
            }
        }

        $total = array_sum($total);
        $discount = array_sum($discount);
    

        $data = array(
            'success' => 'Product added to cart successfully!',
            'total_ammount' => $total - $discount,
            'product_count' => count(session('cart')),
        );
        return response()->json($data);
        //return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function update_cart(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            if (isset($request->variant) && !empty($request->variant)) {
                $variantId = $request->variant;
                $cart[$request->id]['variant_data'][$variantId]["quantity"] = $request->quantity;
            } else {
                $cart[$request->id]["quantity"] = $request->quantity;
            }
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
            $cart[$request->pid]['variant_id'][($request->id)]["price"] = $request->quantity * $variant->selling_price;
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
            
            if (isset($request->variant) && !empty($request->variant)) {
             
                $variantId = $request->variant;
                if (isset($cart[$request->id]['variant_data'][$variantId])) {
                    $quantity = $cart[$request->id]['variant_data'][$variantId]['quantity'];
                    $price = $cart[$request->id]['variant_data'][$variantId]['price'];
                    // update the price before remove variant with all quantity
                    $cart[$request->id]['variant_price'] = $cart[$request->id]['variant_price'] - ($price * $quantity);
                    unset($cart[$request->id]['variant_data'][$variantId]);
                    if(count($cart[$request->id]['variant_data']) == 0){
                        unset($cart[$request->id]);
                    }
                }
            } else {
                if (isset($cart[$request->id])) {
                    unset($cart[$request->id]);
                }
            }
            session()->put('cart', $cart);
            session()->flash('success', 'Product removed successfully');
        }
    }

    public function cart()
    {    // $cart = session()->remove('cart');
        // unset($cart[30]);
        // session()->put('cart', $cart);
        // dd(session()->get('cart'));
        return view('frontend.cart');
    }

    public function category($slug = '')
    {
        $category =  Category::where('slug', $slug)->first();
       
        // dd($category->products);
        if(isset($_GET['min']) && isset($_GET['max'])){
            $min = $_GET['min'];  
            $max = $_GET['max'];
            
            $productData = Category::where('slug', $slug) 
            ->with(['products' => function ($query) use ($min, $max) {
                $query->where('selling_price', '>=', $min)
                    ->where('selling_price', '<=', $max);
            }])->first();
        }else{
            $productData =  Category::with(['products'])->where('slug', $slug)->first();
        }
        // $products = [];
        // foreach($productData->products as $product){
        //     $products[] = $product;
        // }
        // $products = array_unique($products);

        $products = [];
        $seenProductIds = [];

        foreach ($productData->products as $product) {
            if (!in_array($product->id, $seenProductIds)) {
                $products[] = $product;
                $seenProductIds[] = $product->id;
            }
        }

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
        $productAvailabityStock =  getProductAvailabityStock($request->pid);
        $product->productAvailabityStock =  $productAvailabityStock;
        return $product;
    }


    public function share_product(Request $request, $productid){

        $product = Product::with(['variants','images','categories'])->where('id', $productid)->first();
        
        if(!empty($product)){

            $variant = [];
            foreach($product->variants as $key => $variants){
                $variant[$key]['name'] = $variants->name;
            } 

            $emailData = [
                'title' => $product->title, 
                'description' => $product->short_description, 
                'price' => ($request->price) ? $request->price : $product->selling_price, 
                'variants' => $product->variants, 
                'images' => $product->images,
                'selectvarient' => ($request->selectvarient) ? $request->selectvarient : '',
            ];
            $attachmentPaths = [];
            foreach ($product->images as $image) {
                $attachmentPaths[] = storage_path('app/public/products/' . $image->path);
            }
            $email = $request->email;
            Mail::to($email)->send(new ShareProductMail($emailData ,$attachmentPaths ));
        
            return 'Email sent successfully!';
        }
        

        //dd($productid);
    }

    public function product_discount(Request $request, $productId){

        $discount = (!session()->has('discount')) ? session()->get('discount', []) : session()->get('discount');
        $discount[$productId] = ["product_id" => $productId, "discount_ammount" => $request->apply_code ];
        session()->put('discount', $discount);
        $data = array(
            'success' => 'Discount Applied!',
            'discount' =>  $request->apply_code,
        );
        return response()->json($data);
        
    }
}

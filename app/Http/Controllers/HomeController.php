<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
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
        $productData = Product::latest()->paginate(env('RECORD_PER_PAGE', 10));
       
        $products = [];
        $seenProductIds = [];

        foreach ($productData as $product) {
            if (!in_array($product->id, $seenProductIds)) {
                $products[] = $product;
                $seenProductIds[] = $product->id;
            }
        }
        return view('frontend.index', [
            //'products' => Product::latest()->paginate(env('RECORD_PER_PAGE', 10)),
            'products' => $products,
            'interior' => Category::with(['products'])->where('slug', 'interior-doors')->first(),
            'exterior' => Category::with(['products'])->where('slug', 'exterior-doors')->first(),
        ]);
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function startneworder(){
        Session::forget('discount');
        if(session()->has('cart')){
            Session::forget('cart');
            Session::forget('discount');
        }
        if(session()->has('assign_customer')){
            Session::forget('assign_customer');
        }
        return back();
    }
}

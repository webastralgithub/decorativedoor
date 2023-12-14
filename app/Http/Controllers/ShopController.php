<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

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
        return view('frontend.product-details', compact('allcategory'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\SoldProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InventoryController extends Controller
{


    /**
     * Instantiate a new InventoryController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-inventory|edit-inventory|delete-inventory', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-inventory', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-inventory', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-inventory', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.inventory.index', [
            'categories' => Category::all(),
            'products' => Product::all(),
            'soldproductsbystock' => SoldProduct::selectRaw('product_id, max(created_at), sum(quantity) as total_qty, sum(total_amount) as incomes, avg(price) as avg_price')->whereYear('created_at', Carbon::now()->year)->groupBy('product_id')->orderBy('total_qty', 'desc')->limit(15)->get(),
            'soldproductsbyincomes' => SoldProduct::selectRaw('product_id, max(created_at), sum(quantity) as total_qty, sum(total_amount) as incomes, avg(price) as avg_price')->whereYear('created_at', Carbon::now()->year)->groupBy('product_id')->orderBy('incomes', 'desc')->limit(15)->get(),
            'soldproductsbyavgprice' => SoldProduct::selectRaw('product_id, max(created_at), sum(quantity) as total_qty, sum(total_amount) as incomes, avg(price) as avg_price')->whereYear('created_at', Carbon::now()->year)->groupBy('product_id')->orderBy('avg_price', 'desc')->limit(15)->get()
        ]);
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

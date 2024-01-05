<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\SoldProduct;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Inventory;
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
    public function index(Request $request)
    {

        $products = Product::when(isset($request->q), function ($query) use ($request) {

            $query->whereRaw("(title LIKE '%" . $request->q . "%')");
        })->with(['inventories', 'orderdetails'])->latest()->paginate(10);
        return view('admin.inventory.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product = product::with(['inventories', 'orderdetails'])->get();

        $customers = User::all(['id', 'name']);

        // $carts = Cart::content();

        return view('admin.inventory.create', [
            'products' => $product,
            'customers' => $customers,
            // 'carts' => $carts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'product_id'     => 'required',
            'quantity'     => 'required',
            'waybill' => 'required',
        ],[
            'product_id.required'=> 'Please select a Product First.',
            'quantity.required'=> 'The quantity field is required.',
            'waybill.required'=> 'The waybill field is required.',
        ]);
         $inventory = Inventory::create($request->all());
         return redirect()
         ->route('inventory.index')
         ->with('success', 'Inventory has been created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = product::with(['inventories', 'orderdetails'])->where('id', $id)->first();
        $customers = User::all(['id', 'name']);

        // $carts = Cart::content();

        return view('admin.inventory.show', [
            'products' => $product,
            'customers' => $customers,
            // 'carts' => $carts,
        ]);
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
        Inventory::where('id', $request->inventoryid)
        ->update([
            'product_id' => $request->product_id,
            'waybill' => $request->waybill,
            'quantity' => $request->quantity
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $inventory =  Inventory::where('id', $id)->first('product_id');
        Inventory::where('id', $id)->delete();
        return redirect()->route('inventory.show', $inventory->product_id)
        ->withSuccess('Inventory is deleted successfully.');
    }
}

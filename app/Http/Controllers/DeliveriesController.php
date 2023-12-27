<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;

class DeliveriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deliveries = Delivery::all();
        $sales = Sale::all();
        $products = Product::all();
        $users = User::all();

        return view('deliveries', compact('deliveries', 'sales', 'products', 'users'));
    }

    public function orderTrack()
    {
        return view('frontend.pages.order-track');
    }

    public function deliveryTrackOrder(Request $request)
    {
        // return $request->all();
        $delivery = Delivery::where('tracking_number', $request->tracking_number)->first();
        if ($delivery) {
            if ($delivery->status == "new") {
                request()->session()->flash('success', 'Your delivery has been placed. please wait.');
                return redirect()->route('home');
            } elseif ($delivery->status == "process") {
                request()->session()->flash('success', 'Your delivery is under processing please wait.');
                return redirect()->route('home');
            } elseif ($delivery->status == "delivered") {
                request()->session()->flash('success', 'Your delivery is successfully delivered.');
                return redirect()->route('home');
            } else {
                request()->session()->flash('error', 'Your delivery canceled. please try again');
                return redirect()->route('home');
            }
        } else {
            request()->session()->flash('error', 'Invalid delivery numer please try again');
            return back();
        }
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
    public function show(Delivery $delivery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Delivery $delivery)
    {
        return view('deliveries-edit', compact('delivery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Delivery $delivery)
    {
        $this->validate($request, [
            'sale_id' => 'required|unique:deliveries',
            'tracking_number' => 'required',
            'recipient' => 'required',
            'address' => 'required',
            'price' => 'required',
            'expected_arrival' => 'required|date|after:tomorrow',
            'actual_arrival' => 'nullable|date|after:expected_arrival',
            'status' => 'required',
            'description' => 'required'
        ]);

        $delivery->sale_id = $request->get('sale_id');
        $delivery->name = $request->get('name');
        $delivery->price = $request->get('price');
        $delivery->description = $request->get('description');

        $delivery->save();
        return redirect('/deliveries')->with('success', 'Delivery updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delivery $delivery)
    {
        $delivery->delete();

        return redirect('/deliveries')->with('success', 'Delivery deleted!');
    }
}

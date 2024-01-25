<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Order;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

        Payment::create(['order_id' => $request->order_id, 'customer_id' => $request->customer_id, 'recived_payment' => $request->recived_payment, 'payment_method' => $request->payment_method]);

        return redirect()
        ->back()
        ->with('success', 'Order has been created!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $paymentList = Payment::all();

        $order =  Order::with(['customer'])->where('id', $id)->first();
        
        dd($order);
        return view('admin.payment.index', [
            'order_id' => $id, 
            'payments' => $paymentList,  
            'order' => $order,          
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

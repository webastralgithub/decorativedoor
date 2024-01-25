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

        $request->validate([
            'recived_payment' => 'required',
            'payment_method' => 'required',
        ]);

        $paymentList = Payment::where('order_id', $request->order_id)->get();
        
        $pendingammount = 0;
        foreach($paymentList as $payment){
            $pendingammount += $payment->recived_payment;
        }
       
        $paymenttotal =  getOrderTotalprice($request->order_id);
        $pending =  $paymenttotal- $pendingammount;
      
        if($pending < $request->recived_payment){
            return redirect()
            ->back()
            ->with('error', 'Added amount should be less-then pending amount.');
        }else{
            Payment::create(['order_id' => $request->order_id, 'customer_id' => $request->customer_id, 'recived_payment' => $request->recived_payment, 'payment_method' => $request->payment_method]);

            return redirect()
            ->back()
            ->with('success', 'Payment added Successfully.');
        }
        

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $paymentList = Payment::where('order_id', $id)->get();

        $order =  Order::with(['customer'])->where('id', $id)->first();
        
        $pendingammount = 0;
        foreach($paymentList as $payment){
            $pendingammount += $payment->recived_payment;
        }
        //dd($order);
        return view('admin.payment.index', [
            'order_id' => $id, 
            'payments' => $paymentList,  
            'order' => $order,  
            'totalpending' => $pendingammount,        
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

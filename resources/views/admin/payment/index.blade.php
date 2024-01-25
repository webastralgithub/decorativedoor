@extends('admin.layouts.app')

@section('content')

<div class="mx-4 content-p-mobile">
    <div class="page-header-tp">
        <h3>Make Payment</h3>
    </div>
    
    <div class="content-body">

        <div class="mb-3 row">
            <div class="col-md-4"><strong> Total Amount : 2000 </strong></div>
            <div class="col-md-4"><strong> Recived Amount : 1000 </strong></div>
            <div class="col-md-4"><strong> Pending Amount : 1000 </strong></div>
        </div>
        <form action="{{ route('payment.store')}}" method="Post">
            @csrf
            <div class="mb-3 row">
                <input type="hidden" name="order_id" value="{{$order_id}}">
                <input type="hidden" name="customer_id" value="{{ $order->user_id }}">
                <div class="col-md-4">
                    <input type="text" class="form-control" id="name" name="recived_payment" value="" Placeholder="Pay Ammount">
                </div>
                <div class="col-md-4">
                    <select name="payment_method" class="form-control">
                        <option value="">Select a Payment Method</option>
                        <option value="Cash On Delivery">Cash On Delivery</option>
                        <option value="Credit Card">Credit Card</option>
                        <option value="Paypal">Paypal</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="submit" class="form-control btn btn-primary" id="submit" name="submit" value="Pay Now">
                </div>
            </div>
        </form>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">Recived Amount</th>
                    <th scope="col">Payment Method</th>
                    <th scope="col">Payment Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                <tr>
                    <td>{{$payment->recived_payment}}</td>
                    <td>{{$payment->payment_method}}</td>
                    <td>{{date_format($payment->updated_at,"Y-m-d")}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

      

    </div>
</div>

@endsection
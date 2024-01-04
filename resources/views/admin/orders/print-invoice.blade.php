@extends('admin.layouts.app')

@section('content')

<div class="card mx-4">
    <div class="card-body">
        <div class="container mb-5 mt-3">
            <div class="row px-4 d-flex align-items-baseline print-pg-top-bar">
                    <p style="color: #7e8d9f;font-size: 20px;">Invoice >> <strong>ID: #{{ $order->invoice_no }}</strong></p>
                    <a href="javascript:window.print()" class="btn btn-light text-capitalize border-0" data-mdb-ripple-color="dark"><i class="fas fa-print text-primary"></i> Print</a>           
            </div>

            <div class="container">

                <div class="row invoice-card">
                    <div class="col-md-12">
                        <div class="text-center print-admin-mn">
                            <i class="fab fa-mdb fa-4x ms-0" style="color:#5d9fc5 ;"></i>
                            <p class="pt-0">Door Admin</p>
                        </div>
                    </div>

                    <div class="col-md-12">
                    <div class="row">
                        @if($order->user)
                        <div class="col-xl-8">
                            <ul class="list-unstyled">
                                <li class="text-muted text-to-print">To: <span style="color:#5d9fc5 ;">{{ @$order->user->name }}</span></li>
                                <li class="text-muted text-sn-addrs">{{ @$order->user->address->street .' '. @$order->user->address->city }}</li>
                                <li class="text-muted text-sn-addrs">{{@$order->user->address->state}}, {{@$order->user->address->country}}</li>
                                <li class="text-muted text-sn-addrs"><i class="fas fa-phone"></i> {{ @$order->user->phone }}</li>
                            </ul>
                        </div>
                        @endif
                        <div class="col-xl-4">
                            <p class="text-muted">Invoice</p>
                            <ul class="list-unstyled">
                                <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i>
                                    <span class="fw-bold">ID:</span>#{{$order->order_id}}
                                </li>
                                <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i>
                                    <span class="fw-bold">Creation Date: </span>{{ $order->order_date->format('M d, Y') }}
                                </li>
                                <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i>
                                    <span class="me-1 fw-bold">Status:</span><span class="badge bg-warning text-black fw-bold">
                                        {{ \App\Models\OrderStatus::getStatusNameById($order->order_status)}}
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    </div>
                    
                    <div class="col-md-12">
                    <div class="row my-2 mx-1 justify-content-center">
                        <table class="table table-striped table-borderless table-borderless-print">
                            <thead style="background-color:#004382 ;" class="text-white">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Unit Price</th>
                                    <th scope="col">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->details as $item)
                                <tr>
                                    <th scope="row">1</th>
                                    <td>{{ $item->product->title }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->unitcost, 2, '.', ',') }}</td>
                                    <td>$ {{ number_format($item->total, 2, '.', ',') }}</td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                    </div>


                    <div class="col-md-12">
                    <div class="row my-2 additinal-notes-print-tottle">
                        <div class="col-xl-9">
                            <p class="">Add additional notes and payment information</p>

                        </div>
                        <div class="col-xl-3">
                            <ul class="list-unstyled list-totle-sub-totle-print">
                                <li class="text-muted ms-3"><span class="text-black me-4">SubTotal</span>${{ number_format($order->sub_total, 2, '.', ',') }}</li>
                                <li class="text-muted ms-3 mt-2"><span class="text-black me-4">Tax </span>${{ number_format($order->vat, 2, '.', ',') }}</li>
                            </ul>
                            <p class="text-black float-start total-price-print"><span class="text-black me-3"> Total Amount</span><span style="font-size: 25px;">${{ (number_format($order->total - $order->vat, 2, '.', ',')) }}</span></p>
                        </div>
                    </div>
                    </div>
                    <hr>

                    <div class="col-md-12">
                    <div class="row">
                        <div class="col-xl-12 thankyou-print">
                            <p>Thank you for your purchase</p>
                        </div>
                    </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
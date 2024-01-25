<div class="container invoice">
        <div class="invoice-header">
            <div class="row">
                <div class="col-xs-8">
                    <h1>Invoice</h1>
                    <h4 class="text-muted">NO: <strong>{{$order->invoice_no}} </strong>| Date: <strong>{{
                            \Carbon\Carbon::parse($order->created_at)->format('d-m-Y') }}</strong></h4>
                </div>
                <div class="col-xs-4">
                    <div class="media">
                        <div class="media-left">
                            <img class="media-object logo"
                                src="https://sunrisedoor.nvinfobase.com/frontend/img/logo.png" />
                        </div>
                        <ul class="media-body list-unstyled">
                            <li><strong>Sunrise Doors</strong></li>
                            <li>00-00 Road 00000</li>
                            <li>info@sunrisedoor.com</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="invoice-body">
            <div class="row">
                <div class="col-xs-5">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Company Details</h3>
                        </div>
                        <div class="panel-body">
                            <dl class="dl-horizontal">
                                <dt>Name</dt>
                                <dd><strong>Sunrise Doors</strong></dd>
                                <dt>Address</dt>
                                <dd>00-00 Road 00000</dd>
                                <dt>Phone</dt>
                                <dd>+1 (604) 446-5841</dd>
                                <dt>Email</dt>
                                <dd>hello@dummy.com</dd>
                        </div>
                    </div>
                </div>
                <div class="col-xs-7">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">User Details</h3>
                        </div>
                        <div class="panel-body">
                            <dl class="dl-horizontal">
                                <dt>Name</dt>
                                <dd>{{$order->name}}</dd>
                                <dt>Email</dt>
                                <dd>{{$order->email}}</dd>
                                <dt>Phone</dt>
                                <dd>{{$order->phone}}</dd>
                                <dt>Street</dt>
                                <dd>{{$order->street}}</dd>
                                <dt>City</dt>
                                <dd>{{$order->city}}</dd>
                                <dt>State</dt>
                                <dd>{{$order->state}}</dd>
                                <dt>Country</dt>
                                <dd class="mono">{{$order->country}}</dd>
                                <dt>Zip Code</dt>
                                <dd>{{$order->zip_code}}</dd>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Order #{{$order->order_id}}</h3>
                </div>
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>Item / Details</th>
                            <th class="text-center colfix">Ordered Quantity</th>
                            <th class="text-center colfix">Production Ready Qty</th>
                            <th class="text-center colfix">Backorder Quantity</th>
                            <th class="text-center colfix">Delivered Quantity</th>
                            <th class="text-center colfix">Pending Quantity</th>
                            <th class="text-center colfix">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $subtotal = 0; @endphp
                        @foreach ($orderDetails->details as $item)
                        <tr>
                            <td>
                                {{ $item->product->title }}
                                <br>
                                <small class="text-muted">CODE:<note>{{ $item->product->code }}</note></small>
                            </td>
                            @php $quantities = getInvoiceDeliveryQuantity($item->order_id); @endphp
                            @php
                            $orderQuantity = 0;
                            $deliver_quantity = 0;

                            $subtotal += getOrderTotalprice($item->id);

                            $orderQuantity += $item->quantity;
                            @endphp

                            @php
                            $deliver_quantity = 0;
                            foreach ($order->deliverorder as $key => $items) {
                            $deliver_quantity += $items->deliver_quantity;
                            }
                            $finalPrice = $subtotal;
                            @endphp


                            <td class="text-right">
                                <span class="mono">{{ $quantities['order_quantity'] }}</span>
                            </td>
                            <td class="text-right">
                                <span class="mono">{{ $deliver_quantity }}</span>
                            </td>
                            <td class="text-right">
                                <span class="mono">{{ $orderQuantity - $deliver_quantity }}</span>
                            </td>
                            <td class="text-right">
                                <span class="mono">{{ $quantities['total_delivery_quantity'] }}</span>
                            </td>
                            <td class="text-right">
                                <strong class="mono">{{ $quantities['pending_quantity'] }}</strong>
                            </td>
                            <td class="text-right">
                                <strong class="mono">${{ number_format(getOrderTotalprice($item->id), 2, '.', ',')
                                    }}</strong>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel panel-default">
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <td class="text-center col-xs-1">Sub Total</td>
                            <td class="text-center col-xs-1">Tax</td>
                            <td class="text-center col-xs-1">Final</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="text-center rowtotal mono">${{ number_format($subtotal, 2, '.', ',') }}</th>
                            <th class="text-center rowtotal mono">${{ number_format(env("GST_HST_TAX",
                                0) + env("PST_RST_QST_TAX", 0), 2, '.', ',') }}</th>
                            <th class="text-center rowtotal mono">${{ number_format($finalPrice + (env("GST_HST_TAX",
                                0) + env("PST_RST_QST_TAX", 0)), 2, '.', ',') }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-xs-7">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <i>Signature</i>
                            <hr style="margin:3px 0 5px" />
                            <div class="signature-box">
                                @if ($signature)
                                <img src="{{ asset('storage/signatures/' . $signature->signature) }}"
                                    alt="Recent Signature">
                                @endif
                            </div>
                            <!-- Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odit repudiandae numquam sit facere blanditiis, quasi distinctio ipsam? Libero odit ex expedita, facere sunt, possimus consectetur dolore, nobis iure amet vero. -->
                        </div>
                    </div>
                </div>
                <div class="col-xs-5">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Payment Status</h3>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled">
                                <li>Recived Payment- <span class="mono">${{ number_format($finalPrice
                                        + (env("GST_HST_TAX",
                                        0) + env("PST_RST_QST_TAX", 0)), 2, '.', ',') }}</span></li>
                                <li>Pending Payment - <span class="mono">In Progress</span></li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="invoice-footer">
            Thank you for choosing our services.
            <br /> We hope to see you again soon
            <br />
        </div>
    </div>
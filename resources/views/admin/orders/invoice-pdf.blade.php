

<div style="padding-right: 15px; padding-left: 15px; margin-right: auto; margin-left: auto; max-width:1140px;  background: #fff; width: 970px !important; margin: 50px auto; border: 1px solid #00000061; background-color: #eef1f4;" class="container invoice">
        <div style=" padding: 25px 25px 15px;" class="invoice-header">
            <div style="display:flex; justify-content:space-between; width:100%; " class="row invoice-header-row">
                <div style="width:50%"  class="col-xs-8 invoice-header-col-xs-8">
                    <h1 style="  margin: 0; color: #2b4551; font-size: 36px; font-weight: 500;">Invoice</h1>
                    <h4 style="color:#6c757d !important; margin-top:10px; margin-bottom:10px; font-weight:500; font-size:18px;" class="text-muted">NO: <strong style="color:rgba(0, 0, 0, 0.75); ">{{$order->invoice_no}} </strong>| Date: <strong>{{
                            \Carbon\Carbon::parse($order->created_at)->format('d-m-Y') }}</strong></h4>
                </div>
                <div style="width:33%" class="col-xs-4 invoice-header-col-xs-4">
                    <div style="margin-top:0; display:flex; overflow:hidden;" class="media">
                        <div style="padding-right:10px;" class="media-left invoice-header-media-left">
                            <img style="width:100%" class="media-object logo media-left-img"
                                src="https://sunrisedoor.nvinfobase.com/frontend/img/logo.png" />
                        </div>
                        <ul style="font-size:0.9em; margin:0;" class="media-body list-unstyled invoice-header-media-body">
                            <li><strong style="font-weight:700;">Sunrise Doors</strong></li>
                            <li>00-00 Road 00000</li>
                            <li>info@sunrisedoor.com</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div style=" padding: 25px 25px; border-radius: 10px; background: #eef1f4;" class="invoice-body invoice-body-custom">
            <div style="display:flex; justy-content:space-between; " class="row invoice-body-row">
                <div style="width:45%; " class="col-xs-5 invoice-body-col-xs-5 invoice-body-custom-inner-col-5">
                    <div style="border: 1px solid #ddd; margin-bottom:20px; background-color: #fff; box-shadow: 0 1px 1px rgba(0,0,0,.05);" class="panel panel-default invoice-body-panel">
                        <div style=" background-color: #004686; color: #fff !important; padding: 10px 15px; border-bottom: 1px solid #ddd !important; border: 1px solid #ddd; border-top-left-radius: 3px; border-top-right-radius: 3px;" class="panel-heading invoice-body-panel-heading">
                            <h3 style="color:#fff; font-weight:600;" class="panel-title">Company Details</h3>
                        </div>
                        <div style=" padding: 15px;" class="panel-body">
                            <dl style="margin:0;" class="dl-horizontal invoice-body-dl">
                                <dt style="float: left;
                                            width: 160px;
                                            overflow: hidden;
                                            clear: left;
                                            text-align: right;
                                            text-overflow: ellipsis;
                                            white-space: nowrap;">Name</dt>
                                <dd style="margin-left: 180px;"><strong style="font-weight:700;">Sunrise Doors</strong></dd>
                                <dt style="float: left;
                                            width: 160px;
                                            overflow: hidden;
                                            clear: left;
                                            text-align: right;
                                            text-overflow: ellipsis;
                                            white-space: nowrap;">Address</dt>
                                <dd style="margin-left: 180px;">00-00 Road 00000</dd>
                                <dt style="float: left;
                                            width: 160px;
                                            overflow: hidden;
                                            clear: left;
                                            text-align: right;
                                            text-overflow: ellipsis;
                                            white-space: nowrap;">Phone</dt>
                                <dd style="margin-left: 180px;">+1 (604) 446-5841</dd>
                                <dt style="float: left;
                                            width: 160px;
                                            overflow: hidden;
                                            clear: left;
                                            text-align: right;
                                            text-overflow: ellipsis;
                                            white-space: nowrap;">Email</dt>
                                <dd style="margin-left: 180px;">hello@dummy.com</dd>
                        </div>
                    </div>
                </div>
                <div style="width:45%" class="col-xs-7 invoice-body-col-xs-7 invoice-body-custom-inner-col-7">
                    <div style="border: 1px solid #ddd; margin-bottom:20px; background-color: #fff; box-shadow: 0 1px 1px rgba(0,0,0,.05);" class="panel panel-default">
                        <div style=" background-color: #004686; color: #fff !important; padding: 10px 15px; border-bottom: 1px solid #ddd !important; border: 1px solid #ddd; border-top-left-radius: 3px; border-top-right-radius: 3px;" class="panel-heading">
                            <h3 style="color:#fff; font-weight:600;" class="panel-title">User Details</h3>
                        </div>
                        <div style=" padding: 15px;" class="panel-body">
                            <dl style="margin:0;" class="dl-horizontal">
                                <dt style="float: left;
                                            width: 160px;
                                            overflow: hidden;
                                            clear: left;
                                            text-align: right;
                                            text-overflow: ellipsis;
                                            white-space: nowrap;">Name</dt>
                                <dd style="margin-left: 180px;">{{$order->name}}</dd>
                                <dt style="float: left;
                                            width: 160px;
                                            overflow: hidden;
                                            clear: left;
                                            text-align: right;
                                            text-overflow: ellipsis;
                                            white-space: nowrap;">Email</dt>
                                <dd style="margin-left: 180px;">{{$order->email}}</dd>
                                <dt style="float: left;
                                            width: 160px;
                                            overflow: hidden;
                                            clear: left;
                                            text-align: right;
                                            text-overflow: ellipsis;
                                            white-space: nowrap;">Phone</dt>
                                <dd style="margin-left: 180px;">{{$order->phone}}</dd>
                                <dt style="float: left;
                                            width: 160px;
                                            overflow: hidden;
                                            clear: left;
                                            text-align: right;
                                            text-overflow: ellipsis;
                                            white-space: nowrap;">Street</dt>
                                <dd style="margin-left: 180px;">{{$order->street}}</dd>
                                <dt style="float: left;
                                            width: 160px;
                                            overflow: hidden;
                                            clear: left;
                                            text-align: right;
                                            text-overflow: ellipsis;
                                            white-space: nowrap;">City</dt>
                                <dd style="margin-left: 180px;">{{$order->city}}</dd>
                                <dt style="float: left;
                                            width: 160px;
                                            overflow: hidden;
                                            clear: left;
                                            text-align: right;
                                            text-overflow: ellipsis;
                                            white-space: nowrap;">State</dt>
                                <dd style="margin-left: 180px;">{{$order->state}}</dd>
                                <dt style="float: left;
                                            width: 160px;
                                            overflow: hidden;
                                            clear: left;
                                            text-align: right;
                                            text-overflow: ellipsis;
                                            white-space: nowrap;">Country</dt>
                                <dd style="margin-left: 180px;" class="mono">{{$order->country}}</dd>
                                <dt style="float: left;
                                            width: 160px;
                                            overflow: hidden;
                                            clear: left;
                                            text-align: right;
                                            text-overflow: ellipsis;
                                            white-space: nowrap;">Zip Code</dt>
                                <dd style="margin-left: 180px;">{{$order->zip_code}}</dd>
                        </div>
                    </div>
                </div>
            </div>
            <div style="border: 1px solid #ddd; margin-bottom: 20px; background-color: #fff; border-radius: 4px; box-shadow: 0 1px 1px rgba(0,0,0,.05);" class="panel panel-default panel-default-custom">
                <div style="   
                            background-color: #004686;
                            color: #fff !important; border: 1px solid #ddd;
                            padding: 10px 15px;
                            border-bottom: 1px solid transparent;
                            border-top-left-radius: 3px;
                            border-top-right-radius: 3px;" class="panel-heading">
                    <h3 style="font-weight: 600; color:#fff;" class="panel-title">Order #{{$order->order_id}}</h3>
                </div>
                <table class="table table-bordered table-condensed panel-default-custom-table">
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

                            $subtotal += abs($item->quantity * $item->unitcost);

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
                                <strong class="mono">${{ number_format(abs($item->quantity * $item->unitcost), 2, '.', ',')
                                    }}</strong>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel panel-default panel-default-for total ">
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
            <div class="row signature-row">
                <div class="col-xs-7 signature-row-col-7">
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
                <div class="col-xs-5 signature-row-col-5">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Payment Status</h3>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled">
                                <li>Recived Payment- <span class="mono">${{ number_format($finalPrice
                                        + (env("GST_HST_TAX",
                                        0) + env("PST_RST_QST_TAX", 0)), 2, '.', ',') }}</span></li>
                                <li>Pending Payment - <span class="mono"> ${{getTotalPendingPayment($order->order_id) }}</span></li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div style=" padding: 25px 25px 15px;" class="invoice-footer">
            Thank you for choosing our services.
            <br /> We hope to see you again soon
            <br />
        </div>
    </div>
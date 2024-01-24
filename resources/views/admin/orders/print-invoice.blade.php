<style>
    .print-pg-top-bar{
        background: #004686 !important;
        border-radius: 5px;
        padding: 5px;
        text-align: center;
    }

    .print-pg-top-bar p,
    .print-pg-top-bar p strong{
        color: #fff !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .invoice-container{
        border: 1px solid #8b8b8b;
        border-radius: 10px;
        padding: 20px 20px 0;
    }

    .thankyou-print{
        border-top: 1px solid #8b8b8b; 
        padding-top: 5px;
        margin-top: 10px;
    }

    .thankyou-print p{
        text-align: center;
        font-weight: 600;
        font-size: 20px;
        padding: 0;
    }

    .table-pro-last table{
        width: 100%;
        margin-top: 15px;
        margin-bottom: 5px;
        border: 1px solid #8b8b8b;
        border-radius: 5px;
        overflow: hidden;
        padding: 0;
    }

    .table-pro-last table th{
        border: none !important;
        color: #fff;
        margin: 0;
    }

    .table-pro-last table th,
    .table-pro-last table td{
        text-align: left;
        padding: 3px 5px;
    }

    .print-admin-mn p{
        padding: 0;
        margin: 10px 0 0;
        font-size: 18px;
        font-weight: 600;
    }

    .list-unstyled{
        background: #bbb;
        border-radius: 10px;
        padding: 15px;
    }

    .list-unstyled li{
        list-style: none;
    }

    .list-unstyled li.text-to-print{
        margin-bottom: 4px;
    }

    .list-unstyled li.text-to-print span{
        text-transform: uppercase;
        color: #000;
        font-weight: 600;
    }

    .all-imgs{
        display: flex;
        gap: 1%;
        flex-wrap: wrap;
        row-gap: 10px;
    }

    .all-imgs img{
        width: 19.2%;
        height: 137px;
        object-fit: cover;
    }

    .signature-img-wd img{
        width: 40%;
        border: 1px solid #8b8b8b;
    }
</style>



<div class="card mx-4">
    <div class="card-body">
        <div class="container mb-5 mt-3 invoice-container">
            <div class="row px-4 d-flex align-items-baseline print-pg-top-bar">
                <p style="color: #7e8d9f;font-size: 20px;">Invoice >> <strong>ID: #{{ $order->invoice_no }}</strong></p>
            </div>

            <div class="container">

                <div class="row invoice-card">
                    <div class="col-md-12">
                        <div class="text-center print-admin-mn">
                            <i class="fab fa-mdb fa-4x ms-0" style="color:#5d9fc5 ;"></i>
                            <p class="pt-0">Sunrise Doors Admin</p>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            @if($order->user)
                            <div class="col-xl-8">
                                <ul class="list-unstyled">
                                    <li class="text-muted text-to-print">To: <span>{{
                                            @$order->user->name }}</span></li>
                                    <li class="text-muted text-sn-addrs">{{ @$order->user->address->street .' '.
                                        @$order->user->address->city }}</li>
                                    <li class="text-muted text-sn-addrs">{{@$order->user->address->state}} 
                                        {{@$order->user->address->country}}</li>
                                    <li class="text-muted text-sn-addrs"><i class="fas fa-phone"></i> {{
                                        @$order->user->phone }}</li>
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row my-2 mx-1 justify-content-center table-pro-last">
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

                        @if ($recentSignature)
                        <div class="mt-4">
                            <h4>Images:</h4>
                            <div class="all-imgs">
                            @if ($recentSignature->images)
                            @foreach (json_decode($recentSignature->images) as $singleImage)
                            <img src="{{ asset('storage/images/' . basename($singleImage)) }}" alt="Recent Image">
                            @endforeach
                            @endif
                            </div>
                        </div>
                        <div class="mt-4 signature-img-wd">
                            <h4>Signature:</h4>
                            <img src="{{ asset('storage/signatures/' . $recentSignature->signature) }}"
                                alt="Recent Signature">
                        </div>
                        @endif
                        <br>
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
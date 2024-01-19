<div class="card mx-4">
    <div class="card-body">
        <div class="container mb-5 mt-3">
            <div class="row px-4 d-flex align-items-baseline print-pg-top-bar">
                <p style="color: #7e8d9f;font-size: 20px;">Invoice >> <strong>ID: #{{ $order->invoice_no }}</strong></p>
            </div>

            <div class="container">

                <div class="row invoice-card">
                    <div class="col-md-12">
                        <div class="text-center print-admin-mn">
                            <i class="fab fa-mdb fa-4x ms-0" style="color:#5d9fc5 ;"></i>
                            <p class="pt-0">Sunrise Door Admin</p>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            @if($order->user)
                            <div class="col-xl-8">
                                <ul class="list-unstyled">
                                    <li class="text-muted text-to-print">To: <span style="color:#5d9fc5 ;">{{
                                            @$order->user->name }}</span></li>
                                    <li class="text-muted text-sn-addrs">{{ @$order->user->address->street .' '.
                                        @$order->user->address->city }}</li>
                                    <li class="text-muted text-sn-addrs">{{@$order->user->address->state}},
                                        {{@$order->user->address->country}}</li>
                                    <li class="text-muted text-sn-addrs"><i class="fas fa-phone"></i> {{
                                        @$order->user->phone }}</li>
                                </ul>
                            </div>
                            @endif
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

                        @if ($recentSignature)
                        <div class="mt-4">
                            <h4>Recent Images:</h4>
                            @if ($recentSignature->images)
                            @foreach (json_decode($recentSignature->images) as $singleImage)
                            <img src="{{ asset('storage/images/' . basename($singleImage)) }}" alt="Recent Image">
                            @endforeach
                            @endif
                        </div>
                        <div class="mt-4">
                            <h4>Recent Signature:</h4>
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
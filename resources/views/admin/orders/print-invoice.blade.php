@extends('admin.layouts.app')

@section('content')

<div class="card mx-4">
    <div class="card-body">
        <div class="container mb-5 mt-3">
            <div class="row px-4 d-flex align-items-baseline print-pg-top-bar">
                <p style="color: #7e8d9f;font-size: 20px;">Invoice >> <strong>ID: #{{ $order->invoice_no }}</strong></p>
            </div>

            <div class="container">
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
@endsection
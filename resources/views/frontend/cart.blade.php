@extends('frontend.layouts.app')

@section('content')
@if(session()->has('cart') && !empty(session('cart')))
<table id="cart" class="table table-hover table-condensed cart-table">
    <thead>
        <tr>
            <th style="width:50%">Product</th>
            <th style="width:10%">Price</th>
            <th style="width:8%">Quantity</th>
            <th style="width:10%"></th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0;
        @endphp
        @if(session('cart'))
        @foreach(session('cart') as $id => $details)
        @php $total += $details['variant_price'] * $details['quantity'] @endphp

        <tr data-id="{{ $id }}">
            <td data-th="Product">
                <div class="row">
                    <div class="col-sm-3 hidden-xs"><img src="{{asset('frontend/img/product/details/product-details-1.jpg')}}" width="100" height="100" class="img-responsive" /></div>
                    <div class="col-sm-9">
                        <h4 class="nomargin">{{ $details['name'] }}</h4>
                        @if(isset($details['variant_data']))
                        @foreach($details['variant_data'] as $variant)
                        <span class="cart-price-btm">

                            <b>Type:</b> <span>{{$variant['name']}} </span>
                            <!-- <b>Quantity:{{$variant['quantity']}} </b> -->

                        </span>
                        @endforeach
                        @endif
                    </div>
                </div>
            </td>
            <td data-th="Price">${{ $details['variant_price'] }}</td>
            <td data-th="Quantity">
                <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity update-cart" />
            </td>

            <td class="actions" data-th="">
                <button class="btn btn-danger btn-sm remove-from-cart"><i class="fa fa-trash-o"></i></button>
            </td>
        </tr>

        @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="text-right">
                <h3><strong>Total ${{ $total }}</strong></h3>
            </td>
        </tr>
        <tr>
            <td colspan="5" class="text-right">
                <a href="{{ url()->previous() }}" class="btn btn-warning" style="background: #93681a; color: #fff; border-color: #93681a;"><i class="fa fa-angle-left"></i> Continue Shopping</a>
                <a href="{{ route('checkout.order') }}" class="btn btn-success">Checkout</a>
            </td>
        </tr>
    </tfoot>
</table>
@else
<section class="featured spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Cart is empty!</h2>
                </div>
            </div>
        </div>
</section>
@endif
@endsection
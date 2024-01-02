@extends('frontend.layouts.app')

@section('content')
@if(session()->has('cart') && !empty(session('cart')))
<table id="cart" class="table table-hover table-condensed cart-table">
    <thead>
        <tr>
            <th style="width:50%">Product</th>
            <th style="width:10%">Price</th>
            <th style="width:8%">Quantity</th>
            <th style="width:10%">SubTotal</th>
            <th style="width:10%"></th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0;
        @endphp
        @if(session('cart'))
        @foreach(session('cart') as $id => $details)
        @if(isset($details['variant_price']))
        <!-- if product with multiple variants -->
        @if(isset($details['variant_data']))
        @foreach($details['variant_data'] as $variantId => $subVariant)
        @php $total += $subVariant['price'] * $subVariant['quantity'] @endphp
        <tr data-id="{{ $id }}" data-variant="{{$variantId}}">
            <td data-th="Product">
                <div class="row">
                    <div class="col-sm-3 hidden-xs"><img src="{{asset('frontend/img/product/details/product-details-1.jpg')}}" width="100" height="100" class="img-responsive" /></div>
                    <div class="col-sm-9">
                        <h4 class="nomargin">{{ $details['name'] }}</h4>
                        <span class="cart-price-btm">
                            <b>Type:</b> <span>{{($subVariant['name'] != '') ? $subVariant['name'] : ''}} </span>
                        </span>
                    </div>
                </div>
            </td>
            <td data-th="Price">${{ $subVariant['price'] }}</td>
            <td data-th="Quantity">
                <input type="number" value="{{ $subVariant['quantity'] }}" class="form-control quantity update-cart" />
            </td>
            <td data-th="SubTotal">
                ${{ ($subVariant['price'] * $subVariant['quantity']) }}
            </td>
            <td class="actions" data-th="">
                <button class="btn btn-danger btn-sm remove-from-cart"><i class="fa fa-trash-o"></i></button>
            </td>
        </tr>
        @endforeach

        @else
        @php $total += (isset($details['variant_price']) ? $details['variant_price'] : $details['price']) * $details['quantity'] @endphp
        <tr data-id="{{ $id }}" data-variant="">
            <td data-th="Product">
                <div class="row">
                    <div class="col-sm-3 hidden-xs"><img src="{{asset('frontend/img/product/details/product-details-1.jpg')}}" width="100" height="100" class="img-responsive" /></div>
                    <div class="col-sm-9">
                        <h4 class="nomargin">{{ $details['name'] }}</h4>
                        @if(isset($details['variant_data']))
                        @foreach($details['variant_data'] as $variant)
                        <span class="cart-price-btm">
                            <b>Type:</b> <span>{{($variant['name'] != '') ? $variant['name'] : ''}} </span>
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
            <td data-th="SubTotal">
                ${{ ($details['variant_price'] * $details['quantity']) }}
            </td>

            <td class="actions" data-th="">
                <button class="btn btn-danger btn-sm remove-from-cart"><i class="fa fa-trash-o"></i></button>
            </td>
        </tr>
        @endif
        @endif
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
                <a href="{{ route('checkout.order') }}" class="btn btn-success">Proceed To Accounte</a>
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
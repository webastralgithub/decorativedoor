@extends('frontend.layouts.app')

@section('content')

@if (session()->has('cart') && !empty(session('cart')))
<table id="cart" class="table table-hover table-condensed cart-table mt-5">
    <thead>
        <tr>
            <th style="width:50%">Product</th>
            <th style="width:10%">Price</th>
            <th style="width:8%">Quantity</th>
            <th style="width:8%">Discount</th>
            <th style="width:10%">SubTotal</th>
            <th style="width:10%"></th>
        </tr>
    </thead>
    <tbody>
        @php
        $total = 0;
        @endphp
        @if (session('cart'))
        @foreach (session('cart') as $id => $details)
        @if (isset($details['variant_price']))
        <!-- if product with multiple variants -->
        @if (isset($details['variant_data']))

        @foreach ($details['variant_data'] as $variantId => $subVariant)
        @php
        $total += $subVariant['price'] * $subVariant['quantity'] - ($subVariant['discount_price'] * $subVariant['quantity']) @endphp
        <tr data-id="{{ $id }}" data-variant="{{ $variantId }}">
            <td data-th="Product">
                <div class="row">
                    <div class="col-sm-3 hidden-xs">

                        @if($details['image']['path'])
                        <img src="{{ asset('storage/products/' .$details['image']['path'])}}" width="100" height="100" class="img-responsive" />
                        @else
                        <img src="{{ asset('frontend/img/product/details/product-details-1.jpg') }}" width="100" height="100" class="img-responsive" />
                        @endif
                    </div>
                    <div class="col-sm-9">
                        <h4 class="nomargin">{{ $details['name'] }}</h4>
                        <span class="cart-price-btm">
                            <b>Type:</b>
                            <span>{{ $subVariant['name'] != '' ? $subVariant['name'] : '' }}
                            </span>
                        </span>
                    </div>
                </div>
            </td>
            <td data-th="Price">${{ number_format($subVariant['price'], 2, '.', ',') }}</td>
            <td data-th="Quantity">
                <input type="number" value="{{ (getProductAvailabityStock($details['product_id'] > $subVariant['quantity'])) ? getProductAvailabityStock($details['product_id']) : $subVariant['quantity'] }}" class="form-control quantity update-cart" />
            </td>
            <td data-th="discount">
                {{ $subVariant['discount_price'] ? $subVariant['discount_price'] : 0 }}
            </td>
            <td data-th="SubTotal">
                ${{ number_format($subVariant['price'] * $subVariant['quantity'] - $subVariant['discount_price'] * $subVariant['quantity'], 2, '.', ',') }}
            </td>
            <td class="actions" data-th="">
                <button class="btn btn-danger btn-sm remove-from-cart"><i class="fa fa-trash-o"></i></button>
            </td>
        </tr>
        @endforeach
        @else
        @php
        $total += (isset($details['variant_price']) ? $details['variant_price'] - $details['discount_price'] : $details['price']) * $details['quantity'] - ($details['discount_price'] * $details['quantity']) @endphp
        <tr data-id="{{ $id }}" data-variant="">
            <td data-th="Product">
                <div class="row">
                    <div class="col-sm-3 hidden-xs"><img src="{{ asset('frontend/img/product/details/product-details-1.jpg') }}" width="100" height="100" class="img-responsive" /></div>
                    <div class="col-sm-9">
                        <h4 class="nomargin">{{ $details['name'] }}</h4>
                        @if (isset($details['variant_data']))
                        @foreach ($details['variant_data'] as $variant)
                        <span class="cart-price-btm">
                            <b>Type:</b>
                            <span>{{ $variant['name'] != '' ? $variant['name'] : '' }}
                            </span>
                            <!-- <b>Quantity:{{ $variant['quantity'] }} </b> -->
                        </span>
                        @endforeach
                        @endif
                    </div>
                </div>
            </td>
            <td data-th="Price">${{ number_format($details['variant_price'], 2, '.', ',') }}</td>
            <td data-th="Quantity">
                <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity update-cart" />
            </td>
            <td data-th="SubTotal">
                ${{ numer_format($details['variant_price'] * $details['quantity'], 2, '.', ',') }}
            </td>

            <td class="actions" data-th="">
                <button class="btn btn-danger btn-sm remove-from-cart"><i class="fa fa-trash-o"></i></button>
            </td>
        </tr>
        @endif
        @else

        @php
        $total += $details['price'] * $details['quantity'] - ($details['discount_price'] * $details['quantity']); @endphp
        <tr data-id="{{ $id }}" data-variant="">
            <td data-th="Product">
                <div class="row">
                    <div class="col-sm-3 hidden-xs">
                        <img src="{{ asset('frontend/img/product/details/product-details-1.jpg') }}" width="100" height="100" class="img-responsive" />
                    </div>
                    <div class="col-sm-9">
                        <h4 class="nomargin">{{ $details['name'] }}</h4>
                    </div>
                </div>
            </td>
            <td data-th="Price">${{ number_format($details['price'], 2, '.', ',') }}</td>
            <td data-th="Quantity">
                <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity update-cart" />
            </td>
            <td data-th="Discount">{{ $details['discount_price'] ? $details['discount_price'] : 0 }}
            </td>
            <td data-th="SubTotal">
                ${{ number_format($details['price'] * $details['quantity'] - $details['discount_price'] * $details['quantity'], 2, '.', ',') }}
            </td>
            <td class="actions" data-th="">
                <button class="btn btn-danger btn-sm remove-from-cart"><i class="fa fa-trash-o"></i></button>
            </td>
        </tr>
        @endif
        @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="text-right">
                <h3><strong>Total ${{ number_format($total, 2, '.', ',') }}</strong></h3>
            </td>
        </tr>
        <tr>
            <td colspan="5" class="text-right cart-page-btm-btns">
                <a href="{{ url()->previous() }}" class="btn btn-warning" style="background: #93681a; color: #fff; border-color: #93681a;"><i class="fa fa-angle-left"></i> Continue Shopping</a>
                <div id="place-order-btn">
                    @if(empty(session()->get('assign_customer')))
                    <button class="btn btn-success" data-toggle="modal" data-target="#assignuser">Proceed Order</button>
                    @else
                    <a href="{{ route('checkout.order') }}" class="btn btn-success">Proceed Order</a>
                    @endif
                </div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="modal fade" id="assignuser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Assign Customer') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                <a href="{{ route('customer') }}" class="btn btn-success">Add New Customer</a><br>

                <div class="cart-pop-up-table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td><input type="checkbox" class="customerassign" data-id="{{$user->id}}"></td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">{{ __('Close') }}</button>
                    </div> -->
        </div>
    </div>
</div>

<div id="productDiscountMessage" class="product-discount-message" style="display:none"></div>
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
@extends('frontend.layouts.app')

@section('content')
<table id="cart" class="table table-hover table-condensed cart-table">

    <thead>

    <tr>

        <th style="width:50%">Product</th>

        <th style="width:10%">Price</th>

        <th style="width:8%">Quantity</th>

        <th style="width:22%" class="text-center">Subtotal</th>

        <th style="width:10%"></th>

    </tr>

    </thead>

    <tbody>

    @php $total = 0;
    @endphp
      
    @if(session('cart'))

        @foreach(session('cart') as $id => $details)
            @php $total += $details['price'] * $details['quantity'] + $details['variant_price'] @endphp

            <tr data-id="{{ $id }}">

                <td data-th="Product">

                    <div class="row">

                        <div class="col-sm-3 hidden-xs"><img src="{{asset('frontend/img/product/details/product-details-1.jpg')}}" width="100" height="100"
                                                             class="img-responsive"/></div>

                        <div class="col-sm-9">

                            <h4 class="nomargin">{{ $details['name'] }}</h4>

                        </div>

                    </div>

                </td>

                <td data-th="Price">${{ $details['price'] }}</td>

                <td data-th="Quantity">

                    <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity update-cart"/>

                </td>

                <td data-th="Subtotal" class="text-center">${{ $details['price'] * $details['quantity'] + $details['variant_price'] }}</td>

                <td class="actions" data-th="">

                    <button class="btn btn-danger btn-sm remove-from-cart"><i class="fa fa-trash-o"></i></button>

                </td>
            </tr>

            <tr class="cart-price-btm">
                <td><h3>Variants</h3></td>
                <td data-th="Price">
                    <ul data-id="">
                        <li>
                            <b>Name:</b> <span></span>
                        </li>
                    </ul>
                </td>

                <td data-th="Price">
                    <ul data-id="">
                        <li>
                            <span></span>
                        </li>
                    </ul>
                </td>
             

                <td data-th="Price">
                    <ul data-id="">
                        <li>
                            <b>Quantity:</b>
                        </li>
                    </ul>
                </td>
                <td data-th="Price">
                    <ul data-id="">
                        <li>
                            <input type="number" value="" class="form-control quantity add-on" data-variant-id=""/>
                        </li>
                    </ul>
                </td>
            </tr>



                <!-- <div class="product-variants">
                <div class="product-variants-price" >
                    <h3>Main Product</h3>

                    <h3>Variants</h3>fg
                    <ul data-id="">
                        <li>
                            <b>Name:</b> <span></span>
                        </li>
                        <li>
                            <b>Quantity:</b>
                            <input type="number" value="" class="form-control quantity add-on" data-variant-id=""/>
                        </li>
                    </ul>
                </div>
                </div> -->
        @endforeach

    @endif

    </tbody>

    <tfoot>

    <tr>

        <td colspan="5" class="text-right"><h3><strong>Total ${{ $total }}</strong></h3></td>

    </tr>

    <tr>

        <td colspan="5" class="text-right">

            <a href="{{ url('/') }}" class="btn btn-warning" style="background: #93681a; color: #fff; border-color: #93681a;"><i class="fa fa-angle-left"></i> Continue Shopping</a>

            <button class="btn btn-success">Checkout</button>

        </td>

    </tr>

    </tfoot>

</table>






@endsection

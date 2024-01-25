@extends('frontend.layouts.app')

@section('content')
    <style>
        .cart-summary-contain {
            margin: 0;
            border: 1px solid #c9c9c9;
            border-radius: 8px;
            padding: 29px 15px;
        }

        .cart-summary-contain .product__details__pic__item {
            margin-bottom: 0;
        }

        .product__details__text-summary {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .product__details__text-summary p {
            width: 100%;
            margin-bottom: 20px;
        }

        .variants-ul {
            margin-top: 0;
            padding-top: 0;
            border: none;
            display: flex;
            column-gap: 30px;
            flex-wrap: wrap;
            width: 100%;
        }

        .variants-ul .Variantsl-li {
            width: 100%;
            border-bottom: 1px solid #c9c9c9;
            margin-bottom: 11px;
        }

        .variants-ul li {
            font-size: 14px !important;
            line-height: 27px !important;
        }

        .variants-ul .Variantsl-li b {
            font-size: 20px;
        }

        .variants-ul li b {
            width: auto !important;
            margin-right: 9px;
        }

        .product__details__text-summary h3 {
            margin-bottom: 10px;
            font-size: 23px;
        }

        .product__details__text-summary .product__details__price {
            margin-bottom: 0px;
        }

        .product__details__text-summary .product__details__price span{
            color: #000;
    font-size: 19px;
    line-height: 44px;
    margin-bottom: -4px;
        }

        .cart-top-bar-added{
            border-bottom: 1px solid #cbcbcb;
            padding-bottom: 17px;
            margin-bottom: 20px;
        }

        .cart-top-bar-added .row{
            align-items: center;
        }

        .cart-top-bar-added .row h5{
            font-size: 21px;
            align-items: center;
            display: flex;
            gap: 10px;
            font-weight: 600;
        }

        .cart-top-bar-added .row h5 svg{
            color: #178c32;
            width: 25px;
            height: 25px;
        }

        .cart-top-bar-added .cart-top-bar-added-right{
            justify-content: flex-end;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .cart-top-bar-added .cart-top-bar-added-right a:first-child{
            background: #434e6e;
            color: #fff;
        }

        .cart-top-bar-added .cart-top-bar-added-right a{
            padding: 8px 20px;
            background: #434e6e;
            border: none;
            border-radius: 5px;
            color: #fff;
        }

        .cart-sucess-pg-btm-summary{
            align-items: center;
        }

        .cart-sucess-pg-btm-summary .product__details__price{
            margin-top: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cart-sucess-pg-btm-summary .product__details__text.product__details__text-summary h3{
            margin-bottom: 0;
            line-height: 45px;
        }

        @media only screen and (max-width: 900px) {
            .product__details__text-summary {
                flex-direction: column;
            }
        }

        @media only screen and (max-width: 600px) {
            .cart-top-bar-added .cart-top-bar-added-right {
                justify-content: flex-end;
                display: flex;
                align-items: center;
                gap: 20px;
                margin-top: 20px;
            }
        }

        .product__details__pic__item {
            width: 100%;
            height: 110px;
        }
    </style>

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-md-10"></div>
                <div class="col-md-2 mb-2">
                   
                </div>
                <div class="col-md-12">
                    <div class="row cart-summary-contain">
                        @foreach ($succescart as $cart)
                        <div class="col-lg-12 cart-top-bar-added">
                           <div class="row">
                            <div class="col-lg-6">
                                <h5><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
    </svg> Added to Cart</h5>
                            </div> 

                            <div class="col-lg-6 cart-top-bar-added-right">
                                <!-- <a href="{{ route('cart') }}">Cart ({{ $cart['quantity'] }} Item)</a> -->
                                <a href="{{ route('cart') }}" class="btn btn-success cart-btn">Cart ({{ $cart['quantity'] }} Item)</a>
                            </div>
                           </div> 
                        </div>

                        <div class="col-lg-12">
                           <div class="row cart-sucess-pg-btm-summary">
                        <div class="col-lg-2 col-md-6">
                            <div class="product__details__pic">
                                <div class="product__details__pic__item">
                                    @if($cart['image']['path'])
                                        <img class="product__details__pic__item--large" src="{{ asset('storage/products/' .$cart['image']['path'])}}" width="100" height="100" class="img-responsive" />
                                    @else
                                        <img class="product__details__pic__item--large" src="{{ asset('frontend/img/product/details/product-details-1.jpg') }}" width="100" height="100" class="img-responsive" />
                                    @endif
                                </div>
                            </div>
                        </div>
                      
                            @if (!empty($cart['variant_data']))
                                @foreach ($cart['variant_data'] as $variation)
                                    <div class="col-lg-10 col-md-6">
                                        <div class="product__details__text product__details__text-summary">
                                            <h3>{{ $cart['name'] }}</h3>
                                            <div class="product__details__price">
                                                <span><b>Cart subtotal</b> ({{ $variation['quantity'] }} item)</span>
                                                ${{ $variation['price'] * $variation['quantity']}}
                                            </div>
                                        
                                            <ul class="variants-ul" style="margin-top: 0;padding-top: 0;border: none;">
                                                <li class="Variantsl-li">
                                                    <b>Variants</b>
                                                </li>

                                                <li><b>Quantity</b> <span>{{ $variation['quantity'] }}</span></li>
                                                <li><b>Size</b> <span>{{ $variation['name'] }}</span></li>
                                                <li><b>Type of Door</b> <span>{{ \App\Models\TypeOfDoor::find($cart['doortype'])->name }}</span></li>
                                                <li><b>Type of Location</b> <span>{{ \App\Models\LocationOfDoor::find($cart['doorlocation'])->name }}</span></li>
                                                <li><b>Jamb</b> <span>{{  \App\Models\Jamb::find($cart['doorjamb'])->name }}</span></li>
                                                <li><b>Left</b> <span>{{  \App\Models\Left::find($cart['doorleft'])->name }}</span></li>
                                                <li><b>Right</b> <span>{{  \App\Models\Right::find($cart['doorright'])->name }}</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                            </div> 
                            </div>



                                <div class="col-lg-10 col-md-6">
                                    <div class="product__details__text product__details__text-summary">
                                        <h3>{{ $cart['name'] }}</h3>
                                        <div class="product__details__price">${{ $cart['price'] * $cart['quantity'] }}</div>
                                        <p>{!! $cart['description'] !!}</p>

                                        <ul class="variants-ul" style="margin-top: 0;padding-top: 0;border: none;">
                                            <li><b>Quantity</b> <span>{{ $cart['quantity'] }}</span></li>
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>   
        </div>
    </section>
    
@endsection


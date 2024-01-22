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
            font-size: 25px;
        }

        .product__details__text-summary .product__details__price {
            margin-bottom: 0px;
        }

        @media only screen and (max-width: 900px) {
            .product__details__text-summary {
                flex-direction: column;
            }
        }

        .product__details__pic__item {
            width: 100%;
            height: 200px;
        }
    </style>

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-md-10"></div>
                <div class="col-md-2 mb-2">
                    <a href="{{ route('cart') }}" class="btn btn-success">Go To Cart</a>
                </div>
                <div class="col-md-12">
                    <div class="row cart-summary-contain">
                        @foreach ($succescart as $cart)
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
                                            <div class="product__details__price">${{ $variation['price'] * $variation['quantity']}}</div>
                                            <p>{!! $cart['description'] !!}</p>

                                            <ul class="variants-ul" style="margin-top: 0;padding-top: 0;border: none;">
                                                <li class="Variantsl-li">
                                                    <b>Variants</b>
                                                </li>

                                                <li><b>Quantity</b> <span>{{ $variation['quantity'] }}</span></li>
                                                <li><b>Size</b> <span>{{ $variation['name'] }}</span></li>

                                            </ul>
                                        </div>
                                    </div>
                                @endforeach
                            @else
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


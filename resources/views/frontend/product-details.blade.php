@extends('frontend.layouts.app')


@section('content')
<!-- Hero Section Begin -->
@include('frontend.layouts.include.search-bar')
<!-- Hero Section End -->

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{asset('frontend/img/breadcrumb.jpg')}}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>{{$product->title}}</h2>
                    <div class="breadcrumb__option">
                        <a href="./index.html">Home</a>
                        <span>Product-detail</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Product Details Section Begin -->
@if(!empty($product->variants) && isset($product->variants))
@php
$variantSingle = $product->variants;
$variantSingle = $variantSingle->first();
$variantOptions = (isset($variantSingle->option_type) && !empty($variantSingle->option_type)) ? json_decode($variantSingle->option_type, true) : null;
@endphp
@endif
<section class="product-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="product__details__pic">
                    <div class="product__details__pic__item">
                        <img class="product__details__pic__item--large" src="{{asset('frontend/img/product/details/product-details-1.jpg')}}" alt="">
                    </div>
                    <div class="product__details__pic__slider owl-carousel">
                        <img data-imgbigurl="{{asset('frontend/img/product/details/product-details-1.jpg')}}" src="{{asset('frontend/img/product/details/product-details-1.jpg')}}" alt="">
                        <img data-imgbigurl="{{asset('frontend/img/product/details/product-details-1.jpg')}}" src="{{asset('frontend/img/product/details/product-details-1.jpg')}}" alt="">
                        <img data-imgbigurl="{{asset('frontend/img/product/details/product-details-1.jpg')}}" src="{{asset('frontend/img/product/details/product-details-1.jpg')}}" alt="">
                        <img data-imgbigurl="{{asset('frontend/img/product/details/product-details-1.jpg')}}" src="{{asset('frontend/img/product/details/product-details-1.jpg')}}" alt="">
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <input type="hidden" name="slug" value="{{$product->slug}}">
                <div class="product__details__text">
                    <h3>{{$product->title}}</h3>
                    <div class="product__details__rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-half-o"></i>
                        <span>(18 reviews)</span>
                    </div>
                    <div class="product__details__price" id="main-price">
                        ${{number_format($product->buying_price, 2, '.', ',')}}
                    </div>
                    <p>{!!$product->short_description!!}</p>

                    @if(!empty($product->variants) && !empty($variantOptions))
                    <div class="varients-cart">
                        <h3>Variants</h3>
                        <div class="varients-block-flex">
                            @foreach($variantOptions as $variantCombination)
                            <div class="row varient-block-cn">
                                <div class="col-sm-6"><label>{{ucwords($variantCombination['variantType'])}}</label></div>
                                <div class="col-sm-6">
                                    <select class="variants">
                                        <option disabled selected value="0">Select {{ucwords($variantCombination['variantType'])}}</option>
                                        @foreach($variantCombination['tagNames'] as $key => $tags)
                                        <option value="{{$tags}}">{{ucwords($tags)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>
                    @endif
                    <form method="POST" action="{{ route('add.to.cart') }}" id="addToCartForm" class="form-cart-btn">
                        @csrf
                        <!-- @method('POST') -->
                        <div class="product__details__quantity">
                            <div class="quantity">
                                <div class="pro-qty">
                                    <tr data-id="{{$product->id}}">
                                    </tr>
                                    <input type="number" min="0" value="1" class="quantity " name="quantity">
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="variant" class="product-variant-data" value="{{json_encode($variantSingle)}}" />
                        <input type="hidden" name="product_id" value="{{$product->id}}" />
                        <button type="submit" class="primary-btn add-to-cart" onclick="return addToCart(event)" @disabled(getProductAvailabityStock($product->id) <= 0)>ADD TO CART</button>
                        <a href="#" id="share-with-email" class="btn primary-btn" data-toggle="modal" data-target="#exampleModal">Share <i class="fa fa-share"></i></a>    
                    </form>
                    <!-- <a href="{{ route('add.to.cart', $product->id) }}" class="primary-btn">ADD TO CART</a> -->
                    <!-- <a href="#" class="heart-icon"><span class="icon_heart_alt"></span></a> -->
                    <li><b>Availability</b> <span id="availability">{{( getProductAvailabityStock($product->id) > 0 ) ? 'In' : 'Out of'}} Stock</span></li>
                    <!-- <li><b>Shipping</b> <span>01 day shipping. <samp>Free pickup today</samp></span></li> -->

                    <!-- <li><b>Qunatity</b> <span>{{ getProductAvailabityStock($product->id) }}</span></li> -->
                    <!-- <li><b>Description</b> <span>{{$product->notes}}</span></li> -->
                    <!-- <li><b>Share on</b>
                            <div class="share">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                                <a href="#"><i class="fa fa-pinterest"></i></a>
                            </div>
                        </li> -->

                    </ul>
                </div>
                <!-- <form method="POST" action="{{ route('add.to.cart') }}" class="form-cart-btn">
                    <input type="hidden" name="variant" class="product-variant-data" value="{{json_encode($variantSingle)}}" />
                    <input type="hidden" name="product_id" value="{{$product->id}}" />
                    <button type="submit" class="primary-btn add-to-cart">ADD TO CART</button>
                </form> -->
                <!-- <a href="#" class="heart-icon"><span class="icon_heart_alt"></span></a> -->
                <!-- <ul>
                    <li><b>Availability</b> <span>In Stock</span></li>
                    <li><b>Shipping</b> <span>01 day shipping. <samp>Free pickup today</samp></span></li>
                    <li><b>Qunatity</b> <span>{{$product->quantity}}</span></li>
                    <li><b>Share on</b>
                        <div class="share">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-pinterest"></i></a>
                        </div>
                    </li>
                    <h3>Variants</h3> 
                    @if(!empty($product->variants))
                    @forelse($product->variants as $key => $variant)
                    <ul data-id="{{ $variant->id }}">
                        @php
                        if(session()->has('cart') &&
                        isset(session('cart')[$product->id]['variant_id']) &&
                        isset(session('cart')[$product->id]['variant_id'][$variant->id]['quantity'])) {
                        $quantity = session('cart')[$product->id]['variant_id'][$variant->id]['quantity'];
                        } else {
                        // Handle case where the keys or values are not set
                        $quantity = 0; // or any default value you prefer
                        } @endphp
                        <li><b>Name</b> <span>{{$variant->name}}</span></li>
                        <li><b>Quantity</b><input type="number" value="{{$quantity ?? 0}}" class="form-control quantity add-on" />
                        </li>
                    </ul>
                    @empty
                    No data
                    @endforelse
                    @endif
                </ul> -->

            </div>
            <div class="col-lg-12">
                @include('frontend.add-ons')
            </div>
            <div class="col-lg-12">
                <div class="product__details__tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab" aria-selected="true">Description</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab" aria-selected="false">Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab" aria-selected="false">Reviews <span>(1)</span></a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Products Infomation</h6>
                                <p>{!!$product->notes!!}</p>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabs-2" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Products Infomation</h6>
                                <p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.
                                    Pellentesque in ipsum id orci porta dapibus. Proin eget tortor risus.
                                    Vivamus suscipit tortor eget felis porttitor volutpat. Vestibulum ac diam
                                    sit amet quam vehicula elementum sed sit amet dui. Donec rutrum congue leo
                                    eget malesuada. Vivamus suscipit tortor eget felis porttitor volutpat.
                                    Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Praesent
                                    sapien massa, convallis a pellentesque nec, egestas non nisi. Vestibulum ac
                                    diam sit amet quam vehicula elementum sed sit amet dui. Vestibulum ante
                                    ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
                                    Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.
                                    Proin eget tortor risus.</p>
                                <p>Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Lorem
                                    ipsum dolor sit amet, consectetur adipiscing elit. Mauris blandit aliquet
                                    elit, eget tincidunt nibh pulvinar a. Cras ultricies ligula sed magna dictum
                                    porta. Cras ultricies ligula sed magna dictum porta. Sed porttitor lectus
                                    nibh. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.</p>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabs-3" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Products Infomation</h6>
                                <p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.
                                    Pellentesque in ipsum id orci porta dapibus. Proin eget tortor risus.
                                    Vivamus suscipit tortor eget felis porttitor volutpat. Vestibulum ac diam
                                    sit amet quam vehicula elementum sed sit amet dui. Donec rutrum congue leo
                                    eget malesuada. Vivamus suscipit tortor eget felis porttitor volutpat.
                                    Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Praesent
                                    sapien massa, convallis a pellentesque nec, egestas non nisi. Vestibulum ac
                                    diam sit amet quam vehicula elementum sed sit amet dui. Vestibulum ante
                                    ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
                                    Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.
                                    Proin eget tortor risus.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product Details Section End -->

<!-- Related Product Section Begin -->
<!-- <section class="related-product">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title related__product__title">
                    <h2>Related Product</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product__item">
                    <div class="product__item__pic set-bg" data-setbg="{{asset('frontend/img/featured/feature-1.jpg')}}">
                        <ul class="product__item__pic__hover">
                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="{{route('product',getRandomProductSlug())}}">Heavy Double Door</a></h6>
                        <h5>$76.000</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product__item">
                    <div class="product__item__pic set-bg" data-setbg="{{asset('frontend/img/featured/feature-1.jpg')}}">
                        <ul class="product__item__pic__hover">
                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="{{route('product',getRandomProductSlug())}}">Heavy Double Door</a></h6>
                        <h5>$76.000</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product__item">
                    <div class="product__item__pic set-bg" data-setbg="{{asset('frontend/img/featured/feature-1.jpg')}}">
                        <ul class="product__item__pic__hover">
                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="{{route('product',getRandomProductSlug())}}">Heavy Double Door</a></h6>
                        <h5>$76.000</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product__item">
                    <div class="product__item__pic set-bg" data-setbg="{{asset('frontend/img/featured/feature-1.jpg')}}">
                        <ul class="product__item__pic__hover">
                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="{{route('product',getRandomProductSlug())}}">Heavy Double Door</a></h6>
                        <h5>$76.000</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->
<!-- Related Product Section End -->



<!-- Modal share with email -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Product Share With Customer</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="shareForm" class="sahre-product-popup" method="Post">
                @csrf
                @method('POST')
                <div class="mb-3 row">
                    <div class="col-md-12 flex">
                        <label for="email" class="col-md-3 col-form-label text-md-end text-start">
                            {{ __('Email') }}
                            <span class="text-danger">*</span>
                        </label>
                        <input type="hidden" id="product_id" name="product_id" value=" {{ $product->id }}">
                        <div class="col-md-12">
                            <input name="email" id="email" type="email" class="form-control example-date-input" value="{{ old('email') }}" required>
                        </div>
                        <div class="col-md-12 mt-3">
                            <input name="submit" id="share" type="submit" class="form-control btn primary-btn" value="{{ _('Share') }}">
                        </div>
                        <span id="message"></div>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function addToCart(event) {
        var allVariants = document.querySelectorAll('.variants');
        var selectedVariants = [];
        // Iterate through all variant dropdowns
        allVariants.forEach(function(variant) {
            var selectedValue = variant.value;
            console.log("selectedValue", selectedValue);
            // Check if the variant is selected
            if (selectedValue && selectedValue != '0') {
                selectedVariants.push(selectedValue);
            }
        });
        let checkStockAvailability = "{{ getProductAvailabityStock($product->id) }}";
        console.log("checkStockAvailability::", checkStockAvailability, "selectedVariants", selectedVariants.length);
        if (checkStockAvailability != 0) {
            // Check if all variants are selected
            if (selectedVariants.length > 0 && selectedVariants.length === (allVariants.length / 2)) {
                document.getElementById('addToCartForm').submit();
            } else {
                event.preventDefault(event);
                document.getElementById('addToCartForm').disabled = true;

                allVariants.forEach(function(variant) {
                    variant.style.border = '2px solid red';
                });
                // alert('Please select all variants before adding to the cart.');
                return false;
            }
        }

        return false;
    }

    jQuery(document).ready(function () {
        jQuery('#shareForm').submit(function (e) {
            e.preventDefault();
            jQuery('div#loader-container').show();
            var csrfToken = $('input[name="_token"]').val();
            
            var productid = jQuery('#product_id').val();
            var email = jQuery('#email').val();
            var price = jQuery('#main-price').text();
            var selectvarient = jQuery('.nice-select.variants span.current').text();
            var url = "{{ route('share-product', $product->id) }}";
            jQuery.ajax({
                url: url,
                type: "Post",
                data: {
                    productid : productid,
                    email : email,
                    price : price,
                    selectvarient : selectvarient,
                    _token : csrfToken,
                },
                success: function (response) {
                    // Handle the success response here
                    console.log(response);
                    jQuery('div#loader-container').hide();
                    jQuery('#message').html('<span>Mail Send Successfilly!</span>');
                    setTimeout(() => {
                        jQuery('#message').hide();
                    }, 2000);
                   
                    jQuery('#email').val('');

                },
                error: function (xhr, status, error) {
                    // Handle the error response here
                    console.error(xhr.responseText);
                }
            });
        });
    });

</script>
@endsection
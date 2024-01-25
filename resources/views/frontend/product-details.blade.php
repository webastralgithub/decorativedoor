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
$variantOptions = (isset($variantSingle->option_type) && !empty($variantSingle->option_type)) ?
json_decode($variantSingle->option_type, true) : null;
@endphp
@endif
<section class="product-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="product__details__pic">
                    <div class="product__details__pic__item">
                        @if(isset($productimages) && !empty($productimages[0]))
                        <img class="product__details__pic__item--large"
                            src="{{ asset('storage/products/' . $productimages[0]['path'])}}" alt="">
                        @else
                        <img class="product__details__pic__item--large"
                            src="{{asset('frontend/img/product/details/product-details-1.jpg')}}" alt="">
                        @endif
                    </div>
                    @if(isset($productimages) && !empty($productimages))
                    <div class="product__details__pic__slider owl-carousel">
                        @foreach($productimages as $images)
                        <img data-imgbigurl="{{ asset('storage/products/' . $images->path)}}"
                            src="{{ asset('storage/products/' . $images->path)}}" alt="">
                        @endforeach
                    </div>
                    @endif
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
                        @if(isset(session()->get('discount')[$product->id]['discount_ammount']))
                        <del style="color: #625c5c;font-size: 18px;">${{number_format($product->selling_price, 2, '.',
                            ',')}}</del> <span>${{number_format($product->selling_price -
                            session()->get('discount')[$product->id]['discount_ammount'], 2, '.', ',')}}</span>
                        @else
                        ${{number_format($product->selling_price, 2, '.', ',')}}
                        @endif
                    </div>
                    @if(isset(session()->get('discount')[$product->id]['discount_ammount']))
                    <input type="hidden" id="discount_price"
                        value="{{session()->get('discount')[$product->id]['discount_ammount']}}">
                    @else
                    <input type="hidden" id="discount_price" value="">
                    @endif
                    <div id="productDiscountMessage" class="product-discount-message" style="display:none;"></div>
                    <p>{!!$product->short_description!!}</p>
                    <div class="col-8 varients-block-flex mb-3 p-0">
                        <label>Type of Door</label>
                        <select class="form-control" id="type-of-door" onchange="return doortype('{{$product->id}}')">
                            <option value="">Type of Door</option>
                            @if ( isset($product->categories[0]) && $product->categories[0]->jambs)
                            @foreach ($product->categories[0]->type_of_doors as $typeOfDoor)
                            <option value="{{ $typeOfDoor->name }}" {{ $product->type_of_door === $typeOfDoor->name ?
                                'selected' : '' }}>
                                {{ $typeOfDoor->name }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-8 varients-block-flex mb-3 p-0">
                        <label>Loaction of Door</label>
                        <select class="form-control" id="location-of-door"
                            onchange="return doorlocation('{{$product->id}}')">
                            @if ( isset($product->categories[0]) && $product->categories[0]->location_of_doors)
                            @foreach ($product->categories[0]->location_of_doors as $location_of_doors)
                            <option value="{{ $location_of_doors->name }}" {{ $product->location_of_doors ===
                                $location_of_doors->name ? 'selected' : '' }}>
                                {{ $location_of_doors->name }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-8 varients-block-flex mb-3 p-0">
                        <label>Jamb</label>
                        <select class="form-control" id="jamb" onchange="return doorjamb('{{$product->id}}')">
                            <option>JMB</option>
                            @if ( isset($product->categories[0]) && $product->categories[0]->jambs)
                            @foreach ($product->categories[0]->jambs as $jambs)
                            <option value="{{ $jambs->name }}" {{ $product->jambs === $jambs->name ? 'selected' : '' }}>
                                {{ $jambs->name }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-8 varients-block-flex mb-3 p-0">
                        <label>Right</label>
                        <select class="form-control" id="left" onchange="return doorleft('{{$product->id}}')">
                            <option>Left</option>
                            @if ( isset($product->categories[0]) && $product->categories[0]->lefts)
                            @foreach ($product->categories[0]->lefts as $lefts)
                            <option value="{{ $jambs->name }}" {{ $product->lefts === $lefts->name ? 'selected' : '' }}>
                                {{ $lefts->name }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-8 varients-block-flex mb-3 p-0">
                        <label>Left</label>
                        <select class="form-control" id="right" onchange="return doorright('{{$product->id}}')">
                            <option>Right</option>
                            @if (isset($product->categories[0]) && $product->categories[0]->rights)
                            @foreach ($product->categories[0]->rights as $rights)
                            <option value="{{ $jambs->name }}" {{ $product->rights === $rights->name ? 'selected' : ''
                                }}>
                                {{ $rights->name }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    @if(!empty($product->variants) && !empty($variantOptions))
                    <div class="varients-cart">
                        <h3>Variants</h3>
                        <div class="varients-block-flex">
                            @foreach($variantOptions as $variantCombination)
                            <div class="varient-block-cn">
                                <label>{{ucwords($variantCombination['variantType'])}}</label>

                                <select class="variants">
                                    <option disabled selected value="0">Select
                                        {{ucwords($variantCombination['variantType'])}}
                                    </option>
                                    @foreach($variantCombination['tagNames'] as $key => $tags)
                                    <option value="{{$tags}}">{{ucwords($tags)}}</option>
                                    @endforeach
                                </select>

                            </div>
                            @endforeach

                        </div>
                    </div>
                    @endif
                    <form id="addToCartForm" class="form-cart-btn">
                        @csrf
                        @method('POST')
                        <div class="product__details__quantity">
                            <div class="quantity">
                                <div class="pro-qty">
                                    <tr data-id="{{$product->id}}">
                                    </tr>
                                    <input type="number" min="0" value="1" class="quantity " name="quantity">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="type" id="door-type" value="" />
                        <input type="hidden" name="location" id="door-location" value="" />
                        <input type="hidden" name="jamb" id="door-jamb" value="" />
                        <input type="hidden" name="left" id="door-left" value="" />
                        <input type="hidden" name="right" id="door-right" value="" />

                        <input type="hidden" name="variant" class="product-variant-data"
                            value="{{json_encode($variantSingle)}}" />
                        <input type="hidden" name="product_id" value="{{$product->id}}" />
                        <button type="button" class="primary-btn add-to-cart " onclick="return addToCart(event)"
                            @disabled(getProductAvailabityStock($product->id) <= 0)>ADD TO CART</button>
                        <a href="#" id="share-with-email" class="btn primary-btn" data-toggle="modal"
                            data-target="#exampleModal">Share <i class="fa fa-share"></i></a>
                    </form>
                    @if(session('success'))
                    <div id="productDiscountMessage" class="product-discount-message">
                        {{ session('success') }}
                    </div>
                    @endif
                    <div id="addtocartMessage"></div>


                    <li class="availibility-div-mn"><b>Availability</b> <span id="availability">{{(
                            getProductAvailabityStock($product->id) > 0 && (getProductAvailabityStock($product->id) >
                            getProductStockOnCart($product->id))) ? 'In' : 'Out of'}} Stock</span></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="product__details__tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                aria-selected="true">Description</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"
                                aria-selected="false">Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab"
                                aria-selected="false">Reviews <span>(1)</span></a>
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

<!-- Modal share with email -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
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
                                <input name="email" id="email" type="email" class="form-control example-date-input"
                                    value="{{ old('email') }}" required>
                            </div>
                            <div class="col-md-12 mt-3">
                                <input name="submit" id="share" type="submit" class="form-control btn primary-btn"
                                    value="{{ _('Share') }}">
                            </div>
                            <span id="message">
                        </div>
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
    function doortype(event) {
        let selectedValue = document.getElementById("type-of-door").value;
        document.getElementById('door-type').value = selectedValue

    }

    function doorlocation(event) {
        let selectedValue = document.getElementById("location-of-door").value;
        document.getElementById('door-location').value = selectedValue

    }

    function doorjamb(event) {
        let selectedValue = document.getElementById("jamb").value;
        document.getElementById('door-jamb').value = selectedValue

    }

    function doorleft(event) {
        let selectedValue = document.getElementById("left").value;
        document.getElementById('door-left').value = selectedValue

    }

    function doorright(event) {
        let selectedValue = document.getElementById("right").value;
        document.getElementById('door-right').value = selectedValue

    }

    function addToCart(event) {
        var quantity = document.querySelector('input[name="quantity"]').value;
        var allVariants = document.querySelectorAll('.variants');
        var doortype = document.getElementById('door-type').value;
        var doorlocation = document.getElementById('door-location').value;
        var doorjamb = document.getElementById('door-jamb').value;
        var doorleft = document.getElementById('door-left').value;
        var doorright = document.getElementById('door-right').value;
        var selectedVariants = [];
        // Iterate through all variant dropdowns
        allVariants.forEach(function (variant) {
            var selectedValue = variant.value;
            console.log("selectedValue", selectedValue);
            // Check if the variant is selected
            if (selectedValue && selectedValue != '0') {
                selectedVariants.push(selectedValue);
            }
        });
        let checkStockAvailability = "{{ getProductAvailabityStock($product->id) }}";
        let getProductStockOnCart = "{{ getProductStockOnCart($product->id) }}";
        console.log("checkStockAvailability::", checkStockAvailability, "getProductStockOnCart", getProductStockOnCart, "selectedVariants", selectedVariants.length);
        var addtocartMessage = document.getElementById('addtocartMessage');
        if (checkStockAvailability < getProductStockOnCart || (quantity > checkStockAvailability)) {
            addtocartMessage.innerHTML = '<div class="product-discount-message-error">Product is out of Stock</div>';
            addtocartMessage.style.display = 'block';
            setTimeout(function () {
                addtocartMessage.style.display = 'none';
            }, 5000);
            return false;
        }
        if (checkStockAvailability != 0) {
            // Check if all variants are selected
            if (selectedVariants.length >= 0 && selectedVariants.length === (allVariants.length / 2)) {
                //  document.getElementById('addToCartForm').submit();
                var csrfToken = document.querySelector('input[name="_token"]').value;
                var product_id = document.querySelector('input[name="product_id"]').value;
                var variant = document.querySelector('input[name="variant"]').value;

                var xhr = new XMLHttpRequest();
                var url = "{{ route('add.to.cart') }}";
                xhr.open('POST', url, true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            var responseData = JSON.parse(xhr.responseText);
                            // Check if the response contains a 'success' property
                            if (responseData.success) {
                                // Display the success message
                                document.getElementById('addtocartMessage').innerHTML = '<div class="product-discount-message">' + responseData.success + '</div>';

                                var badgeElement = document.getElementById('cart-count');
                                badgeElement.innerText = responseData.product_count;

                                var cartprice = document.getElementById('header_cart_price');
                                cartprice.innerHTML = 'Total: <b>$' + responseData.total_ammount + '</b>';

                                addtocartMessage.style.display = 'none';
                                window.location.replace("/add-to-cart");
                            } else {
                                // Handle other responses or errors
                                console.error('Error or unexpected response:', responseData);
                            }
                            console.log(responseData);
                        } else {
                            addtocartMessage.innerHTML = '<div class="product-discount-message-error">Product is out of Stock</div>';
                            addtocartMessage.style.display = 'block';
                        }
                    }
                };

                var data = "product_id=" + product_id +
                    "&variant=" + variant +
                    "&quantity=" + quantity +
                    "&doortype=" + doortype +
                    "&doorlocation=" + doorlocation +
                    "&doorjamb=" + doorjamb +
                    "&doorleft=" + doorleft +
                    "&doorright=" + doorright;

                xhr.send(data);

            } else {
                event.preventDefault(event);
                document.getElementById('addToCartForm').disabled = true;

                allVariants.forEach(function (variant) {
                    variant.style.border = '2px solid red';
                });
                // alert('Please select all variants before adding to the cart.');
                return false;
            }
        }
        setTimeout(function () {
            addtocartMessage.style.display = 'none';
        }, 5000);
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
                    productid: productid,
                    email: email,
                    price: price,
                    selectvarient: selectvarient,
                    _token: csrfToken,
                },
                success: function (response) {
                    // Handle the success response here
                    console.log(response);
                    jQuery('div#loader-container').hide();

                    jQuery('#success-message').text('Mail Sent Successfully!').show();
                    jQuery('#exampleModal').modal('hide');
                    setTimeout(() => {
                        jQuery('#success-message').hide();
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

    jQuery(document).ready(function () {
        jQuery('#productDiscountMessage').hide();
        jQuery('#discountForm').submit(function (e) {
            e.preventDefault();
            jQuery('div#loader-container').show();
            var csrfToken = $('input[name="_token"]').val();

            var discount_value = jQuery('#discount_value').val();

            var url = "{{ route('discount', $product->id)}}";
            jQuery.ajax({
                url: url,
                type: "Post",
                data: {
                    apply_code: discount_value,
                    _token: csrfToken,
                },
                success: function (response) {
                    var selling_price = "{{$product->selling_price}}";
                    var discount_ammount = selling_price - response.discount;
                    // Handle the success response here
                    console.log(discount_ammount);
                    jQuery('#discount_price').val(response.discount);
                    jQuery('div#loader-container').hide();
                    jQuery('#productDiscountMessage').show();

                    jQuery('#main-price').html('<del style="color: #625c5c;font-size: 18px;">$' + selling_price + '</del> <span>$' + discount_ammount + '</span>');

                    jQuery('#discount_value').prop('disabled', true);
                    jQuery('#discount_btn').val('Applied');
                    jQuery('#discount_btn').prop('disabled', true);

                    jQuery('#productDiscountMessage').text(response.success);
                    setTimeout(function () {
                        jQuery('#productDiscountMessage').hide();
                    }, 2000);


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
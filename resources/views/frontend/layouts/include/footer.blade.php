<footer class="footer spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer__about">
                    <div class="footer__about__logo">
                        <a href="/"><img src="{{asset('frontend/img/logo-white.png')}}" alt=""></a>
                    </div>
                    <ul>
                        <li>Address: 00-00 Road 00000 Dummy Address</li>
                        <li>Phone: <a href="tel:604-446-5841">+1 (604) 446-5841</a></li>
                        <li>Email: <a href="mailto:hello@dummy.com">hello@dummy.com</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
                <div class="footer__widget">
                    <h6>Categories</h6>
                    <ul>
                        @foreach($categories as $category)
                        @if(empty($category->parent_id) && $category->name != 'Add On')
                        <li>
                            <a href="{{route('category', $category->slug )}}">{{ isset($category->name) ?
                                $category->name : '' }}</a>
                        </li>
                        @endif
                        @endforeach

                    </ul>
                    {{-- <ul>
                        <li><a href="#">Who We Are</a></li>
                        <li><a href="#">Our Services</a></li>
                        <li><a href="#">Projects</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    <li><a href="#">Innovation</a></li>
                    <li><a href="#">Testimonials</a></li>
                    </ul> --}}
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="footer__widget">
                    <h6>Join Our Newsletter Now</h6>
                    <p>Get E-mail updates about our latest shop and special offers.</p>
                    <form action="#">
                        <input type="text" placeholder="Enter your mail">
                        <button type="submit" class="site-btn">Subscribe</button>
                    </form>
                    <div class="footer__widget__social">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="footer__copyright">
                    <div class="footer__copyright__text">
                        <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            Copyright &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script> All rights reserved
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        </p>
                    </div>
                    <div class="footer__copyright__payment"><img src="img/payment-item.png" alt=""></div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Footer Section End -->


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
                            <input type="hidden" id="footer_product_id" name="product_id" value="">
                            <div class="col-md-12">
                                <input name="email" id="email" type="email" class="form-control example-date-input" value="{{ old('email') }}" required>
                            </div>
                            <div class="col-md-12 mt-3">
                                <input name="submit" id="share" type="submit" class="form-control btn primary-btn" value="{{ _('Share') }}">
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

<!-- Js Plugins -->
<script src="{{asset('frontend/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
<script src="{{asset('frontend/js/jquery.nice-select.min.js')}}"></script>
<script src="{{asset('frontend/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('frontend/js/jquery.slicknav.js')}}"></script>
<script src="{{asset('frontend/js/mixitup.min.js')}}"></script>
<script src="{{asset('frontend/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('frontend/js/main.js')}}"></script>

<script type="text/javascript">
    jQuery(document).ready(function(e) {
        setTimeout(function() {
            jQuery('.featured__controls li.active').trigger('click');
        }, 500);
    });

    setTimeout(function() {
        jQuery('.featured__controls li.active').trigger('click');
        jQuery('.product-discount-message').hide();
        jQuery('.product-discount-message-error').hide();
    }, 2000);

    $(".update-cart").change(function(e) {
        e.preventDefault();
        var ele = $(this);
        $.ajax({
            url: "{{ route('update.cart') }}",
            method: "patch",
            data: {
                _token: '{{ csrf_token() }}',
                id: ele.parents("tr").attr("data-id"),
                variant: ele.parents("tr").attr("data-variant"),
                quantity: ele.parents("tr").find(".quantity").val()
            },
            success: function(response) {
                window.location.reload();
            }
        });
    });
    $(".remove-from-cart").click(function(e) {
        e.preventDefault();
        var ele = $(this);
        if (confirm("Are you sure want to remove?")) {
            $.ajax({
                url: "{{ route('remove.from.cart') }}",
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: ele.parents("tr").attr("data-id"),
                    variant: ele.parents("tr").attr("data-variant"),
                },
                success: function(response) {
                    window.location.reload();
                }
            });
        }
    });

    function addOn() {
        e.preventDefault();
        $.ajax({
            url: "{{ route('add_on.cart') }}",
            method: "patch",
            data: {
                _token: '{{ csrf_token() }}',
                id: ele.parents("ul").attr("data-id"),
                quantity: ele.parents("li").find(".quantity").val(),
                pid: "{{$product->id ?? 0}}"
            },

            success: function(response) {
                window.location.reload();
            }
        });
    };

    $(".variants").change(function() {
        var arr = $('select').map(function() {
            return this.value
        }).get()
        var discount_price = $('#discount_price').val();
        var allVariants = document.querySelectorAll('.variants');
        allVariants.forEach(function(variant) {
            variant.style.border = '';
        });
        var str = arr.join("/");
        $.ajax({
            url: "{{ route('get.price') }}",
            method: "GET",
            data: {
                _token: '{{ csrf_token() }}',
                str: str,
                pid: "{{$product->id ?? 0 }}"
            },
            success: function(response) {
                console.log("productAvailabityStock:", response);
                let price = 0;
                if (response.selling_price) {
                    price = response.selling_price
                } else {
                    price = 0;
                }

                $('.product-variant-data').val(JSON.stringify(response))
                if (discount_price != '') {
                    $('.product__details__price').html('<del style="color: #625c5c;font-size: 18px;">$' + price + '</del> $' + (price - discount_price));
                } else {
                    $('.product__details__price').html('$' + (price - discount_price));
                }

                var quantity = parseInt($('input[name="quantity"]').val());

                // Check if the quantity is greater than or equal to 2
                if (quantity >= response.productAvailabityStock) {
                    // Disable the "ADD TO CART" button
                    $('.add-to-cart').prop('disabled', true);
                } else {
                    // Enable the "ADD TO CART" button
                    $('.add-to-cart').prop('disabled', false);
                }
               // updateAddToCartButton(response.productAvailabityStock);
                // if (response.productAvailabityStock <= 0)
                //     $('#availability').text('Out of Stock');
                // $('.add-to-cart').attr('disabled', (response.productAvailabityStock > 0) ? false : true);

            }
        });
    })

    // Add an event listener to the quantity input for both keyup and change events


    function share_product(productid) {
        jQuery('form#shareForm #footer_product_id').val(productid);

        jQuery('#shareForm').one('submit', function(e) {
            e.preventDefault();
            jQuery('div#loader-container').show();
            var csrfToken = $('input[name="_token"]').val();
            var productid = jQuery('#footer_product_id').val();
            var email = jQuery('#email').val();
            var domain = window.location.origin;
            var url = domain + "/share-product/" + productid;

            jQuery.ajax({
                url: url,
                type: "Post",
                data: {
                    productid: productid,
                    email: email,
                    _token: csrfToken,
                },
                success: function(response) {
                    jQuery('div#loader-container').hide();
                    jQuery('#success-message').text('Mail Sent Successfully!').show();
                    jQuery('#exampleModal').modal('hide');
                    setTimeout(() => {
                        jQuery('#success-message').hide();
                    }, 2000);

                    jQuery('#email').val('');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    }

    async function share_product_email(productid) {
        const {
            value: email,
            isConfirmed
        } = await Swal.fire({
            title: 'Enter Email',
            input: 'email',
            inputPlaceholder: 'Enter email address',
            showCancelButton: true,
            confirmButtonText: 'Share',
            cancelButtonText: 'Cancel',
            inputValidator: (value) => {
                if (!value) {
                    return 'Email address is required!';
                }
            },
        });

        if (isConfirmed) {
            // Show loading spinner
            $('body').append('<div id="loading-spinner"></div>');

            try {
                const csrfToken = $('input[name="_token"]').val();
                const domain = window.location.origin;
                const url = `${domain}/share-product/${productid}`;

                const response = await jQuery.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        productid: productid,
                        email: email,
                        _token: csrfToken,
                    },
                });

                jQuery('#success-message').text('Mail Sent Successfully!').show();
                setTimeout(() => {
                    jQuery('#success-message').hide();
                }, 2000);

            } catch (error) {
                console.error(error);
                jQuery('#error-message').text('Failed to send mail. Please try again!').show();
                setTimeout(() => {
                    jQuery('#error-message').hide();
                }, 2000);
            } finally {
                // Hide loading spinner
                jQuery('#loading-spinner').remove();
            }
        }
    }

    $(document).ready(function() {
        // Initialize the slider
        const urlParams = new URLSearchParams(window.location.search);

        // Get the 'min' and 'max' values
        const mini = urlParams.get('min');
        const maxi = urlParams.get('max');

        $(".price-range").slider({
            range: true,
            min: 10,
            max: 1000,
            values: [mini, maxi],
            slide: function(event, ui) {
                $("#minamount").val(ui.values[0]);
                $("#maxamount").val(ui.values[1]);
            }
        });

        // Submit the form on slider change
        $(".price-range").on("slidechange", function() {
            $("#price-range-form").submit();
        });
    });
</script>
</body>

</html>
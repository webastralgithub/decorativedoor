/*  ---------------------------------------------------
    Template Name: Ogani
    Description:  Ogani eCommerce  HTML Template
    Author: Colorlib
    Author URI: https://colorlib.com
    Version: 1.0
    Created: Colorlib
---------------------------------------------------------  */

'use strict';

(function ($) {

    /*------------------
        Preloader
    --------------------*/
    $(window).on('load', function () {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");

        /*------------------
            Gallery filter
        --------------------*/
        $('.featured__controls li').on('click', function () {
            $('.featured__controls li').removeClass('active');
            $(this).addClass('active');
        });
        if ($('.featured__filter').length > 0) {
            var containerEl = document.querySelector('.featured__filter');
            var mixer = mixitup(containerEl);
        }
    });

    /*------------------
        Background Set
    --------------------*/
    $('.set-bg').each(function () {
        var bg = $(this).data('setbg');
        $(this).css('background-image', 'url(' + bg + ')');
    });

    //Humberger Menu
    $(".humberger__open").on('click', function () {
        $(".humberger__menu__wrapper").addClass("show__humberger__menu__wrapper");
        $(".humberger__menu__overlay").addClass("active");
        $("body").addClass("over_hid");
    });

    $(".humberger__menu__overlay").on('click', function () {
        $(".humberger__menu__wrapper").removeClass("show__humberger__menu__wrapper");
        $(".humberger__menu__overlay").removeClass("active");
        $("body").removeClass("over_hid");
    });

    /*------------------
        Navigation
    --------------------*/
    $(".mobile-menu").slicknav({
        prependTo: '#mobile-menu-wrap',
        allowParentLinks: true
    });

    /*-----------------------
        Categories Slider
    ------------------------*/
    $(".categories__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 4,
        dots: false,
        nav: true,
        navText: ["<span class='fa fa-angle-left'><span/>", "<span class='fa fa-angle-right'><span/>"],
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {

            0: {
                items: 1,
            },

            480: {
                items: 2,
            },

            768: {
                items: 3,
            },

            992: {
                items: 4,
            }
        }
    });


    $('.hero__categories__all').on('click', function () {
        $('.hero__categories ul').slideToggle(400);
    });

    /*--------------------------
        Latest Product Slider
    ----------------------------*/
    $(".latest-product__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 1,
        dots: false,
        nav: true,
        navText: ["<span class='fa fa-angle-left'><span/>", "<span class='fa fa-angle-right'><span/>"],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true
    });

    /*-----------------------------
        Product Discount Slider
    -------------------------------*/
    $(".product__discount__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 3,
        dots: true,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {

            320: {
                items: 1,
            },

            480: {
                items: 2,
            },

            768: {
                items: 2,
            },

            992: {
                items: 3,
            }
        }
    });

    /*---------------------------------
        Product Details Pic Slider
    ----------------------------------*/
    $(".product__details__pic__slider").owlCarousel({
        loop: true,
        margin: 20,
        items: 4,
        dots: true,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true
    });

    /*-----------------------
        Price Range Slider
    ------------------------ */
    var rangeSlider = $(".price-range"),
        minamount = $("#minamount"),
        maxamount = $("#maxamount"),
        minPrice = rangeSlider.data('min'),
        maxPrice = rangeSlider.data('max');
    rangeSlider.slider({
        range: true,
        min: minPrice,
        max: maxPrice,
        values: [minPrice, maxPrice],
        slide: function (event, ui) {
            minamount.val('$' + ui.values[0]);
            maxamount.val('$' + ui.values[1]);
        }
    });
    minamount.val('$' + rangeSlider.slider("values", 0));
    maxamount.val('$' + rangeSlider.slider("values", 1));

    /*--------------------------
        Select
    ----------------------------*/
    $("select").niceSelect();

    /*------------------
        Single Product
    --------------------*/
    $('.product__details__pic__slider img').on('click', function () {

        var imgurl = $(this).data('imgbigurl');
        var bigImg = $('.product__details__pic__item--large').attr('src');
        if (imgurl != bigImg) {
            $('.product__details__pic__item--large').attr({
                src: imgurl
            });
        }
    });

    /*-------------------
        Quantity change
    --------------------- */
    var proQty = $('.pro-qty');
    proQty.prepend('<span class="dec qtybtn">-</span>');
    proQty.append('<span class="inc qtybtn">+</span>');
    proQty.on('click', '.qtybtn', function () {
        var $button = $(this);
        var oldValue = $button.parent().find('input').val();
        if ($button.hasClass('inc')) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        $button.parent().find('input').val(newVal);
    });



    /*----------------------
      email check ajax
    ----------------------*/
    var customeremail = $('#customer-email');
    customeremail.keyup(function () {

        $('#user-alreday-exist').hide();
        $('#customer-id').val('');

        /**********Personal information ***********/

        $('#customer-name').val('');
        $('#customer-phone').val('');
        $('#customer-dob').val('');
        $('#customer-gender').val('');

        $('#customer-shipping-address_type').val('');
        $('#customer-shipping-state').val('');
        $('#customer-shipping-city').val('');
        $('#customer-shipping-street').val('');
        $('#customer-shipping-country').val('');
        $('#customer-shipping-zipcode').val('');

        $('#customer-billing-address_type').val('');
        $('#customer-billing-state').val('');
        $('#customer-billing-city').val('');
        $('#customer-billing-street').val('');
        $('#customer-billing-country').val('');
        $('#customer-billing-zipcode').val('');

        /**********company information ***********/


        $('#company-name').val('');
        $('#company-address').val('');
        $('#company-phone').val('');
        $('#company-email').val('');
        $('#company-industory-type').val('');
        $('#company-website').val('');
        $('#company-registration_no').val('');
        $('#company-gst_no').val('');
        $('#company-notes').val('');
        $('#final_submit').show();

        var token = $('input[name="_token"]').val();
        var email_val = $(this).val();

        // Perform AJAX request
        $.ajax({
            url: 'check-user', // Replace with your server-side script
            method: 'POST', // You can use 'GET' as well
            data: { email: email_val, _token: token },
            success: function (response) {
                // Update the searchResults div with the response from the server
                var jsonData = JSON.parse(response);
                console.log(jsonData);
                $('#user-alreday-exist').show();
                $('#final_submit').hide();
                $('#user-alreday-exist').html('<span id="user-alreday-exist" style="color: green;"><i class="fa fa-check"></i>User Already Exist</span><br><input type="checkbox" id="customerassign" data-id="' + jsonData.id + '"><label class="form-check-label"> Use This Customer </label>');
                $('#customer-id').val(jsonData.id);

                /**********Personal information ***********/

                $('#customer-name').val(jsonData.name);
                $('#customer-phone').val(jsonData.phone);
                $('#customer-dob').val(jsonData.dob);
                $('#customer-gender').val(jsonData.gender);

                $('#customer-shipping-address_type').val(jsonData.address_type);
                $('#customer-shipping-state').val(jsonData.state);
                $('#customer-shipping-city').val(jsonData.city);
                $('#customer-shipping-street').val(jsonData.street);
                $('#customer-shipping-country').val(jsonData.country);
                $('#customer-shipping-zipcode').val(jsonData.zipcode);

                $('#customer-billing-address_type').val(jsonData.billing_address_type);
                $('#customer-billing-state').val(jsonData.billing_state);
                $('#customer-billing-city').val(jsonData.billing_city);
                $('#customer-billing-street').val(jsonData.billing_street);
                $('#customer-billing-country').val(jsonData.billing_country);
                $('#customer-billing-zipcode').val(jsonData.billing_zipcode);

                /**********company information ***********/


                $('#company-name').val(jsonData.company_name);
                $('#company-address').val(jsonData.company_address);
                $('#company-phone').val(jsonData.company_phone);
                $('#company-email').val(jsonData.company_email);
                $('#company-industory-type').val(jsonData.industory_type);
                $('#company-website').val(jsonData.company_website);
                $('#company-registration_no').val(jsonData.registration_no);
                $('#company-gst_no').val(jsonData.gst);
                $('#company-notes').val(jsonData.notes);

                jQuery('#customerassign').on('click', function (e) {
                    e.preventDefault();
                    var token = $('input[name="_token"]').val();
                    var userid = jQuery(this).data('id');
                    var url = "/assign-customer";
                    jQuery.ajax({
                        url: url,
                        type: "Post",
                        data: { user_id: userid, _token: token },
                        success: function (response) {
                            console.log(response);
                            jQuery('#productDiscountMessage').text(response.success);
                            jQuery('#productDiscountMessage').show();
                            jQuery('#assignuser').modal('hide');
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

            },
            error: function (error) {
                console.error('Error:', error);
            }
        });

    });



    jQuery(document).ready(function () {

        $('#use_shipping_add').change(function (e) {
            // Check if the checkbox is checked
            if ($(this).prop('checked')) {
                $('.shipping_address').show();
                var address_type = $('#customer-billing-address_type').val();
                var state = $('#customer-billing-state').val();
                var city = $('#customer-billing-city').val();
                var street = $('#customer-billing-street').val();
                var country = $('#customer-billing-country').val();
                var zipcode = $('#customer-billing-zipcode').val();

                // $('#customer-shipping-address_type').val(address_type);
                // $('#shipping-customer-state').val(state);
                // $('#shipping-customer-city').val(city);
                // $('#shipping-customer-street').val(street);
                // $('#shipping-customer-country').val(country);
                // $('#shipping-customer-zipcode').val(zipcode);
            } else {
                $('.shipping_address').hide();
                $('#customer-shipping-address_type').val('');
                $('#shipping-customer-street').val('');
                $('#shipping-customer-city').val('');
                $('#shipping-customer-street').val('');
                $('#shipping-customer-country').val('');
                $('#shipping-customer-zipcode').val('');

            }
        });

        jQuery('#use_shipping_add').submit(function (e) {
            e.preventDefault();

        });

    });

    // jQuery(document).ready(function (){

    //     jQuery('#customer-assign').submit(function (e) {
    //         e.preventDefault();

    //         var url = "/store-customer";
    //         jQuery.ajax({
    //             url: url,
    //             type: "Post",
    //             data:  $(this).serialize(),
    //             success: function (response) {
    //                 console.log(response);
    //             },
    //             error: function (xhr, status, error) {
    //                 // Handle the error response here
    //                 console.error(xhr.responseText);
    //             }
    //         });
    //     });

    // });

    jQuery(document).ready(function () {
        jQuery('#productDiscountMessage').hide();
        jQuery('.customerassign').on('click', function (e) {
            jQuery(this).prop('checked', true);
            var token = $('input[name="_token"]').val();
            var userid = jQuery(this).data('id');
            var url = "/assign-customer";
            jQuery.ajax({
                url: url,
                type: "Post",
                data: { user_id: userid, _token: token },
                success: function (response) {
                    console.log(response);
                    jQuery('button.btn.btn-secondary.close-btn').trigger('click');
                    jQuery('#productDiscountMessage').text(response.success);
                    jQuery('#place-order-btn').html('<a href="/checkout" class="btn btn-success">Proceed Order</a>');
                    jQuery('#productDiscountMessage').show();
                    jQuery('#assignuser').modal('hide');
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




})(jQuery);
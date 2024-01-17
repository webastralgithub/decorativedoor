@extends('frontend.layouts.app')

@section('content')
    <section class="customer spad">
        <div class="container">

         <div class="customer-form-page-re">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Customer</h2>
                    </div>
                </div>
            </div>
            @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <div class="row customer-form-responsive">
                <div class="col-lg-2"></div>
                <div class="col-lg-8 check-user-exist">

                    <form id="customer-assign" action="{{ route('store-customer') }}" method="POST">
                        @csrf
                        <input type="hidden" class="form-control" id="customer-id" name="user_id" value="">
                        
                        <div class="per-info-sec">
                        <h4 class="mb-3">Prosonal Information</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="email" class="form-control" id="customer-email" placeholder="Email"
                                    name="email" value="">
                                <div id="user-alreday-exist"></div>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="customer-name" placeholder="Full Name"
                                    name="name" value="">
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <input type="password" class="form-control" id="customer-password" placeholder="Password"
                                    name="password" value="">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="customer-phone" placeholder="Phone No"
                                    name="phone" value="">
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <input type="date" class="form-control" id="customer-dob" placeholder="Date Of Birth"
                                    name="dob" value="">
                            </div>
                            <div class="col-md-6">
                                <select name="gender" id="customer-gender" class="form-control">
                                    <option value=""> Select Gender </option>
                                    <option value="male"> Male </option>
                                    <option value="female"> Female </option>
                                </select>
                            </div>
                        </div>
                        </div>

                        <div class="address-block-sm">
                        <h5 class="mb-3 mt-3"> Billing Address</h5>
                        <hr>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="customer-billing-address_type"
                                    placeholder="Billing Address" name="billing_address_type" value="">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="customer-billing-street"
                                    placeholder="Billing Street" name="billing_street" value="">
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="customer-billing-city"
                                    placeholder="Billing City" name="billing_city" value="">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="customer-billing-state"
                                    placeholder="Billing State" name="billing_state" value="">
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="customer-billing-country"
                                    placeholder="Billing Country" name="billing_country" value="">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="customer-billing-zipcode"
                                    placeholder="Billing Postal Code" name="billing_zipcode" value="">
                            </div>
                        </div>


                        <div class="row mt-4">
                            <div class="col-md-12 same-address-block">
                                <input type="checkbox" class="form-check-input" id="use_shipping_add">
                                <label class="form-check-label"> Use as same shipping address </label>
                            </div>
                        </div>
                        </div>

                        <div class="shipping_address">
                            <h5 class="mb-3 mt-3"> Shipping Address</h5>
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="customer-shipping-address_type"
                                        placeholder="Shipping Address" name="address_type" value="">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="shipping-customer-street"
                                        placeholder="Shipping Street" name="street" value="">
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="shipping-customer-city"
                                        placeholder="Shipping  City" name="city" value="">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="shipping-customer-state"
                                        placeholder="Shipping  State" name="state" value="">
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="shipping-customer-country"
                                        placeholder="Shipping  Country" name="country" value="">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="shipping-customer-zipcode"
                                        placeholder="Shipping Postal Code" name="zipcode" value="">
                                </div>
                            </div>
                        </div>


                        <div class="company-info-sec">
                        <h4 class="mb-3 mt-3">Company Information</h4>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="company-name" placeholder="Company Name"
                                    name="company_name" value="">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="company-address"
                                    placeholder="Company Address" name="company_address" value="">
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="company-phone"
                                    placeholder="Company Phone No" name="company_phone" value="">
                            </div>
                            <div class="col-md-6">
                                <input type="email" class="form-control" id="company-email"
                                    placeholder="Company Email" name="company_email" value="">
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="company-industory-type"
                                    placeholder="Industory Type" name="industory_type" value="">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="company-website"
                                    placeholder="Company Website" name="company_website" value="">
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="company-registration_no"
                                    placeholder="Tax ID / Registration No" name="registration_no" value="">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="company-gst_no" placeholder="GST No"
                                    name="gst" value="">
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <textarea class="form-control" id="company-notes" placeholder="Notes" name="notes"></textarea>
                            </div>
                        </div>
                        </div>
                        
                        <div class="row mt-4" id="final_submit">
                            <div class="col-md-12">
                                <input type="submit" class="form-control primary-btn" name="submit"
                                    value="Submit and use this customer">
                            </div>
                        </div>
                        

                    </form>
                    <div id="productDiscountMessage" class="product-discount-message" style="display:none"></div>
                </div>
                <div class="col-lg-2"></div>

                </div> 
            </div>
    </section>
@endsection

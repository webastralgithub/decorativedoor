@extends('frontend.layouts.app')

@section('content')
<section class="customer spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Customer</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8 check-user-exist">
                <form action="{{route('store-customer')}}" method="POST">
                    @csrf
                    <input type="hidden" class="form-control" id="customer-id" name="user_id" value="">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="email" class="form-control" id="customer-email" placeholder="Email" name="email" value="">
                            <span id="user-alreday-exist" style="color:green;display:none;"><i class="fa fa-check"></i> User Already Exist</span>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="customer-name" placeholder="Name" name="name" value="">
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="customer-address_type"  placeholder="Address" name="address_type" value="">
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="customer-street"  placeholder="Street" name="street" value="">
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="customer-city" placeholder="City" name="city" value="">
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="customer-state" placeholder="State" name="state" value="">
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="customer-country" placeholder="Country" name="country" value="">
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="customer-zipcode" placeholder="Postal Code" name="zipcode" value="">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="customer-phone" placeholder="Phone No" name="phone" value="">
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="customer-tax_id" placeholder="Tax ID" name="tax_id" value="">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="customer-registration_no" placeholder="Registration No" name="registration_no" value="">
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="customer-gst_no" placeholder="GST No" name="gst" value="">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <textarea class="form-control" id="customer-notes" placeholder="Notes"
                                name="notes"></textarea>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <input type="submit" class="form-control primary-btn" name="submit" value="Submit and use this customer">
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="col-lg-2"></div>
        </div>
</section>

@endsection
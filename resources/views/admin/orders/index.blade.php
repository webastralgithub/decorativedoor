@extends('admin.layouts.app')

@section('content')
    <style>
        table {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }
    </style>

    <div class="mx-4 content-p-mobile">
        <div class="page-header-tp">
            <h3>Orders</h3>

            <div class="top-bntspg-hdr">
                @can('create-order')
                    <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm my-2"><i class="bi bi-plus-circle"></i>
                        Add New Order</a>
                @endcan
            </div>
        </div>
        @if (\Session::has('error'))
            <div>
                <li class="alert alert-danger">{!! \Session::get('error') !!}</li>
            </div>
        @endif

        @if (\Session::has('success'))
            <div>
                <li class="alert alert-success">{!! \Session::get('success') !!}</li>
            </div>
        @endif
        <div class="content-body">
            <div class="table-order">
                <table class="table table-striped table-bordered" id="order">
                    <thead>
                        @if (auth()->user()->can('make-payment') ||
                                auth()->user()->can('download-invoice') ||
                                auth()->user()->can('add-signature'))
                            <th>{{ __('Action') }}</th>
                        @endif
                        <th>{{ __('Order ID') }}</th>
                        @can('change-order-status')
                            <th>{{ __('Status') }}</th>
                        @endcan
                        <th>{{ __('Customer Name') }}</th>
                        <th>{{ __('Order Coordinator') }}</th>
                        @can('show-quantity-listing')
                            <th>{{ __('Ordered Quantity') }}</th>
                            <th>{{ __('Production Ready Qty') }}</th>
                            <th>{{ __('Backorder Quantity') }}</th>
                            <th>{{ __('Delivered Quantity') }}</th>
                            <th>{{ __('Pending Quantity') }}</th>
                        @endcan
                        @if (!auth()->user()->hasRole('Delivery User'))
                        <th>{{ __('Sales Person') }}</th>
                        {{-- <th>{{__('Accountant')}}</th> --}}
                        <th>{{ __('Assembler') }}</th>
                        @endif
                        <th>{{ __('Delivery By') }}</th>
                        {{-- <th>{{__('Address')}}</th> --}}
                        
                        <th>{{ __('Delivery Date') }}</th>
                        <th>{{ __('Ready Date') }}</th>
                        @if (!auth()->user()->hasRole('Delivery User'))
                            <th>{{ __('Quantity') }}</th>
                        @endif
                        @can('order_price')
                            <th>{{ __('Total') }}</th>
                        @endcan
                        @if (auth()->user()->hasRole('Accountant'))
                            <th>{{ __('Approval') }}</th>
                        @endif
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                @if (auth()->user()->can('make-payment') ||
                                        auth()->user()->can('download-invoice') ||
                                        auth()->user()->can('add-signature'))
                                    <td>
                                        <div class="btn-group">
                                            <button type="button"
                                                class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="visually-hidden cogs-btn"><i class="fa fa-cog"
                                                        aria-hidden="true"></i></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                @can('make-payment')
                                                    <li><a class="dropdown-item"
                                                            onclick="return makePayment('{{ $order->id }}');">Make
                                                            Payment</a></li>
                                                @endcan
                                                @can('add-signature')
                                                    <li><a href="{{ route('orders.delivery_user', $order->id) }}"
                                                            class="dropdown-item">Take Signature</a></li>
                                                @endcan
                                                @if (auth()->user()->hasRole('Accountant') ||
                                                        auth()->user()->hasRole('Super Admin'))
                                                    @if ($order->order_confirm != 1)
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('order.confirm-order', $order->id) }}">Confirm
                                                                Order</a></li>
                                                    @endif
                                                @endif

                                                <!-- <li><a class="dropdown-item" href="{{ route('order.downloadInvoice', $order) }}">Print</a></li> -->

                                            </ul>
                                        </div>
                                    </td>
                                @endif
                                <td><a href="{{ route('orders.show', $order->order_id) }}"
                                        style="color: red;">#{{ $order->order_id }}</a></td>
                                @can('change-order-status')
                                    <td class=" status-links">
                                        <!-- <a class="text-info" onclick="return changeOrderStatus('{{ $order->id }}','{{ $order_statuses }}','{{ $order->order_status }}');">
                                                {{ \App\Models\OrderStatus::getStatusNameById($order->order_status) }}
                                            </a> -->
                                        @foreach ($order->details->unique('order_status') as $item)
                                            <a class="text-info-product " href="{{ route('orders.show', $order->order_id) }}">
                                                {{ \App\Models\OrderStatus::getStatusNameById($item->order_status) }}
                                            </a><br>
                                        @endforeach
                                    </td>
                                @endcan
                                <td>
                                    <span class="@if (!$order->user_id) dots-assigned @endif cursor-pointer"
                                        @can('change_sales_person') onclick="return assignUser(this,'{{ $order->id }}','{{ $sales_users }}','sales person','{{ $order->user_id }}');" @endcan>{{ $order->user->name ?? '...' }}</span>
                                </td>
                                <td> <span class="@if (!$order->user_id) dots-assigned @endif cursor-pointer"
                                        @can('change_order_coordinator') onclick="return assignUser(this,'{{ $order->id }}','{{ $coordinators }}','order coordinator','{{ $order->user_id }}');" @endcan>{{ $order->coordinator->name ?? '...' }}</span>
                                </td>

                                @can('show-quantity-listing')
                                    @php  $Quantities =  getOrderDeliveryQuantity($order->id); @endphp

                                    @php
                                        $orderQuantity = 0;
                                        $deliver_quantity = 0;
                                    @endphp
                                    @foreach ($order->details as $key => $items)
                                        @php
                                            $orderQuantity += $items->quantity;
                                        @endphp
                                    @endforeach
                                    @foreach ($order->deliverorder as $key => $items)
                                        @php
                                            $deliver_quantity += $items->deliver_quantity;
                                        @endphp
                                    @endforeach

                                    <td>{{ $orderQuantity }}</td>
                                    <td>{{ $deliver_quantity }}</td>
                                    <td style="color:red;"><b>{{ $orderQuantity - $deliver_quantity }}</b></td>
                                    <td>{{ $Quantities['delivery_quantity'] }}</td>
                                    <td>{{ $Quantities['pendingQuantity'] }}</td>
                                @endcan

                                @if (!auth()->user()->hasRole('Delivery User'))
                                <td>
                                    <span
                                        class="@if (!$order->sales_person) dots-assigned @endif cursor-pointer">{{ getUserInfo($order->sales_person)['name'] ?? '...' }}</span>
                                </td>
                              
                                <td>
                                    <span class="@if (!$order->assemble) dots-assigned @endif cursor-pointer"
                                        @can('change_assembler_user') onclick="return assignUser(this, '{{ $order->id }}','{{ $assembler_users }}','assembler','{{ $order->assembler_user_id }}');" @endcan>{{ $order->assemble->name ?? '...' }}</span>
                                </td>
                                @endif
                                <td>
                                    <span class="@if (!$order->delivery) dots-assigned @endif cursor-pointer"
                                        @can('change_delivery_user') onclick="return assignUser(this, '{{ $order->id }}','{{ $delivery_users }}','delivery','{{ $order->delivery_user_id }}');" @endcan>{{ $order->delivery->name ?? '...' }}</span>
                                </td>
                               
                               
                                <td>{{ $order->order_date->format('d-m-Y') }}</td>
                                <td>-</td>
                                @if (!auth()->user()->hasRole('Delivery User'))
                                    <td>{{ getTotalQuantity($order->id) }}</td>
                                @endif
                                @can('order_price')
                                    <td>${{ number_format(getOrderTotalprice($order->id), 2, '.', ',') }}</td>
                                @endcan
                                @if (auth()->user()->hasRole('Accountant'))
                                    <td><button class="btn btn-primary btn-sm my-2"
                                            onclick="return updateProductStatus('{{ $order->id }}', 4)"> Okay to proceed
                                        </button>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <form id="addressForm" style="display: none;">
                    <div class="mb-3 row">
                        <div class="col-md-12 flex">
                            <label for="street" class="col-md-3 col-form-label text-md-end text-start">
                                {{ __('Street') }}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-9" style="line-height: 35px;">
                                <input name="street" id="street" type="text"
                                    class="form-control example-date-input @error('street') is-invalid @enderror"
                                    value="{{ old('street') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-12 flex">
                            <label for="city" class="col-md-3 col-form-label text-md-end text-start">
                                {{ __('City') }}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-9" style="line-height: 35px;">
                                <input name="city" id="city" type="text"
                                    class="form-control example-date-input @error('city') is-invalid @enderror"
                                    value="{{ old('city') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-12 flex">
                            <label for="state" class="col-md-3 col-form-label text-md-end text-start">
                                {{ __('State') }}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-9" style="line-height: 35px;">
                                <input name="state" id="state" type="text"
                                    class="form-control example-date-input @error('state') is-invalid @enderror"
                                    value="{{ old('state') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-12 flex">
                            <label for="country" class="col-md-3 col-form-label text-md-end text-start">
                                {{ __('Country') }}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-9" style="line-height: 35px;">
                                <input name="country" id="country" type="text"
                                    class="form-control example-date-input @error('country') is-invalid @enderror"
                                    value="{{ old('country') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-12 flex">
                            <label for="state" class="col-md-3 col-form-label text-md-end text-start">
                                {{ __('ZIP Code') }}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-9" style="line-height: 35px;">
                                <input name="zip_code" id="zip_code" type="text"
                                    class="form-control example-date-input @error('zip_code') is-invalid @enderror"
                                    value="{{ old('zip_code') }}" required>
                            </div>
                        </div>
                    </div>
                    <!-- <button type="button" onclick="submitAddressForm()">Submit</button> -->
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function updateProductStatus(orderId, newStatus) {
            // Send AJAX request to update order status
            jQuery.ajax({
                url: '/admin/update-order-product-status', // Replace with your actual route
                type: 'POST',
                data: {
                    order_id: orderId,
                    new_status: newStatus,
                    _token: '{{ csrf_token() }}' // Add CSRF token if needed
                },
                success: function(response) {
                    // Handle success, if needed
                    if (response.success) {

                        jQuery('#success-message').text('Order Status Updated').show();
                        setTimeout(() => {
                            jQuery('#success-message').hide();
                        }, 2000);
                    } else {

                        jQuery('#error-message').text('Order Status Error').show();
                        setTimeout(() => {
                            jQuery('#error-message').hide();
                            location.reload();
                        }, 2000);
                    }
                },
                error: function(error) {
                    // Handle error, if needed
                    console.error('Error updating order status', error);
                }
            });
        }
    </script>

    <script>
        async function makePayment(orderId) {
            await Swal.fire({
                title: "Select a Payment Method",
                input: "select",
                inputOptions: {
                    cod: "Cash On Delivery",
                    card: "Credit Card",
                    paypal: "Paypal"
                },
                inputPlaceholder: "Select a Payment Method",
                showCancelButton: true,
                inputValidator: (value) => {
                    return new Promise((resolve) => {
                        // console.log(value);
                        if (value) {
                            jQuery.ajax({
                                url: '/admin/update-payment-method', // Replace with your actual route
                                type: 'POST',
                                data: {
                                    order_id: orderId,
                                    method: value,
                                    _token: '{{ csrf_token() }}' // Add CSRF token if needed
                                },
                                success: function(response) {
                                    // Handle success, if needed
                                    if (response.success) {
                                        resolve();

                                        jQuery('#success-message').text(
                                                'Payment status updated successfully!')
                                            .show();
                                        setTimeout(() => {
                                            jQuery('#success-message').hide();
                                            /* Read more about isConfirmed, isDenied below */
                                            if (result.isConfirmed) {
                                                location.reload();
                                            }
                                        }, 2000);
                                    }
                                },
                                error: function(error) {
                                    // Handle error, if needed
                                    console.error('Error updating order status', error);
                                }
                            });

                        } else {
                            resolve("Please select Payment Method");
                        }
                    });
                }
            });

        }

        async function assignUser(event, orderId, assign_users, type, selectedUser) {
            console.log(event.innerText);
            var users = JSON.parse(assign_users)
            const inputOptions = {};
            users.forEach(user => {
                inputOptions[user.id] = user.name;
            });
            await Swal.fire({
                // title: "Assigne the " + type,
                input: "select",
                inputOptions: inputOptions,
                inputPlaceholder: "Select " + type.charAt(0).toUpperCase() + type.slice(1).toLowerCase(),
                inputValue: selectedUser,
                showCancelButton: true,
                inputValidator: (value) => {
                    return new Promise((resolve) => {
                        // console.log(value);
                        if (value) {
                            jQuery.ajax({
                                url: "{{ route('assign_user') }}", // Replace with your actual route
                                type: 'POST',
                                data: {
                                    orderid: orderId,
                                    userid: value,
                                    type: type,
                                    _token: '{{ csrf_token() }}' // Add CSRF token if needed
                                },
                                success: function(response) {
                                    if (response.success) {
                                        resolve();

                                        jQuery('#success-message').text(
                                            'Assigned Successfully!').show();
                                        setTimeout(() => {
                                            jQuery('#success-message').hide();
                                            console.log("inputOptions::",
                                                inputOptions,
                                                "selectedUser", value,
                                                inputOptions[value]);
                                            event.innerText = inputOptions[
                                                value];
                                            event.classList.remove(
                                                'dots-assigned')
                                        }, 2000);
                                    }
                                },
                                error: function(error) {
                                    // Handle error, if needed
                                    console.error('Error updating order status', error);
                                }
                            });

                        } else {
                            resolve();
                        }
                    });
                }
            });

        }
        $(".select-sales_users").change(function() {

            $.ajax({
                url: "{{ route('assign_user') }}",
                method: "post",
                data: {
                    _token: '{{ csrf_token() }}',
                    orderid: $(this).attr("data-id"),
                    type: $(this).attr("data-type"),
                    userid: $(this).val()
                },

                success: function(response) {
                    jQuery('#success-message').text('Assigned Successfully!').show();
                    setTimeout(() => {
                        jQuery('#success-message').hide();
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    }, 2000);
                }
            });
        })
        new DataTable('#order', {
            order: [
                [1, 'desc']
            ],
            pageLength: 50

        });

        async function changeOrderStatus(orderId, allStatuses, selectedStatus) {
            var statuses = JSON.parse(allStatuses)
            const inputOptions = {};
            statuses.forEach(status => {
                inputOptions[status.id] = status.name;
            });
            await Swal.fire({
                title: "Change Order Status",
                input: "select",
                inputOptions: inputOptions,
                inputValue: selectedStatus,
                inputPlaceholder: "Select Status",
                showCancelButton: true,
                inputValidator: (value) => {
                    return new Promise((resolve) => {
                        // console.log(value);
                        if (value) {
                            jQuery.ajax({
                                url: '/admin/update-order-status', // Replace with your actual route
                                type: 'POST',
                                data: {
                                    order_id: orderId,
                                    new_status: value,
                                    _token: '{{ csrf_token() }}' // Add CSRF token if needed
                                },
                                success: function(response) {
                                    // Handle success, if needed
                                    if (response.success) {
                                        jQuery('#success-message').text(
                                            'Order Status Updated!').show();
                                        setTimeout(() => {
                                            jQuery('#success-message').hide();
                                            if (result.isConfirmed) {
                                                location.reload();
                                            }
                                        }, 2000);
                                    } else {
                                        jQuery('#error-message').text(
                                            'Order Status Error!').show();
                                        setTimeout(() => {
                                            jQuery('#error-message').hide();
                                            if (result.isConfirmed) {
                                                location.reload();
                                            }
                                        }, 2000);
                                    }
                                },
                                error: function(error) {
                                    // Handle error, if needed
                                    console.error('Error updating order status', error);
                                }
                            });

                        } else {
                            resolve("Please select Payment Method)");
                        }
                    });
                }
            });

        }

        async function addUserAddress(userId, responseType) {
            if (userId <= 0) {
                Swal.fire({
                    // icon: 'warning',
                    //title: 'User not valid!',
                    text: "Please select Sales Person"
                });
                return false;
            }
            await Swal.fire({
                // title: "Add User Address",
                html: document.getElementById('addressForm').innerHTML,
                showCancelButton: true,
                preConfirm: () => {
                    // Handle form submission
                    const street = Swal.getPopup().querySelector('#street').value;
                    const city = Swal.getPopup().querySelector('#city').value;
                    const state = Swal.getPopup().querySelector('#state').value;
                    const country = Swal.getPopup().querySelector('#country').value;
                    const zipCode = Swal.getPopup().querySelector('#zip_code').value;

                    if (country.trim() === '' || street.trim() === '' || city.trim() === '' || state
                        .trim() === '' || zipCode.trim() === '') {
                        Swal.showValidationMessage('All fields are required');
                    } else {
                        jQuery.ajax({
                            url: '/admin/update-user-address', // Replace with your actual route
                            type: 'POST',
                            data: {
                                userId: userId,
                                street: street,
                                city: city,
                                state: state,
                                country: country,
                                zipCode: zipCode,
                                _token: '{{ csrf_token() }}' // Add CSRF token if needed
                            },
                            success: function(response) {
                                // Handle success, if needed
                                if (response.success) {
                                    jQuery('#success-message').text('User Address Updated!')
                                        .show();
                                    setTimeout(() => {
                                        jQuery('#success-message').hide();
                                    }, 2000);
                                } else {
                                    jQuery('#error-message').text('User Address Error!').show();
                                    setTimeout(() => {
                                        jQuery('#error-message').hide();
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    }, 2000);
                                }
                            },
                            error: function(error) {
                                // Handle error, if needed
                                console.error('Error updating order status', error);
                            }
                        });
                        Swal.close(); // Close the Swal.fire modal
                    }
                }
            });
        }
    </script>
@endsection

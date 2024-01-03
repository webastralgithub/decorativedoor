@extends('admin.layouts.app')

@section('content')
<style>
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
</style>
<div class="card mx-4">
    <div class="card-header">Manage Orders</div>
    <div class="card-body">

        @can('create-order')
        <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New Order</a>
        @endcan
        <div class="table-order">
            <table class="table table-striped table-bordered" id="order">
                <thead>
                    <th>{{__('ID')}}</th>
                    <th>{{__('Order ID')}}</th>
                    <th>{{__('Order Coordinator')}}</th>
                    <th>{{__('Ready Date')}}</th>
                    <th>{{__('Delivery Date')}}</th>
                    <th>{{__('Quantity')}}</th>
                    <th>{{__('Sales Person')}}</th>
                    <th>{{__('Accountant')}}</th>
                    <th>{{__('Assembler')}}</th>
                    <th>{{__('Delivery By')}}</th>
                    @can('order_price')
                    <th>{{__('Total')}}</th>
                    @endcan
                    @can('change-order-status')
                    <th>{{__('Status')}}</th>
                    @endcan
                    <th>{{__('Address')}}</th>
                    <th>{{__('Action')}}</th>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><a href="{{ route('orders.show', $order->order_id) }}" style="color: red;">#{{ $order->order_id }}</a></td>
                        <td>-</td>
                        <td>{{ $order->order_date->format('d-m-Y') }}</td>
                        <td>-</td>
                        <td>{{ number_format($order->total_products, 2, '.', ',') }}</td>
                        <td class="center">
                            <span class="@if(!$order->user_id) dots-assigned @endif cursor-pointer" @can('change_sales_person') onclick="return assignUser('{{$order->id}}','{{$sales_users}}','sales person','{{$order->user_id}}');" @endcan>{{$order->user->name ?? "..."}}</span>
                        </td>
                        <td class="center">
                            <span class="@if(!$order->accountant) dots-assigned @endif cursor-pointer" @can('change_accountant_user') onclick="return assignUser('{{$order->id}}','{{$accountant_users}}','accountant','{{$order->accountant_user_id}}');" @endcan>{{$order->accountant->name ?? "..."}}</span>
                        </td>
                        <td class="center">
                            <span class="@if(!$order->assemble) dots-assigned @endif cursor-pointer" @can('change_assembler_user') onclick="return assignUser('{{$order->id}}','{{$assembler_users}}','assembler','{{$order->assembler_user_id}}');" @endcan>{{$order->assemble->name ?? "..."}}</span>
                        </td>
                        <td class="center">
                            <span class="@if(!$order->delivery) dots-assigned @endif cursor-pointer" @can('change_delivery_user') onclick="return assignUser('{{$order->id}}','{{$delivery_users}}','delivery','{{$order->delivery_user_id}}');" @endcan>{{$order->delivery->name ?? "..."}}</span>
                        </td>
                        @can('order_price')
                        <td>${{ number_format($order->total, 2, '.', ',') }}</td>
                        @endcan
                        @can('change-order-status')
                        <td class="center">
                            <a class="text-info" onclick="return changeOrderStatus('{{$order->id}}','{{$order_statuses}}','{{$order->order_status}}');">
                                {{ \App\Models\OrderStatus::getStatusNameById($order->order_status)}}
                            </a>
                            @foreach ($order->details->unique('order_status') as $item)
                            </br>
                            <a class="text-info-product " href="{{ route('orders.show', $order->order_id) }}">
                                {{ \App\Models\OrderStatus::getStatusNameById($item->order_status)}}
                            </a>
                            @endforeach
                        </td>
                        @php
                        $address = getUserAddress($order->user_id);
                        @endphp
                        <td class="@if($address == '') center @endif">
                            @if($address != '')
                            <span class="">{{$address}}</span>
                            @else
                            <span class="dots-assigned cursor-pointer" @can('change_user_address') onclick="return addUserAddress('{{$order->user_id}}');" @endcan>{{"..."}}</span>
                            @endif
                        </td>
                        @endcan
                        <td>
                            @can('make-payment')
                            @if($order->order_status == \App\Models\OrderStatus::IN_PROGRESS)
                            <a class="btn btn-success btn-sm" onclick="return makePayment('{{$order->id}}');"> Make Payment</a>
                            @endif
                            @endcan
                            @can('download-invoice')
                            <a class="btn btn-primary btn-sm" href="{{ route('order.downloadInvoice', $order) }}">Print</a>
                            @endcan
                        </td>
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
                            <input name="street" id="street" type="text" class="form-control example-date-input @error('street') is-invalid @enderror" value="{{ old('street') }}" required>
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
                            <input name="city" id="city" type="text" class="form-control example-date-input @error('city') is-invalid @enderror" value="{{ old('city') }}" required>
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
                            <input name="state" id="state" type="text" class="form-control example-date-input @error('state') is-invalid @enderror" value="{{ old('state') }}" required>
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
                            <input name="country" id="country" type="text" class="form-control example-date-input @error('country') is-invalid @enderror" value="{{ old('country') }}" required>
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
                            <input name="zip_code" id="zip_code" type="text" class="form-control example-date-input @error('zip_code') is-invalid @enderror" value="{{ old('zip_code') }}" required>
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
                                    Swal.fire({
                                        title: "Thank You!",
                                        text: "Payment status updated successfully!",
                                        icon: "success"
                                    }).then((result) => {
                                        /* Read more about isConfirmed, isDenied below */
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
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

    async function assignUser(orderId, assign_users, type, selectedUser) {
        var users = JSON.parse(assign_users)
        const inputOptions = {};
        users.forEach(user => {
            inputOptions[user.id] = user.name;
        });
        await Swal.fire({
            title: "Assigne the " + type,
            input: "select",
            inputOptions: inputOptions,
            inputPlaceholder: "Select " + type,
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
                                // Handle success, if needed
                                if (response.success) {
                                    resolve();
                                    Swal.fire({
                                        title: "Thank You!",
                                        text: "Assigned Successfully",
                                        icon: "success"
                                    }).then((result) => {
                                        /* Read more about isConfirmed, isDenied below */
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
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
                Swal.fire({
                    title: "Thank You!",
                    text: "Assigned successfully!",
                    icon: "success"
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            }
        });
    })
    new DataTable('#order');

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
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Order Status Updated',
                                        text: response.success
                                    }).then((result) => {
                                        /* Read more about isConfirmed, isDenied below */
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Order Status Error',
                                        text: response.error
                                    }).then((result) => {
                                        /* Read more about isConfirmed, isDenied below */
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
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
                icon: 'warning',
                title: 'User not valid!',
                text: "Please select Sales Person"
            });
            return false;
        }
        await Swal.fire({
            title: "Add User Address",
            html: document.getElementById('addressForm').innerHTML,
            showCancelButton: true,
            preConfirm: () => {
                // Handle form submission
                const street = Swal.getPopup().querySelector('#street').value;
                const city = Swal.getPopup().querySelector('#city').value;
                const state = Swal.getPopup().querySelector('#state').value;
                const country = Swal.getPopup().querySelector('#country').value;
                const zipCode = Swal.getPopup().querySelector('#zip_code').value;

                if (country.trim() === '' || street.trim() === '' || city.trim() === '' || state.trim() === '' || zipCode.trim() === '') {
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
                                Swal.fire({
                                    icon: 'success',
                                    title: 'User Address Updated',
                                    text: response.success
                                });
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'User Address Error',
                                    text: response.error
                                }).then((result) => {
                                    /* Read more about isConfirmed, isDenied below */
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
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
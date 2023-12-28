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
                    <th>{{__('Assembler')}}</th>
                    <th>{{__('Delivery By')}}</th>
                    <th>{{__('Total')}}</th>
                    <th>{{__('Status')}}</th>
                    <th>{{__('Action')}}</th>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><a href="{{ route('orders.show', $order->order_id) }}" style="color: red;">#{{ $order->order_id }}</a></td>
                        <td>-</td>
                        <td>{{ $order->order_date->format('d-m-Y') }}</td>
                        <td>{{ $order->order_date->format('d-m-Y') }}</td>
                        <td>{{ number_format($order->total_products) }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>
                            <span class="dots-assigned" onclick="return assignUser('{{$order->id}}','{{$delivery_users}}','assembler');">{{$order->assemble->name ?? "..."}}</span>
                        </td>
                        <td>
                            <span class="dots-assigned" onclick="return assignUser('{{$order->id}}','{{$assembler_users}}','assembler');">{{$order->assemble->name ?? "..."}}</span>
                        </td>
                        <td>{{ number_format($order->total) }}</td>
                        <td>
                            <a class="text-info">
                                {{ \App\Models\OrderStatus::getStatusNameById($order->order_status)}}
                                <a>
                        </td>
                        <td>
                            @can('create-order')
                            @if($order->order_status == \App\Models\OrderStatus::IN_PROGRESS)
                            <a class="btn btn-success btn-sm" onclick="return makePayment('{{$order->id}}');"> Make Payment</a>
                            @endif
                            @endcan

                            @can('view-order')
                            <a class="btn btn-warning btn-sm" href="{{ route('orders.show', $order) }}"> Show</a>
                            @endcan

                            @can('download-invoice')
                            <a class="btn btn-primary btn-sm" href="{{ route('order.downloadInvoice', $order) }}">Print</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
                                        text: "Order status updated successfully!",
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

    async function assignUser(orderId, assign_users, type) {
        var users = JSON.parse(assign_users)
        const inputOptions = {};
        users.forEach(user => {
            inputOptions[user.id] = user.name;
        });
        await Swal.fire({
            title: "Assign User",
            input: "select",
            inputOptions: inputOptions,
            inputPlaceholder: "Select Assembler",
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
</script>
@endsection
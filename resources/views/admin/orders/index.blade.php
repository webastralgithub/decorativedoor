@extends('admin.layouts.app')

@section('content')
<style>
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
        /* Add scrollbar if the table content overflows */
    }
</style>
<div class="card mx-4">
    <div class="card-header">Manage Orders</div>
    <div class="card-body">

        @can('create-order')
        <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New Order</a>
        @endcan
        <div class="table-order">
            <table class="table table-striped table-bordered">
                <thead>
                    <th>{{__('ID')}}</th>
                    <th>{{__('Order ID')}}</th>
                    <th>{{__('Customer')}}</th>
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
                        <td>{{ $order->user->name }}</td>
                        <td>-</td>
                        <td>{{ $order->order_date->format('d-m-Y') }}</td>
                        <td>{{ $order->order_date->format('d-m-Y') }}</td>
                        <td>{{ number_format($order->total_products) }}</td>
                        <td>
                            <select data-type="sales" class="select-sales_users form-select @error('sales_user_id') is-invalid @enderror" aria-label="sales_user_id" id="sales_user_id" name="sales_user_id" style="height:40px;">
                                <option value="">Select Sales Person</option>
                                @forelse ($sales_users as $user)
                                <option value="{{ $user->id }}" {{ in_array($user->id, old('sales_user_id') ?? []) ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                                @empty
                                ...
                                @endforelse
                            </select>
                        </td>
                        <td>
                            <select data-type="assembler" class="select-sales_users form-select @error('sales_user_id') is-invalid @enderror" aria-label="sales_user_id" id="sales_user_id" name="sales_user_id" style="height:40px;">
                                <option value="">Select Assembler</option>
                                @forelse ($delivery_users as $user)
                                <option value="{{ $user->id }}" {{ in_array($user->id, old('sales_user_id') ?? []) ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                                @empty
                                ...
                                @endforelse
                            </select>
                        </td>
                        <td>
                            <select  data-type="delivery" class="select-sales_users form-select @error('sales_user_id') is-invalid @enderror" aria-label="sales_user_id" id="sales_user_id" name="sales_user_id" style="height:40px;">
                                <option value="">Select Delivery By</option>
                                @forelse ($assembler_users as $user)
                                <option value="{{ $user->id }}" {{ in_array($user->id, old('sales_user_id') ?? []) ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                                @empty
                                ...
                                @endforelse
                            </select>
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
    $(".select-sales_users").change(function() {
        e.preventDefault();
        // $.ajax({
        //     url: "{{ route('assign_user') }}",
        //     method: "patch",
        //     data: {
        //         _token: '{{ csrf_token() }}',
        //         id: ele.parents("ul").attr("data-id"),
        //         quantity: ele.parents("li").find(".quantity").val(),
        //         pid: "{{$product->id ?? 0}}"
        //     },

        //     success: function(response) {
        //         window.location.reload();
        //     }
        // });
    })
</script>
@endsection
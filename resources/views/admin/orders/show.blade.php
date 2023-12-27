@extends('admin.layouts.app')

@section('content')

<div class="card  mx-4">
    <div class="card-header">
        <div class="row gx-3 mb-3">
            <div class="col-md-6">
                <h3 class="card-title">
                    {{ __('Order Details') }}
                </h3>
            </div>
            @can('change-order-status')
            <div class="col-md-6">
                <label class="small mb-1" for="order_status">
                    Order Status
                    <span class="text-danger">*</span>
                </label>
                <select class="form-select form-control-solid" id="order_status" name="order_status" onchange="updateOrderStatus()">
                    @foreach($order_statuses as $status)
                    <option value="{{$status->id}}" @selected($order->order_status == $status->id)>{{$status->name}}</option>
                    <!-- Add other status options as needed -->
                    @endforeach
                </select>
            </div>
            @endcan
        </div>
    </div>

    <div class="card-body">
        <div class="row row-cards mb-3">
            <div class="col">
                <label for="order_date" class="form-label required">
                    {{ __('Order Date') }}
                </label>
                <input type="text" id="order_date" class="form-control" value="{{ $order->order_date->format('d-m-Y') }}" disabled>
            </div>
            <div class="col">
                <label for="customer" class="form-label required">
                    {{ __('Customer') }}
                </label>
                <input type="text" id="customer" class="form-control" value="{{ $order->user->name }}" disabled>
            </div>

            <div class="col">
                <label for="payment_type" class="form-label required">
                    {{ __('Payment Type') }}
                </label>

                <input type="text" id="payment_type" class="form-control" value="{{ $order->payment_type }}" disabled>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class="align-middle text-center">No.</th>
                        <th scope="col" class="align-middle text-center">Photo</th>
                        <th scope="col" class="align-middle text-center">Product Name</th>
                        <th scope="col" class="align-middle text-center">Product Code</th>
                        <th scope="col" class="align-middle text-center">Quantity</th>
                        <th scope="col" class="align-middle text-center">Price</th>
                        <th scope="col" class="align-middle text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->details as $item)
                    <tr>
                        <td class="align-middle text-center">
                            {{ $loop->iteration  }}
                        </td>
                        <td class="align-middle text-center">
                            <div style="max-height: 80px; max-width: 80px;">
                                <img class="img-fluid" src="{{ $item->product->product_image ? asset('img/product/'.$item->product->product_image) : asset('img/product/default.webp') }}">
                            </div>
                        </td>
                        <td class="align-middle text-center">
                            {{ $item->product->title }}
                        </td>
                        <td class="align-middle text-center">
                            {{ $item->product->code }}
                        </td>
                        <td class="align-middle text-center">
                            {{ $item->quantity }}
                        </td>
                        <td class="align-middle text-center">
                            {{ number_format($item->unitcost, 2) }}
                        </td>
                        <td class="align-middle text-center">
                            {{ number_format($item->total, 2) }}
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="6" class="text-end">
                            Payed amount
                        </td>
                        <td class="text-center">{{ number_format($order->pay, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-end">Due</td>
                        <td class="text-center">{{ number_format($order->due, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-end">VAT</td>
                        <td class="text-center">{{ number_format($order->vat, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-end">Total</td>
                        <td class="text-center">{{ number_format($order->total, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function updateOrderStatus() {
        var orderId = "{{ $order->id }}";
        var newStatus = document.getElementById('order_status').value;

        // Send AJAX request to update order status
        jQuery.ajax({
            url: '/admin/update-order-status', // Replace with your actual route
            type: 'POST',
            data: {
                order_id: orderId,
                new_status: newStatus,
                _token: '{{ csrf_token() }}' // Add CSRF token if needed
            },
            success: function(response) {
                // Handle success, if needed
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Order Status Updated',
                        text: response.success
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
    }
</script>
@endsection
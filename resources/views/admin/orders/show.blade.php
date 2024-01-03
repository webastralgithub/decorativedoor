@extends('admin.layouts.app')

@section('content')

<div class="mx-4 content-p-mobile">
    <div class="page-header-tp">
        <h3>{{ __('Order') }} #{{ $order->order_id}}</h3>

         <div class="top-bntspg-hdr">
            <a href="{{ route('orders.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
      
        @can('change-order-status')
        <!-- <div class="col-md-6">
                <label class="small mb-1" for="order_status">
                    Order Status
                    <span class="text-danger">*</span>
                </label>
                <select class="form-select form-control-solid" id="order_status" name="order_status" onchange="updateOrderStatus()">

                    @foreach($order_statuses as $status)

                    @if (\App\Models\OrderStatus::COMPLETE == $status->id && auth()->user()->can('order-status-complete'))
                    <option value="{{$status->id}}" @selected($order->order_status == $status->id)>{{$status->name}}</option>
                    @endif
                    @if (\App\Models\OrderStatus::IN_PROGRESS == $status->id && auth()->user()->can('order-status-progress'))
                    <option value="{{$status->id}}" @selected($order->order_status == $status->id)>{{$status->name}}</option>
                    @endif
                    @if (\App\Models\OrderStatus::FAILED == $status->id && auth()->user()->can('order-status-failed'))
                    <option value="{{$status->id}}" @selected($order->order_status == $status->id)>{{$status->name}}</option>
                    @endif
                    @if (\App\Models\OrderStatus::READY_TO_ASSEMBLE == $status->id && auth()->user()->can('order-status-ready-to-assemble'))
                    <option value="{{$status->id}}" @selected($order->order_status == $status->id)>{{$status->name}}</option>
                    @endif
                    @if (\App\Models\OrderStatus::READY_TO_DELIVER == $status->id && auth()->user()->can('order-status-deliver'))
                    <option value="{{$status->id}}" @selected($order->order_status == $status->id)>{{$status->name}}</option>
                    @endif
                    @if (\App\Models\OrderStatus::DISPATCHED == $status->id && auth()->user()->can('order-status-dispatch'))
                    <option value="{{$status->id}}" @selected($order->order_status == $status->id)>{{$status->name}}</option>
                    @endif

                    @endforeach
                </select>
            </div> -->
        @endcan

        </div>
    </div>

    <div class="card-body ">
        <div class="row row-cards mb-3 order-table-topb">
            <div class="col">
                <label for="order_date" class="form-label required">
                    <strong>{{ __('Order Date') }}:</strong> {{ $order->order_date->format('d-m-Y') }}
                </label>

            </div>
            <div class="col">
                <label for="customer" class="form-label required">
                    <strong>{{ __('Customer') }}:</strong> {{ @$order->user->name }}
                </label>
            </div>

            <div class="col">
                <label for="payment_type" class="form-label required">
                    <strong>{{ __('Payment Via') }}:</strong> {{ @$order->payment_type }}
                </label>
            </div>
        </div>

        <div class="content-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class="align-middle text-center">No.</th>
                        <th scope="col" class="align-middle text-center">Photo</th>
                        <th scope="col" class="align-middle text-center">Product Name</th>
                        <th scope="col" class="align-middle text-center">Quantity</th>
                        @can('change-order-status')
                        <th scope="col" class="align-middle text-center">Order Status</th>
                        @endcan
                        @can('order_price')
                        <th scope="col" class="align-middle text-center">Price</th>
                        <th scope="col" class="align-middle text-center">Total</th>
                        @endcan
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
                                <img class="img-fluid" src="{{asset((!empty($item->product->product_image) ? Storage::url('products/'.$item->product->product_image) : 'img/featured/feature-1.jpg'))}}">
                            </div>
                        </td>
                        <td class="align-middle text-center">
                            {{ $item->product->title }}
                            <div>CODE:<note>{{ $item->product->code }}</note>
                            </div>
                        </td>
                        <td class="align-middle text-center">
                            {{ $item->quantity }}
                        </td>
                        @can('change-order-status')
                        <td class="align-middle text-center">
                            @php
                            $disabled = ((auth()->user()->hasRole('Product Assembler') && !auth()->user()->can(['order-status-progress','order-status-complete','order-status-failed','order-status-dispatch']) && in_array($item->order_status,[\App\Models\OrderStatus::COMPLETE,\App\Models\OrderStatus::IN_PROGRESS,\App\Models\OrderStatus::FAILED,\App\Models\OrderStatus::DISPATCHED]))
                            ||(auth()->user()->hasRole('Delivery User') && !auth()->user()->can(['order-status-progress','order-status-complete','order-status-failed','order-status-ready-to-assemble']) && in_array($item->order_status,[\App\Models\OrderStatus::COMPLETE,\App\Models\OrderStatus::IN_PROGRESS,\App\Models\OrderStatus::FAILED,\App\Models\OrderStatus::READY_TO_ASSEMBLE]))
                            ||(auth()->user()->hasRole('Accountant') && !auth()->user()->can(['order-status-complete','order-status-dispatch']))&& in_array($item->order_status,[\App\Models\OrderStatus::COMPLETE,\App\Models\OrderStatus::READY_TO_DELIVER,\App\Models\OrderStatus::DISPATCHED]));
                            @endphp
                            <select class="form-select form-control-solid" id="order_status" name="order_status" onchange="return updateSpecificProductrStatus('{{ $item->id }}',this)" @disabled($disabled)>
                                @foreach($order_statuses as $status)
                                @if (\App\Models\OrderStatus::COMPLETE == $status->id )
                                <option @disabled(!in_array($status->id,$access_status)) value="{{$status->id}}" @selected($item->order_status == $status->id)>{{convertToReadableStatus($status->name)}}</option>
                                @endif
                                @if (\App\Models\OrderStatus::IN_PROGRESS == $status->id)
                                <option @disabled(!in_array($status->id,$access_status)) value="{{$status->id}}" @selected($item->order_status == $status->id)>{{convertToReadableStatus($status->name)}}</option>
                                @endif
                                @if (\App\Models\OrderStatus::FAILED == $status->id)
                                <option @disabled(!in_array($status->id,$access_status)) value="{{$status->id}}" @selected($item->order_status == $status->id)>{{convertToReadableStatus($status->name)}}</option>
                                @endif
                                @if (\App\Models\OrderStatus::READY_TO_ASSEMBLE == $status->id)
                                <option @disabled(!in_array($status->id,$access_status)) value="{{$status->id}}" @selected($item->order_status == $status->id)>{{convertToReadableStatus($status->name)}}</option>
                                @endif
                                @if (\App\Models\OrderStatus::READY_TO_DELIVER == $status->id)
                                <option @disabled(!in_array($status->id,$access_status)) value="{{$status->id}}" @selected($item->order_status == $status->id)>{{convertToReadableStatus($status->name)}}</option>
                                @endif
                                @if (\App\Models\OrderStatus::DISPATCHED == $status->id)
                                <option @disabled(!in_array($status->id,$access_status)) value="{{$status->id}}" @selected($item->order_status == $status->id)>{{convertToReadableStatus($status->name)}}</option>
                                @endif

                                @endforeach
                            </select>
                        </td>
                        @endcan
                        @can('order_price')
                        <td class="align-middle text-center">
                            ${{ number_format($item->unitcost, 2, '.', ',') }}
                        </td>
                        <td class="align-middle text-center">
                            ${{ number_format($item->total, 2, '.', ',') }}
                        </td>
                        @endcan
                    </tr>
                    @endforeach
                    @can('order_price')
                    <tr>
                        <td colspan="6" class="text-end">Shipping Charges</td>
                        <td class="text-center">${{ number_format($order->due, 2, '.', ',') }}</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-end">VAT</td>
                        <td class="text-center">${{ number_format($order->vat, 2, '.', ',') }}</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-end">Total</td>
                        <td class="text-center">${{ number_format(($order->total - $order->vat) -$order->due, 2, '.', ',') }}</td>
                    </tr>
                    @endcan
                </tbody>
            </table>
        </div>

        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function updateSpecificProductrStatus(itemId, selectElement) {
        var newStatus = selectElement.value;
        // Send AJAX request to update order status
        jQuery.ajax({
            url: '/admin/update-product-status', // Replace with your actual route
            type: 'POST',
            data: {
                item_id: itemId,
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
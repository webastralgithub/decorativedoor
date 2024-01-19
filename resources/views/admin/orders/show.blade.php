@extends('admin.layouts.app')

@section('content')

<div class="mx-4 content-p-mobile">
    <div class="page-header-tp">
        <h3>{{ __('Order') }} #{{ $order->order_id}}</h3>

        <div class="top-bntspg-hdr">
            <a href="javascript:void(0)" onclick="history.back()" class="btn btn-primary btn-sm">&larr; Back</a>

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

            {{-- <div class="col">
                <label for="payment_type" class="form-label required">
                    <strong>{{ __('Payment Via') }}:</strong> {{ @$order->payment_type }}
                </label>
            </div> --}}
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
                            <th scope="col" class="align-middle text-center">Discount</th>
                            <th scope="col" class="align-middle text-center">Total</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $discount = [];
                        $finaltotal = [];
                        @endphp
                        @foreach ($order->details as $item)
                        @php
                        $discount[] = $item->discount;
                        $finaltotal[] = $item->total;

                        @endphp

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
                                <select class="form-select form-control-solid" id="order_status" name="order_status" onchange="return updateSpecificProductrStatus('{{ $item->id }}',this, '{{ $item->quantity }}', '{{ getDeliverQuantity($item->order_id, $item->id)}}')" @disabled($disabled)>
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
                                ${{ number_format($item->discount, 2, '.', ',') }}
                            </td>
                            <td class="align-middle text-center">
                                ${{ number_format(($item->discount - $item->total), 2, '.', ',') }}
                            </td>
                            @endcan
                        </tr>
                        @endforeach
                        @php
                        $finaltotal = array_sum($finaltotal);
                        $discount = array_sum($discount);
                        $finaltotal = $finaltotal - $discount;
                        @endphp
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
                            <td colspan="6" class="text-end">Total Discount</td>
                            <td class="text-center">${{ number_format($discount, 2, '.', ',') }}</td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-end">Total</td>
                            <td class="text-center">${{ number_format($order->due - ($finaltotal + $order->vat), 2, '.', ',') }}</td>
                        </tr>
                        @endcan
                    </tbody>
                </table>

                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ __('Add Delivery Product Quantity') }}
                                </h5>
                                <button type="button" class="close" aria-label="Close" onclick="closeModal()">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- <form id="delivery_Quantity" action="{{ route('order.per.product.delivery') }}" method="Post"> -->
                                <!-- @csrf -->
                                <div class="mb-3 row delivery-products">
                                    <input type="hidden" name="item_id" id="item_id" value="">
                                    <input type="hidden" name="order_id" id="order_id" value="{{$order->id}}">
                                    <input type="hidden" name="new_status" id="new_status" value="">
                                    <input type="hidden" name="orders_quantity" id="orders_quantity" value="">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="note" class="col-md-12 col-form-label text-md-end text-start">
                                                {{ __('Order Quantity :') }} <span id="order_quantity"></span>
                                            </label>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="note" class="col-md-12 col-form-label text-md-end text-start">
                                                {{ __('Delivered Quantity :') }} <span id="delivery_order">0</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="note" class="col-md-12 col-form-label text-md-end text-start">
                                                {{ __('To be Delivered Quantity :') }}
                                            </label>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-12" style="line-height: 35px;">
                                                <input type="number" name="delivery_quantity" id="delivery_quantity" class="form-control example-date-input" value="{{ old('delivery_quantity') }}" required min="0">
                                                @error('delivery_quantity')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- </form> -->
                                <div class="row ">
                                    <div class="col-md-12 errors">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer delivery-products-footer">
                                <div class="row">
                                    <div class="col-md-12 mt-6">
                                        <input type="button" class="btn btn-primary btn-sm" onclick="return updateOrderItemQuantity();" name="submit" value="Submit">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endsection
    @section('scripts')
    <script>
        function updateSpecificProductrStatus(itemId, selectElement, order_quantity = '0', deliver_quantity = '0') {
            var newStatus = selectElement.value;
            if (newStatus == 5) {
                jQuery('#exampleModal').modal('show');
                jQuery('#order_quantity').text(order_quantity);
                jQuery('#delivery_order').text(deliver_quantity);
                jQuery('#item_id').val(itemId);
                jQuery('#orders_quantity').val(order_quantity);
                jQuery('#new_status').val(newStatus);
            } else {
                updateOrderItemStatus(itemId, newStatus);
            }

        }

        function updateOrderItemStatus(itemId, newStatus) {
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

        function updateOrderItemQuantity() {
            jQuery('.errors').html('');
            let order_quantity = jQuery('#order_quantity').text();
            let delivery_order = jQuery('#delivery_order').text();
            let delivery_quantity = jQuery('#delivery_quantity').val();
            let orderId = jQuery('#order_id').val();
            let itemId = jQuery('#item_id').val();
            let newStatus = jQuery('#new_status').val();

            if (delivery_quantity <= 0) {
                jQuery('.errors').append(`<span class="text-danger ">Delivery quantity is required!</span>`);
                hideErrors();
                return false;
            }
            console.log("order_quantity", delivery_quantity, (order_quantity - delivery_order));
            if (delivery_quantity > (order_quantity - delivery_order)) {
                jQuery('.errors').append(`<span class="text-danger ">Delivery quantity must be less then Ordered quantity</span>`);
                hideErrors();
                return false;
            }
            jQuery.ajax({
                url: "{{ route('order.per.product.delivery') }}", // Replace with your actual route
                type: 'POST',
                data: {
                    item_id: itemId,
                    new_status: newStatus,
                    order_quantity: order_quantity,
                    delivery_quantity: delivery_quantity,
                    delivery_order: delivery_order,
                    orderId: orderId,
                    _token: '{{ csrf_token() }}' // Add CSRF token if needed
                },
                success: function(response) {
                    console.log("response", response);
                    // Handle success, if needed
                    if (response.success) {
                        jQuery('#exampleModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            // title: 'Order Updated',
                            text: "Order Status and Quantity updated"
                        });
                    } else {
                        errorCheck = true;
                        // Iterate over the error messages
                        for (const field in response.errors) {
                            if (Object.hasOwnProperty.call(response.errors, field)) {
                                const errorMessages = response.errors[field];
                                // Print each error message
                                errorMessages.forEach(errorMessage => {
                                    console.error(`${field}: ${errorMessage}`);
                                    jQuery('.errors').append(`<span class="text-danger ">${errorMessage}</span>`);
                                });
                            }
                        }
                        hideErrors();
                    }
                },
                error: function(error) {
                    // Handle error, if needed
                    console.error('Error updating order status', error);
                }
            });


        }

        function hideErrors() {
            setTimeout(() => {
                jQuery('.errors span.text-danger').fadeOut('slow', function() {
                    jQuery(this).remove();
                });
            }, 5000);
        }

        // function updateSpecificProductrStatus(itemId, selectElement, order_quantity = '0', deliver_quantity = '0') {
        //     var newStatus = selectElement.value;
        //     if (newStatus == 5) {
        //         jQuery('#exampleModal').modal('show');
        //         jQuery('#order_quantity').text(order_quantity);
        //         jQuery('#delivery_order').text(deliver_quantity);
        //         jQuery('#item_id').val(itemId);
        //         jQuery('#orders_quantity').val(order_quantity);
        //         jQuery('#new_status').val(newStatus);
        //     }
        // }

        function closeModal() {
            var modal = document.getElementById('exampleModal');
            if (modal) {
                $(modal).modal('hide');
            }
        }
    </script>
    @endsection
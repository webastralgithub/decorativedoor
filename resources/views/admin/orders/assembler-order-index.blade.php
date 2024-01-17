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
            <h3>Assembler Manage Orders</h3>

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

        @php
           // dd($orders);
        @endphp

        <div class="content-body">
            <div class="table-order">
                <table class="table table-striped table-bordered" id="order" style="display: table;">
                    <thead>
                        <th>{{ __('Sr.No') }}</th>
                        <th>{{ __('Order ID') }}</th>
                        <th>{{ __('Customer Name') }}</th>
                        <th>{{ __('Missing Item') }}</th>
                        <th>{{ __('Notes') }}</th>
                        <th>{{ __('Last Updated Date') }}</th>
                        @can('order_price')
                        @endcan
                        @can('change-order-status')
                        @endcan
                    </thead>
                    <tbody>

                        @foreach ($orders as $key => $order)
                            <tr>

                                <th>{{ $key + 1 }} <span class="accordion-header" data-id="{{ $order->order_id }}"><img
                                            src="{{ asset('img/order-icon.svg') }}" class="img" width="30"></span>
                                </th>
                                {{-- <td><a href="{{ route('orders.show', $order->order_id) }}" style="color: red;">#{{ $order->order_id }}</a></td> --}}
                                <td>#{{ $order->order_id }}</td>

                                <td class="center">
                                    <span class="@if (!$order->user_id) dots-assigned @endif cursor-pointer"
                                        @can('change_sales_person') onclick="return assignUser('{{ $order->id }}','{{ $sales_users }}','sales person','{{ $order->user_id }}');" @endcan>{{ $order->user->name ?? '...' }}</span>
                                </td>
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
                                
                                <td>{{($orderQuantity - $deliver_quantity)}}</td>
                                <td>
                                    @if (isset(getOrderNotes($order->id)['note']))
                                        <span
                                            onclick="return addAssemberNote('{{ $order->order_id }}');">{{ getOrderNotes($order->id)['note'] }}</span>
                                    @else
                                        <span onclick="return addAssemberNote('{{ $order->order_id }}');">--</span>
                                    @endif
                                </td>
                                <td>{{ $order->updated_at->format('d-m-Y') }}</td>

                            </tr>
                            <tr class="show-accordin-{{ $order->order_id }}" style="display:none;">
                                <th>{{ __('Product Name') }}</th>
                                <th>{{ __('Quantity') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Discount') }}</th>
                                <th>{{ __('Price') }}</th>
                                <th>{{ __('Total') }}</th>
                            </tr>
                            @foreach ($order->details as $items)
                                <tr class="show-accordin-{{ $order->order_id }}" style="display:none;">
                                    <td>{{ productsInfo($items->product_id)['title'] }}</td>
                                    <td>{{ $items->quantity }}</td>
                                    <td>
                                        <select class="form-select form-control-solid" id="order_status" name="order_status"
                                            onchange="return updateSpecificProductrStatus('{{$items->order_id}}', '{{ $items->id }}',this, '{{ $items->quantity }}', '{{ getDeliverQuantity($items->order_id, $items->id) }}')">
                                            @foreach ($order_statuses as $status)
                                                @if (\App\Models\OrderStatus::COMPLETE == $status->id)
                                                    <option @disabled(!in_array($status->id, $access_status)) value="{{ $status->id }}"
                                                        @selected($items->order_status == $status->id)>
                                                        {{ convertToReadableStatus($status->name) }}</option>
                                                @endif
                                                @if (\App\Models\OrderStatus::IN_PROGRESS == $status->id)
                                                    <option @disabled(!in_array($status->id, $access_status)) value="{{ $status->id }}"
                                                        @selected($items->order_status == $status->id)>
                                                        {{ convertToReadableStatus($status->name) }}</option>
                                                @endif
                                                @if (\App\Models\OrderStatus::FAILED == $status->id)
                                                    <option @disabled(!in_array($status->id, $access_status)) value="{{ $status->id }}"
                                                        @selected($items->order_status == $status->id)>
                                                        {{ convertToReadableStatus($status->name) }}</option>
                                                @endif
                                                @if (\App\Models\OrderStatus::READY_TO_ASSEMBLE == $status->id)
                                                    <option @disabled(!in_array($status->id, $access_status)) value="{{ $status->id }}"
                                                        @selected($items->order_status == $status->id)>
                                                        {{ convertToReadableStatus($status->name) }}</option>
                                                @endif
                                                @if (\App\Models\OrderStatus::READY_TO_DELIVER == $status->id)
                                                    <option @disabled(!in_array($status->id, $access_status)) value="{{ $status->id }}"
                                                        @selected($items->order_status == $status->id)>
                                                        {{ convertToReadableStatus($status->name) }}</option>
                                                @endif
                                                @if (\App\Models\OrderStatus::DISPATCHED == $status->id)
                                                    <option @disabled(!in_array($status->id, $access_status)) value="{{ $status->id }}"
                                                        @selected($items->order_status == $status->id)>
                                                        {{ convertToReadableStatus($status->name) }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>{{ '$' . (isset($items->discount) ? $items->discount : 0) }}</td>
                                    <td>{{ '$' . $items->unitcost }}</td>
                                    <td>{{ '$' . $items->total - $items->discount }}</td>
                                </tr>
                            @endforeach
                        @endforeach

                    </tbody>
                </table>

                <form id="addressForm" style="display: none;">
                    <div class="mb-3 row">
                        <div class="col-md-12 flex">
                            <label for="note" class="col-md-3 col-form-label text-md-end text-start">
                                {{ __('Note') }}
                            </label>
                            <div class="col-md-9" style="line-height: 35px;">
                                <textarea name="note" id="note" class="form-control example-date-input @error('note') is-invalid @enderror"
                                    value="{{ old('note') }}" required></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- <button type="button" onclick="submitAddressForm()">Submit</button> -->
                </form>


                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ __('Add Dilivery product Quantity') }}
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true close-btn">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="delivery_Quantity" action="{{ route('order.per.product.delivery') }}" method="Post">
                                    @csrf
                                    <div class="mb-3 row">
                                        <input type="hidden" name="item_id" id="item_id" value="">
                                        <input type="hidden" name="order_id" id="order_id" value="">
                                        <input type="hidden" name="new_status" id="new_status" value="">
                                        <input type="hidden" name="orders_quantity" id="orders_quantity" value="">
                                        <div class="col-md-12 mb-3">
                                            <label for="note" class="col-md-12 col-form-label text-md-end text-start">
                                                {{ __('Product Order Quantity :') }} <span id="order_quantity"></span>
                                            </label>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="note" class="col-md-12 col-form-label text-md-end text-start">
                                                {{ __('Product Deliver Quantity :') }} <span id="delivery_order"></span>
                                            </label>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="note" class="col-md-12 col-form-label text-md-end text-start">
                                                {{ __('Deliver Product Quantity') }}
                                            </label>
                                            <div class="col-md-12" style="line-height: 35px;">
                                                <input type="number" name="delivery_quantity" id="delivery"
                                                    class="form-control example-date-input"
                                                    value="{{ old('delivery_quantity') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <input type="submit" class="btn btn-primary btn-sm" name="submit"
                                                value="Submit">
                                        </div>
                                    </div>
                                </form>
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
        jQuery('.accordion-header').on('click', function(e) {
            var id = jQuery(this).data('id');
            jQuery('.show-accordin-' + id).toggle();
        });

        async function addAssemberNote(orderId, responseType) {
            if (orderId <= 0) {
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
                    const note = Swal.getPopup().querySelector('#note').value;

                    if (note.trim() === '') {
                        Swal.showValidationMessage('All fields are required');
                    } else {
                        jQuery.ajax({
                            url: '/admin/add-assembler-note', // Replace with your actual route
                            type: 'POST',
                            data: {
                                order_id: orderId,
                                note: note,
                                _token: '{{ csrf_token() }}' // Add CSRF token if needed
                            },
                            success: function(response) {
                                // Handle success, if needed
                                if (response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Oder Note Added Successfully',
                                        text: response.success
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Oder Note Error',
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
    <script>
        function updateSpecificProductrStatus(orderId, itemId, selectElement, order_quantity = '0', deliver_quantity = '0') {
            var newStatus = selectElement.value;
            if (newStatus == 5) {
                jQuery('#exampleModal').modal('show');
                jQuery('#order_quantity').text(order_quantity);
                jQuery('#delivery_order').text(deliver_quantity);
                jQuery('#order_id').val(orderId);
                jQuery('#item_id').val(itemId);
                jQuery('#orders_quantity').val(order_quantity);
                jQuery('#new_status').val(newStatus);
            }
        } 
    </script>
@endsection

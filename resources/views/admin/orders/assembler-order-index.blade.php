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
        <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New Order</a>
        @endcan
        </div>
    </div>
    @if(\Session::has('error'))
    <div>
        <li class="alert alert-danger">{!! \Session::get('error') !!}</li>
    </div>
    @endif
    
    @if(\Session::has('success'))
    <div>
        <li class="alert alert-success">{!! \Session::get('success') !!}</li>
    </div>
    @endif
    
   
    <div class="content-body">
        <div class="table-order">
            <table class="table table-striped table-bordered" id="order" style="display: table;">
                <thead>
                    <th>{{__('Sr.No')}}</th>
                    <th>{{__('Order ID')}}</th>
                    <th>{{__('CUstomer Name')}}</th>
                    <th>{{__('Address')}}</th>
                    <th>{{__('Missing Item')}}</th>
                    <th>{{__('Notes')}}</th>
                    <th>{{__('Last Updated Date')}}</th>
                    @can('order_price')
                    @endcan
                    @can('change-order-status')
                    @endcan
                </thead>
                <tbody>
                   
                            @foreach ($orders as $key => $order)
                           
                            <tr>
                                
                                <th>{{ $key+1 }} <span class="accordion-header" data-id="{{$order->order_id}}"><img src="http://127.0.0.1:8000/img/order-icon.svg" class="img" width="30"></span></th>
                                <td><a href="{{ route('orders.show', $order->order_id) }}" style="color: red;">#{{ $order->order_id }}</a></td>
                               
                                <td class="center">
                                    <span class="@if(!$order->user_id) dots-assigned @endif cursor-pointer" @can('change_sales_person') onclick="return assignUser('{{$order->id}}','{{$sales_users}}','sales person','{{$order->user_id}}');" @endcan>{{$order->user->name ?? "..."}}</span>
                                </td>
                                @can('change-order-status')
                                @php
                                $address = getUserAddress($order->user_id);
                                @endphp
                                <td class="@if($address == '') center @endif">
                                    @if($address != '')
                                    <span class="">{{$address}}</span>
                                    @else
                                    <span class="dots-assigned cursor-pointer">{{"..."}}</span>
                                    @endif
                                </td>
                                @endcan
                                <td>0</td>
                                <th>
                                    @if(isset(getOrderNotes($order->id)['note']))
                                
                                    <span onclick="return addAssemberNote('{{$order->order_id}}');" >{{ getOrderNotes($order->id)['note'] }}</span>
                                    @else
                                    <span onclick="return addAssemberNote('{{$order->order_id}}');" >--</span>
                                    @endif
                                </th>
                                <th>{{ $order->updated_at->format('d-m-Y') }}</th>
                            </tr>
                            <tr class="show-accordin-{{$order->order_id}}" style="display:none;">
                                <th>{{__('Product Name')}}</th>
                                <th>{{__('Quantity')}}</th>                                
                                <th>{{__('Status')}}</th>                               
                                <th>{{__('Discount')}}</th>
                                <th>{{__('Price')}}</th>   
                                <th>{{__('Total')}}</th>
                            </tr>
                                @foreach($order->details as $items)
                                <tr class="show-accordin-{{$order->order_id}}" style="display:none;">
                                    <td>{{productsInfo($items->product_id)['title']}}</td>
                                    <td>{{$items->quantity}}</td>                                  
                                    <td>
                                        <select class="form-select form-control-solid" id="order_status" name="order_status" onchange="return updateSpecificProductrStatus('{{ $items->id }}',this)">
                                            @foreach($order_statuses as $status)
                                            @if (\App\Models\OrderStatus::COMPLETE == $status->id )
                                            <option @disabled(!in_array($status->id,$access_status)) value="{{$status->id}}" @selected($items->order_status == $status->id)>{{convertToReadableStatus($status->name)}}</option>
                                            @endif
                                            @if (\App\Models\OrderStatus::IN_PROGRESS == $status->id)
                                            <option @disabled(!in_array($status->id,$access_status)) value="{{$status->id}}" @selected($items->order_status == $status->id)>{{convertToReadableStatus($status->name)}}</option>
                                            @endif
                                            @if (\App\Models\OrderStatus::FAILED == $status->id)
                                            <option @disabled(!in_array($status->id,$access_status)) value="{{$status->id}}" @selected($items->order_status == $status->id)>{{convertToReadableStatus($status->name)}}</option>
                                            @endif
                                            @if (\App\Models\OrderStatus::READY_TO_ASSEMBLE == $status->id)
                                            <option @disabled(!in_array($status->id,$access_status)) value="{{$status->id}}" @selected($items->order_status == $status->id)>{{convertToReadableStatus($status->name)}}</option>
                                            @endif
                                            @if (\App\Models\OrderStatus::READY_TO_DELIVER == $status->id)
                                            <option @disabled(!in_array($status->id,$access_status)) value="{{$status->id}}" @selected($items->order_status == $status->id)>{{convertToReadableStatus($status->name)}}</option>
                                            @endif
                                            @if (\App\Models\OrderStatus::DISPATCHED == $status->id)
                                            <option @disabled(!in_array($status->id,$access_status)) value="{{$status->id}}" @selected($items->order_status == $status->id)>{{convertToReadableStatus($status->name)}}</option>
                                            @endif
            
                                            @endforeach
                                        </select>
                                    </td>  
                                    <td>{{'$'.$items->discount}}</td>
                                    <td>{{'$'.$items->unitcost}}</td>  
                                    <td>{{'$'.$items->total - $items->discount}}</td>                                 
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
                            <textarea name="note" id="note" class="form-control example-date-input @error('note') is-invalid @enderror" value="{{ old('note') }}" required></textarea>
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

jQuery('.accordion-header').on('click', function(e){
        var id = jQuery(this).data('id');
        jQuery('.show-accordin-'+id).toggle();
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
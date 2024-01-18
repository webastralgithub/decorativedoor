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
        <h3>Manage Orders</h3>

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
                    <!-- <th>{{ __('Action') }}</th> -->
                    <th>{{ __('Order ID') }}</th>
                    <th>{{ __('Customer Name') }}</th>
                    <th>{{ __('Missing Items') }}</th>
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

                        <!-- <th><span class="accordion-header" data-id="{{ $order->order_id }}"><img src="{{ asset('img/order-icon.svg') }}" class="img" width="30"></span>
                        </th> -->
                        <td><a href="{{ route('orders.show', $order->order_id) }}" style="color: red;">#{{
                                $order->order_id }}</a></td> 
                        <!-- <td>#{{ $order->order_id }}</td> -->

                        <td class="center">
                            <span class="@if (!$order->user_id) dots-assigned @endif cursor-pointer" @can('change_cusmtoer') onclick="return assignUser('{{ $order->id }}','{{ $customers }}','customers','{{ $order->user_id }}');" @endcan>{{ $order->user->name ?? '...' }}
                            </span>
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
                            <a href="#"><span onclick="return addAssemberNote('{{ $order->order_id }}');">{{
                                    getOrderNotes($order->id)['note'] }}</span></a>
                            <div id="existingNotes_{{ $order->order_id }}" style="display: none;">
                            </div>
                            @else
                            <a href="#"><span onclick="return addAssemberNote('{{ $order->order_id }}');">--</span></a>
                            @endif
                        </td>
                        <td>{{ $order->updated_at->format('d-m-Y') }}</td>

                    </tr>
                    <tr class="show-accordin-{{ $order->order_id }}" style="display:none;">
                        <th>{{ __('Product Name') }}</th>
                        <th>{{ __('Quantity') }}</th>
                        <th>{{ __('Discount') }}</th>
                        <th>{{ __('Price') }}</th>
                        <th>{{ __('Total') }}</th>
                    </tr>
                    @foreach ($order->details as $items)
                    <tr class="show-accordin-{{ $order->order_id }}" style="display:none;">
                        <td class="highlight">{{ productsInfo($items->product_id)['title'] }}</td>
                        <td>{{ $items->quantity }}</td>
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
                            <textarea name="note" id="note" class="form-control example-date-input @error('note') is-invalid @enderror" value="{{ old('note') }}" required></textarea>
                        </div>
                    </div>
                </div>
                <!-- <button type="button" onclick="submitAddressForm()">Submit</button> -->
            </form>
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
        var existingNotesContainer = '';

        const existingNotes = await fetchExistingNotes(orderId);

        if (existingNotes.length > 0) {
            existingNotesContainer = `
            <div class="footer-content-notes">
            <h3>Existing Notes:</h3>
            <table class="swal-table">
                <thead>
                    <tr>
                        <th>Sr. No</th>
                        <th>Note</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    ${existingNotes.map((note, index) => `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${note.note}</td>
                            <td>${note.created_at}</td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
            </div>
            `;
        }

        await Swal.fire({
            html: document.getElementById('addressForm').innerHTML,
            footer: existingNotesContainer,
            showCancelButton: true,
            customClass: {
                popup: 'custom-popup',
                confirmButton: 'custom-confirm-button',
                cancelButton: 'custom-cancel-button'
            },
            preConfirm: () => {
                const note = Swal.getPopup().querySelector('#note').value;

                if (note.trim() === '') {
                    Swal.showValidationMessage('All fields are required');
                } else {
                    jQuery.ajax({
                        url: '/admin/add-assembler-note',
                        type: 'POST',
                        data: {
                            order_id: orderId,
                            note: note,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {},
                        error: function(error) {}
                    });
                    Swal.close();
                }
            }
        });
    }

    async function fetchExistingNotes(orderId) {
        const response = await fetch('/admin/get-existing-notes', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                order_id: orderId,
            }),
        });

        if (response.ok) {
            const data = await response.json();
            return data.notes || [];
        } else {
            console.error('Error fetching existing notes');
            return [];
        }
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

    function closeModal() {
        var modal = document.getElementById('exampleModal');
        if (modal) {
            $(modal).modal('hide');
        }
    }
</script>
@endsection
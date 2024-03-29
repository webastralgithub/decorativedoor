@extends('admin.layouts.app')

@section('content')
<div class="mx-4 content-p-mobile">
    <div class="page-header-tp">
        <h3>View Inventory</h3>

        <div class="top-bntspg-hdr">
            <a href="{{ route('inventory.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
        </div>
    </div>
    <div class="body-content-new">

        <div class="row gx-3 mb-3">

            <div class="col-md-4">
                <label class="small mb-1" for="customer_id">
                    {{ $products->title }}
                </label>

                @error('product_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>

        <div class="content-body inventery-createtable-btm">
            <div class="table-responsive">

                <table class="table table-striped table-bordered align-middle">
                    <thead class="thead-light">
                        <tr>
                            <th>{{__('Action')}}</th>
                            <th scope="col">
                                {{ __('Product') }}
                            </th>
                            <th scope="col" class="text-center">{{ __('Date') }}</th>
                            <th scope="col" class="text-center">{{ __('WayBill') }}</th>
                            <th scope="col" class="text-center">{{ __('Quantity') }}</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <form action="{{ route('inventory.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $products->id }}">
                                <th></th>
                                <th scope="col">
                                    {{ __('Product') }}
                                </th>
                                <th scope="col" class="text-center"><input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>"></th>
                                <th scope="col" class="text-center"><input type="text" class="form-control" name="waybill" value=""></th>
                                <th scope="col" class="text-center"><input type="number" class="form-control" name="quantity" id="enter_quantity" value="0"></th>
                                <th>
                                    <div class="card-ftr text-center create-inv-ind-btn">
                                        <button type="submit" class="btn btn-success add-list mx-1">
                                            {{ __('Create Inventory') }}
                                        </button>
                                    </div>
                                </th>
                            </form>
                        </tr>
                        @foreach($products->inventories as $inventory)
                        <tr class="totals">
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <span class="visually-hidden cogs-btn"><i class="fa fa-cog" aria-hidden="true"></i></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <form class="buttons-add-edit" action="{{ route('inventory.destroy', $inventory->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                
                                            @can('edit-inventory')
                                            <li><a class="dropdown-item"
                                                    onclick="return EditInventory('{{$inventory->id}}','{{$inventory->waybill}}','{{$inventory->quantity}}');"><i
                                                        class="bi bi-pencil-square"></i>{{"Edit"}}</a></li>
                                            <!-- <a class="dots-assigned cursor-pointer btn btn-primary btn-sm" onclick="return EditInventory('{{$inventory->id}}','{{$inventory->waybill}}','{{$inventory->quantity}}');">{{"Edit"}}</a> -->
                                            @endcan
                                
                                            @can('delete-inventory')
                                            <li><button type="submit" class="dropdown-item btn-danger"
                                                    onclick="return confirm('Do you want to delete this inventory?');"><i class="bi bi-trash"></i>
                                                    Delete</button></li>
                                            <!-- <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this inventory?');"><i class="bi bi-trash"></i> Delete</button> -->
                                            @endcan
                                        </form>
                                    </ul>
                                </div>
                            </td>
                            <th scope="col">
                                {{ $products->title }}
                            </th>
                            @php
                            $dateTime = new DateTime($inventory->created_at);
                            $formattedDate = $dateTime->format('M j, Y, g:i:s A');
                            @endphp
                            <th scope="col" class="text-center">{{ $formattedDate }}</th>
                            <th scope="col" class="text-center">{{ $inventory->waybill }}</th>
                            <th scope="col" class="text-center">{{ $inventory->quantity }}</th>

                        </tr>
                        @endforeach

                        <tr>
                            <td colspan="4" class="text-end"><strong>Total Inventory</strong></td>
                            <td class=" total" id="total"> 0
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Order Recived</strong></td>
                            <td class=" recived" id="recived">
                                @php $totalrecived = 0; @endphp
                                @foreach($products->orderdetails as $order)
                                @php
                                $totalrecived += $order->quantity;
                                @endphp
                                @endforeach
                                {{($totalrecived) ? $totalrecived : '0'}}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4" class="text-end"><strong>Current Inventory</strong></td>
                            <td class=" total" id="current_total"> 0
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <form id="addressForm" class="edit-inventory-popup" style="display: none;">
            <div class="mb-3 row">
                <div class="col-md-12 flex">
                    <label for="waybill" class="col-md-3 col-form-label text-md-end text-start">
                        {{ __('Waybill') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="hidden" id="product_id" name="product_id" value=" {{ $products->id }}">
                    <div class="col-md-9" style="line-height: 35px;">
                        <input name="waybill" id="waybill" type="text" class="form-control example-date-input @error('waybill') is-invalid @enderror" value="{{ old('waybill') }}" required>
                    </div>
                </div>
            </div>

            <div class="mb-3 row">
                <div class="col-md-12 flex">
                    <label for="quantity" class="col-md-3 col-form-label text-md-end text-start">
                        {{ __('Quantity') }}
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-9" style="line-height: 35px;">
                        <input name="quantity" id="quantity" type="number" class="form-control example-date-input @error('quantity') is-invalid @enderror" value="{{ old('Quantity') }}" required>
                    </div>
                </div>
            </div>
            <!-- <button type="button" onclick="submitAddressForm()">Submit</button> -->
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
    document.getElementById('enter_quantity').value = "";
    updateTotalPrice();

    function updateTotalPrice() {

        var recivedelement = document.getElementById('recived');
        var recived = parseFloat(recivedelement.innerHTML) || 0;
        var totalElement = document.getElementById('total');
        var total = 0;

        // Iterate through each row with the class 'totals' and sum up the prices
        var totalRows = document.querySelectorAll('.table tbody tr.totals');
        totalRows.forEach(function(row) {
            var priceCell = row.querySelector('.text-center:nth-child(5)'); // Assuming buying_price is in the fourth column
            var price = parseFloat(priceCell.textContent) || 0;
            total += price;
        });
        var final = recived - total;
        // Update the total price in the designated element
        totalElement.textContent = total.toFixed(2); // Adjust as needed

        var absoluteFinal = Math.abs(final);

        var currenttotalElement = document.getElementById('current_total');
        currenttotalElement.textContent = absoluteFinal.toFixed(2);
    }

    var inputElement = document.getElementById('enter_quantity');

    inputElement.addEventListener('keyup', function() {
        var inputValue = parseFloat(inputElement.value) || 0;
        var total = document.getElementById('total');


        var totalElement = document.getElementById('total');
        var maintotal = 0;

        // Iterate through each row with the class 'totals' and sum up the prices
        var totalRows = document.querySelectorAll('.table tbody tr.totals');
        totalRows.forEach(function(row) {
            var priceCell = row.querySelector('.text-center:nth-child(5)'); // Assuming buying_price is in the fourth column
            var price = parseFloat(priceCell.textContent) || 0;
            maintotal += price;
        });

        var recived = document.getElementById('recived');
        var recivedqun = parseFloat(recived.innerHTML) || 0;
        total.innerHTML = inputValue + maintotal;
        var finaltotal = recivedqun - inputValue + maintotal;
        var absoluteFinaltotal = Math.abs(finaltotal);
        var currenttotalElement = document.getElementById('current_total');
        currenttotalElement.textContent = absoluteFinaltotal.toFixed(2);
    });

    async function EditInventory(InventoryId, wayBill, quantity) {
        console.log("wayBill", wayBill, "quantity", quantity);
        document.getElementById('waybill').value = wayBill;
        document.getElementById('quantity').value = quantity;
        await Swal.fire({
            // title: "Add User Address",
            html: document.getElementById('addressForm').innerHTML,
            showCancelButton: true,
            preConfirm: () => {
                const product_id = Swal.getPopup().querySelector('#product_id').value;
                const waybill = Swal.getPopup().querySelector('#waybill').value;
                const quantity = Swal.getPopup().querySelector('#quantity').value;

                if (product_id.trim() === '' || waybill.trim() === '' || quantity.trim() === '') {
                    Swal.showValidationMessage('All fields are required');
                } else {
                    jQuery.ajax({
                        url: InventoryId, // Replace with your actual route
                        type: 'PATCH',
                        data: {
                            inventoryid: InventoryId,
                            product_id: product_id,
                            waybill: waybill,
                            quantity: quantity,
                            _token: '{{ csrf_token() }}' // Add CSRF token if needed
                        },
                        success: function(response) {
                            // Handle success, if needed
                            location.reload();
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
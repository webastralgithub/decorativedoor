@extends('admin.layouts.app')

@section('content')
<div class="mx-4 content-p-mobile">
    <div class="page-header-tp">
        <h3>Add New Inventory</h3>
            
        <div class="top-bntspg-hdr">
            <a href="{{ route('inventory.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
        </div>
    </div>
    <div class="body-content-new">
        <form action="{{ route('inventory.store') }}" method="POST">
            @csrf
           
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
                <input type="hidden" name="product_id" value="{{ $products->id }}">
                <div class="content-body">
                    <div class="table-responsive">
                        
                        <table class="table table-striped table-bordered align-middle">
                            <thead class="thead-light">
                                <tr>
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
                                    <th scope="col">
                                        {{ __('Product') }}
                                    </th>
                                    <th scope="col" class="text-center"><input type="date" class="form-control" value="<?php echo date('Y-m-d');?>"></th>
                                    <th scope="col" class="text-center"><input type="text" class="form-control" name="waybill" value=""></th>
                                    <th scope="col" class="text-center"><input type="number" class="form-control" name="quantity"  id="enter_quantity" value=""></th>
                                </tr>
                              @foreach($products->inventories as $product)
                                <tr class="totals">
                                    <th scope="col">
                                        {{ $products->title }}
                                    </th>
                                    @php
                                    $dateTime = new DateTime($product->created_at);
                                    $formattedDate = $dateTime->format('M j, Y, g:i:s A');
                                    @endphp
                                    <th scope="col" class="text-center">{{ $formattedDate }}</th>
                                    <th scope="col" class="text-center">{{ $product->waybill }}</th>
                                    <th scope="col" class="text-center">{{ $product->quantity }}</th>
                                    
                                </tr>
                                @endforeach
                                
                                <tr>
                                    <td colspan="3" class="text-end">Total Inventory</td>
                                    <td class="text-center total" id="total">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end">Order Recived</td>
                                    <td class="text-center recived" id="recived">
                                        @php $totalrecived = 0; @endphp
                                        @foreach($products->orderdetails as $order)
                                        @php 
                                        $totalrecived += $order->quantity;
                                        @endphp
                                        @endforeach
                                        {{$totalrecived}}
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td colspan="3" class="text-end">Current Inventory</td>
                                    <td class="text-center total" id="current_total">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            
            <div class="card-ftr text-center mt-4">
                <button type="submit" class="btn btn-success add-list mx-1">
                    {{ __('Create Inventory') }}
                </button>
            </div>
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
       var recived =  parseFloat(recivedelement.innerHTML) || 0;
        var totalElement = document.getElementById('total');
        var total = 0;

        // Iterate through each row with the class 'totals' and sum up the prices
        var totalRows = document.querySelectorAll('.table tbody tr.totals');
        totalRows.forEach(function(row) {
            var priceCell = row.querySelector('.text-center:nth-child(4)'); // Assuming buying_price is in the fourth column
            var price = parseFloat(priceCell.textContent) || 0;
            total += price;
        });
         var final = total - recived;
        // Update the total price in the designated element
        totalElement.textContent = total.toFixed(2); // Adjust as needed

        var currenttotalElement = document.getElementById('current_total');
        currenttotalElement.textContent = final.toFixed(2);
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
            var priceCell = row.querySelector('.text-center:nth-child(4)'); // Assuming buying_price is in the fourth column
            var price = parseFloat(priceCell.textContent) || 0;
            maintotal += price;
        });

        var recived = document.getElementById('recived');
       var recivedqun = parseFloat(recived.innerHTML) || 0;
        total.innerHTML = inputValue + maintotal;
        var finaltotal = inputValue + maintotal - recivedqun;
        var currenttotalElement = document.getElementById('current_total');
        currenttotalElement.textContent = finaltotal.toFixed(2);
    });
</script>
@endsection
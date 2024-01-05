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
        @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
            <li class="alert alert-danger">{{ $error }}</li>
            @endforeach
        </div>
        @endif
        
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
        <form action="{{ route('inventory.store') }}" method="POST">
            @csrf
           
                <div class="row gx-3 mb-3">
                    <?php 
                        // echo "<pre>";
                        //     print_r($products);
                        //     echo "</pre>";
                        ?>
                    <div class="col-md-4">
                        <label class="small mb-1" for="customer_id">
                            {{ __('Product') }}
                            <span class="text-danger">*</span>
                        </label>

                        <select onchange="updateProductFields()" class="select-create-project form-select form-control-solid @error('product_id') is-invalid @enderror" id="product_id" name="product_id">
                            <option selected="" disabled="">
                                Select a Product:
                            </option>

                            @foreach ($products as $product)
                            <option data-product="{{json_encode($product,true)}}" value="{{ $product->id }}" @selected( old('product_id')==$product->id)>
                                {{ $product->title }}
                            </option>
                            @endforeach
                        </select>

                        @error('product_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

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

                                
                                <tr id="form_row">
                                    <th scope="col">
                                        {{ __('Product') }}
                                    </th>
                                    <th scope="col" class="text-center"><input type="datetime-local" class="form-control" value="<?php echo date('Y-m-d');?>"></th>
                                    <th scope="col" class="text-center"><input type="text" class="form-control" name="waybill" value=""></th>
                                    <th scope="col" class="text-center"><input type="number" class="form-control" name="quantity"  id="enter_quantity" value=""></th>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end">Total Inventory</td>
                                    <td class="text-center total" id="total">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end">Order Recived</td>
                                    <td class="text-center recived" id="recived">
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
    function updateProductFields() {
        document.getElementById('enter_quantity').value = "";
        var removerow = document.getElementsByClassName('totals');
        // Convert HTMLCollection to an array to avoid live updates
        var removerowArray = Array.from(removerow);
        // Remove each element
        removerowArray.forEach(function(element) {
            element.parentNode.removeChild(element);
        });

        var productDropdown = document.getElementById('product_id');
        var selectedProductOption = productDropdown.options[productDropdown.selectedIndex];
        // Extract data attributes from the selected product option
        var productData = selectedProductOption.getAttribute('data-product') || '';
        productData = JSON.parse(productData)
        var tbody = document.querySelector('.table tbody');
        
        $.each(productData.inventories, function(index, element) {
        var newRow = document.createElement('tr');
        newRow.setAttribute("class", "totals");

        var dateObject = new Date(element.created_at);

        // Format the date to a more readable format
        var formattedDate = dateObject.toLocaleString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            second: 'numeric',
        });

        newRow.innerHTML = `
            <td>${selectedProductOption.text}</td>
            <td class="text-center">${formattedDate}</td>
            <td class="text-center">${element.waybill}</td>
            <td class="text-center ">${element.quantity}</td>
        `;
        tbody.insertBefore(newRow, tbody.childNodes[2]);
        });
        // Update corresponding fields based on the selected product
        // document.getElementById('tax').innerHTML = productData.tax;
        document.getElementById('total').innerHTML = parseFloat(productData.tax + productData.quantity);
        // Update more fields as needed
        updateTotalPrice(productData);
    }

    function updateTotalPrice(productData) {
        var recived = 0;
        $.each(productData.orderdetails, function(index, element) {
            recived += element.quantity;
        });
        document.getElementById('recived').innerHTML = recived;

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
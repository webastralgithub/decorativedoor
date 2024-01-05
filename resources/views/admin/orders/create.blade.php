@extends('admin.layouts.app')

@section('content')
<div class="mx-4 content-p-mobile">
    <div class="page-header-tp">
        <h3>Add New Order</h3>
            
        <div class="top-bntspg-hdr">
            <a href="{{ route('orders.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
        </div>
    </div>
    <div class="body-content-new">
        <form action="{{ route('orders.create') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row gx-3 mb-3">
                    <div class="col-md-4">
                        <label for="purchase_date" class="small my-1">
                            {{ __('Date') }}
                            <span class="text-danger">*</span>
                        </label>

                        <input name="purchase_date" id="purchase_date" type="date" class="form-control example-date-input @error('purchase_date') is-invalid @enderror" value="{{ old('purchase_date') ?? now()->format('Y-m-d') }}" required>

                        @error('purchase_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="small mb-1" for="customer_id">
                            {{ __('Customer') }}
                            <span class="text-danger">*</span>
                        </label>

                        <select class="form-select form-control-solid @error('customer_id') is-invalid @enderror" id="customer_id" name="customer_id">
                            <option selected="" disabled="">
                                Select a customer:
                            </option>

                            @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" @selected( old('customer_id')==$customer->id)>
                                {{ $customer->name }}
                            </option>
                            @endforeach
                        </select>

                        @error('customer_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="small mb-1" for="reference">
                            {{ __('Reference') }}
                        </label>

                        <input type="text" class="form-control" id="reference" name="reference" value="ORD" readonly>

                        @error('reference')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="row gx-3 mb-3">

                    <div class="col-md-6">
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
                                <th scope="col" class="text-center">{{ __('Quantity') }}</th>
                                <th scope="col" class="text-center">{{ __('SKU') }}</th>
                                <th scope="col" class="text-center">{{ __('Price') }}</th>
                                <th scope="col" class="text-center">
                                    {{ __('Total') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- <tr>
                                <td colspan="4" class="text-end">Tax</td>
                                <td class="text-center tax" id="tax">
                                </td>
                            </tr> -->
                            <tr>
                                <td colspan="4" class="text-end">Total Product</td>
                                <td class="text-center total" id="total">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                </div>

            </div>
            <div class="card-ftr text-center">
                <button type="submit" class="btn btn-success add-list mx-1">
                    {{ __('Create Order') }}
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
@section('scripts')
<script>
    function updateProductFields() {
        var productDropdown = document.getElementById('product_id');
        var selectedProductOption = productDropdown.options[productDropdown.selectedIndex];
        // Extract data attributes from the selected product option
        var productData = selectedProductOption.getAttribute('data-product') || '';
        productData = JSON.parse(productData)
        var tbody = document.querySelector('.table tbody');
        var newRow = document.createElement('tr');
        newRow.setAttribute("class", "totals");
        newRow.innerHTML = `
            <td>${selectedProductOption.text}</td>
            <td class="text-center">1</td>
            <td class="text-center">${productData.code}</td>
            <td class="text-center">${productData.buying_price}</td>
            <td class="text-center ">${productData.buying_price}</td>
        `;
        tbody.insertBefore(newRow, tbody.firstChild);
        // Update corresponding fields based on the selected product
        // document.getElementById('tax').innerHTML = productData.tax;
        document.getElementById('total').innerHTML = parseFloat(productData.tax + productData.buying_price);
        // Update more fields as needed
        updateTotalPrice();
    }

    function updateTotalPrice() {
        var totalElement = document.getElementById('total');
        var total = 0;

        // Iterate through each row with the class 'totals' and sum up the prices
        var totalRows = document.querySelectorAll('.table tbody tr.totals');
        totalRows.forEach(function(row) {
            var priceCell = row.querySelector('.text-center:nth-child(4)'); // Assuming buying_price is in the fourth column
            var price = parseFloat(priceCell.textContent) || 0;
            total += price;
        });

        // Update the total price in the designated element
        totalElement.textContent = total.toFixed(2); // Adjust as needed
    }
</script>
@endsection
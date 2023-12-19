@extends('admin.layouts.app')

@section('content')
<div class="card mx-4">
    <div class="card-header">
        <div class="float-start">
            Add New Order
        </div>
        <div class="float-end">
            <a href="{{ route('orders.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
        </div>
    </div>
    <div class="card-body">
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
                            <option value="{{ $customer->id }}" @selected( old('customer_id') == $customer->id)>
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

                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">
                                    {{ __('Product') }}
                                </th>
                                <th scope="col" class="text-center">{{ __('Quantity') }}</th>
                                <th scope="col" class="text-center">{{ __('Price') }}</th>
                                <th scope="col" class="text-center">{{ __('SubTotal') }}</th>
                                <th scope="col" class="text-center">
                                    {{ __('Action') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4" class="text-end">
                                    Total Product
                                </td>
                                <td class="text-center">
                                    <!-- {{ Cart::count() }} -->
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-end">Subtotal</td>
                                <td class="text-center">
                                    <!-- {{ Cart::subtotal() }} -->
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-end">Tax</td>
                                <td class="text-center">
                                    <!-- {{ Cart::tax() }} -->
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-end">Tax</td>
                                <td class="text-center">
                                    <!-- {{ Cart::total() }} -->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-success add-list mx-1">
                    {{ __('Create Order') }}
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
@extends('admin.layouts.app')

@section('content')
<div class="mx-4 content-p-mobile">
    <div class="page-header-tp">
        <h3>Products List</h3>
        <div class="top-bntspg-hdr">
            @can('create-product')
            <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm my-2"><i
                    class="bi bi-plus-circle"></i> Add New Product</a>
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
        <div class="input-group category-product-filter">
            <select class="form-select" id="categoryFilter">
                <option value="" selected disabled>Select Category</option>
                @foreach($categories as $category)
                <option value="{{ $category->name }}" {{ request('category')==$category->name ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="table-order">
            <table class="table table-bordered table-striped" id="products">
                <thead>
                    <tr>
                        <th scope="col">Action</th>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">On Hand Quantity</th>
                        <th scope="col">On Order Quantity</th>
                        <th scope="col">Available Quantity</th>
                        <th scope="col">SKU</th>
                        <th scope="col">Price</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                    <tr>
                        <td>
                            <div class="btn-group">
                                <button type="button"
                                    class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="visually-hidden cogs-btn"><i class="fa fa-cog"
                                            aria-hidden="true"></i></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <form action="{{ route('products.destroy', $product->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        @can('edit-product')
                                        <li><a href="{{ route('products.edit', $product->id) }}"
                                                class="dropdown-item"><i class="bi bi-pencil-square"></i> Edit</a></li>
                                        @endcan

                                        @can('delete-product')
                                        <li><button type="submit" class="dropdown-item btn-danger"
                                                onclick="return confirm('Do you want to delete this product?');"><i
                                                    class="bi bi-trash"></i>
                                                Delete</button></li>
                                        @endcan
                                    </form>
                                </ul>
                            </div>
                        </td>
                        <td><a href="{{ route('products.edit', $product->id) }}">{{ $product->title }}</a>
                        </td>
                        <th>{{ $product->category_name }}</th>
                        <th>{{ getProductOnhandAvailabityStock($product->id) }}</th>
                        <th>{{ getProductOnorderAvailabityStock($product->id) }}</th>
                        <th>{{ getProductAvailabityStock($product->id) }}</th>
                        <td>{{ $product->code }}</td>
                        <td>${{ number_format($product->selling_price, 2, '.', ',') }}</td>
                    </tr>
                    @empty
                    <td colspan="4">
                        <span class="text-danger">
                            <strong>No Product Found!</strong>
                        </span>
                    </td>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>    document.addEventListener("DOMContentLoaded", function () {
        var table = new DataTable('#products', {
            pageLength: 50
        });

        $('#categoryFilter').on('change', function () {
            table.search(this.value).draw();
        });
    });
</script>
@endsection
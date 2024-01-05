@extends('admin.layouts.app')

@section('content')
<div class="mx-4 content-p-mobile">
    <div class="page-header-tp">
    <h3>Product List</h3>
    
    <div class="top-bntspg-hdr">
        @can('create-product')
        <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New Product</a>
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

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">Action</th>
                    <th scope="col">Name</th>
                    <th scope="col">Code</th>
                    <th scope="col">Price</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                <tr>
                    <td>
                        <form action="{{ route('products.destroy', $product->id) }}" method="post">
                            @csrf
                            @method('DELETE')

                            <!-- <a href="{{ route('products.show', $product->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a> -->

                            @can('edit-product')
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                            @endcan

                            @can('delete-product')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this product?');"><i class="bi bi-trash"></i> Delete</button>
                            @endcan
                        </form>
                    </td>
                    <td><a href="{{ route('products.edit', $product->id) }}">{{ $product->title }}</a>
                    </td>
                    <td>{{ $product->code }}</td>
                    <td>${{ number_format($product->buying_price, 2, '.', ',') }}</td>
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

        {{ $products->links() }}

    </div>
</div>
@endsection
@extends('admin.layouts.app')

@section('content')

<div class="card mx-4">
    <div class="card-header">
        <div class="float-start">
            Product Information
        </div>
        <div class="float-end">
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
        </div>
    </div>
    <div class="card-body">

        <div class="row">
            <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Name:</strong></label>
            <div class="col-md-6" style="line-height: 35px;">
                {{ $product->title }}
            </div>
        </div>
        <div class="row">
            <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Sub Title:</strong></label>
            <div class="col-md-6" style="line-height: 35px;">
                {{ $product->sub_title }}
            </div>
        </div>
        <div class="row">
            <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Buying Price:</strong></label>
            <div class="col-md-6" style="line-height: 35px;">
                {{ $product->buying_price }}
            </div>
        </div>
        <div class="row">
            <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Quantity:</strong></label>
            <div class="col-md-6" style="line-height: 35px;">
                {{ $product->quantity }}
            </div>
        </div>

        <div class="row">
            <label for="description" class="col-md-4 col-form-label text-md-end text-start"><strong>Description:</strong></label>
            <div class="col-md-6" style="line-height: 35px;">
                {{ $product->notes }}
            </div>
        </div>

    </div>
</div>

@endsection
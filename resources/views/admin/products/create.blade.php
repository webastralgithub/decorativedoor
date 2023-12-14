@extends('admin.layouts.app')

@section('content')

<div class="card mx-4">
    <div class="card-header">
        <div class="float-start">
            Add New Product
        </div>
        <div class="float-end">
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">
                                {{ __('Product Image') }}
                            </h3>
                            <img class="img-account-profile mb-2" src="{{ asset('img/product/default.webp') }}" alt="" id="image-preview" />
                            <div class="small font-italic text-muted mb-2">
                                JPG or PNG no larger than 2 MB
                            </div>
                            <input type="file" accept="image/*" id="image" name="product_images[]" class="form-control @error('product_images') is-invalid @enderror" onchange="previewImage();" multiple>
                            @error('product_images')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h3 class="card-title">
                                    {{ __('Product Create') }}
                                </h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row row-cards">
                                <div class="col-md-12">
                                    <label for="category_id" class="form-label">
                                        Product Title
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input name="title" id="name" class="form-control" placeholder="Product name" value="{{ old('title') }}" />
                                </div>
                                <div class="col-md-12">
                                    <label for="category_id" class="form-label">
                                        Slug
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input name="slug" id="name" class="form-control" placeholder="Product Slug" value="{{ old('slug') }}" />
                                </div>
                                <div class="col-md-12">
                                    <label for="category_id" class="form-label">
                                        Product Code
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input name="product_code" id="name" class="form-control" placeholder="Product Code" value="{{ old('product_code') }}" />
                                </div>
                                <div class="col-md-12">
                                    <label for="category_id" class="form-label">
                                        Sub Title
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input name="sub_title" id="name" class="form-control" placeholder="Sub Title" value="{{ old('sub_title') }}" />
                                </div>
                                <div class="col-md-12">
                                    <label for="category_id" class="form-label">
                                        Meta Title
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input name="meta_title" id="name" class="form-control" placeholder="Meta Title" value="{{ old('meta_title') }}" />
                                </div>
                                <div class="col-md-12">
                                    <label for="category_id" class="form-label">
                                        Meta Keywords
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input name="meta_keywords" id="name" class="form-control" placeholder="Meta Keywords" value="{{ old('meta_keywords') }}" />
                                </div>
                                <div class="col-md-12">
                                    <label for="category_id" class="form-label">
                                        Meta Description
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="meta_description" id="notes" rows="5" class="form-control @error('meta_description') is-invalid @enderror" placeholder="Meta Description"></textarea>
                                </div>

                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">
                                            Product Category
                                            <span class="text-danger">*</span>
                                        </label>

                                        @if ($categories->count() === 1)
                                        <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" readonly>
                                            @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" selected>
                                                {{ $category->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @else
                                        <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                            <option selected="" disabled="">
                                                Select a category:
                                            </option>

                                            @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @if(old('category_id')==$category->id) selected="selected" @endif>
                                                {{ $category->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @endif

                                        @error('category_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-6">
                                    <label for="notes" class="form-label">
                                        {{ __('Buying Price') }}
                                    </label>
                                    <input type="number" label="Buying Price" class="form-control" name="buying_price" id="buying_price" placeholder="0" value="{{ old('buying_price') }}" />
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <label for="notes" class="form-label">
                                        {{ __('Selling Price') }}
                                    </label>
                                    <input type="number" label="Selling Price" class="form-control" name="selling_price" id="buying_price" placeholder="0" value="{{ old('selling_price') }}" />
                                </div>

                                <div class="col-sm-6 col-md-6">
                                    <label for="notes" class="form-label">
                                        {{ __('Notes') }}
                                    </label>
                                    <input type="number" label="Selling Price" class="form-control" name="selling_price" id="selling_price" placeholder="0" value="{{ old('selling_price') }}" />
                                </div>

                                <div class="col-sm-6 col-md-6">
                                    <label for="notes" class="form-label">
                                        {{ __('Quantity') }}
                                    </label>
                                    <input type="number" label="Quantity" class="form-control" name="quantity" id="quantity" placeholder="0" value="{{ old('quantity') }}" />
                                </div>

                                <div class="col-sm-6 col-md-6">
                                    <label for="notes" class="form-label">
                                        {{ __('Quantity Alert') }}
                                    </label>
                                    <input type="number" label="Quantity Alert" class="form-control" name="quantity_alert" id="quantity_alert" placeholder="0" value="{{ old('quantity_alert') }}" />
                                </div>

                                <div class="col-sm-6 col-md-6">
                                    <label for="notes" class="form-label">
                                        {{ __('Tax') }}
                                    </label>
                                    <input type="number" label="Tax" name="tax" class="form-control" id="tax" placeholder="0" value="{{ old('tax') }}" />
                                </div>

                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="tax_type">
                                            {{ __('Tax Type') }}
                                        </label>
                                        <select name="tax_type" id="tax_type" class="form-select @error('tax_type') is-invalid @enderror">
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                        @error('tax_type')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="notes" class="form-label">
                                            {{ __('Notes') }}
                                        </label>

                                        <textarea name="notes" id="notes" rows="5" class="form-control @error('notes') is-invalid @enderror" placeholder="Product notes"></textarea>
                                        @error('notes')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-end">
                            <div class="mb-3 row">
                                <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="{{ __('Save') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection